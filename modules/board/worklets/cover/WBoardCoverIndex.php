<?php

class WBoardCoverIndex extends UFormWorklet {

	public $modelClassName = 'MBoardCoverForm';
	public $post;

	public function accessRules() {
		return array(
			array('deny', 'users' => array('?'))
		);
	}

	public function title() {
		return $this->t('Select a cover photo');
	}

	public function taskBoard() {
		static $board;
		if (!$board && isset($_GET['boardId']))
			$board = MBoard::model()->findByPk($_GET['boardId']);
		return $board;
	}

	public function taskConfig() {
		if (isset($_GET['postId']))
			$this->post = MPicturePost::model()->findByPk($_GET['postId']);

		if ($this->board() && !$this->post) {
			$c = new CDbCriteria;
			$c->compare('boardId', $this->board()->id);
			$c->order = '`t`.`id`';
			$c->limit = 1;
			$this->post = MPicturePost::model()->find($c);
		}
		if (!$this->post) {
			$this->show = false;
			app()->request->redirect(url('/picture/options'));
		}
		parent::taskConfig();
	}

	public function properties() {
		return array(
			'class' => 'loaded',
			'elements' => array(
				'boardId' => array('type' => 'hidden', 'value' => $this->board()->id),
				'postId' => array('type' => 'hidden', 'value' => $this->post->id),
				$this->render('board', array('data' => $this->board(), 'cover' => $this->post->picture->imageBin), true),
			),
			'model' => $this->model
		);
	}

	public function taskSave() {
		if ($this->model->postId) {
			$post = MPicturePost::model()->findByPk($this->model->postId);
			$this->board()->cover = $post->picture->bin;
			$this->board()->save();
		}
	}

	public function ajaxSuccess() {
		wm()->get('base.init')->addToJson(array(
			'content' => array(
				'append' => CHtml::script('window.location="' . app()->user->model()->Url . '";'),
			)
		));
	}

	public function taskRenderOutput() {
		if ($this->post) {
			parent::taskRenderOutput();
			cs()->registerScript(__CLASS__, '$.uniprogy.cover.init();');
		}
	}

}
