<?php

class WPictureCommentAdd extends UFormWorklet {

	public $modelClassName = 'MPictureCommentAdd';
	public $space = 'inside';
	public $postId;
	public $listId;
	public $asView;
	public $enableAjax = false;

	public function beforeBuild() {
		$this->properties = array();
		$this->form = null;
		$this->model = null;
	}

	public function accessRules() {
		return array(
			array('deny', 'users' => array('?'))
		);
	}

	public function taskModel() {
		$m = parent::taskModel();
		$m->postId = isset($_GET['postId']) ? $_GET['postId'] : $this->postId;
		$m->listId = isset($_GET['listId']) ? $_GET['listId'] : $this->listId;
		$m->asView = isset($_GET['asView']) ? $_GET['asView'] : $this->asView;
		return $m;
	}

	public function properties() {
		$left = m('picture')->params['commentLength'] ? m('picture')->params['commentLength'] : 500;
		return array(
			'activeForm' => array(
				'class' => 'UActiveForm',
				'clientOptions' => array('hideErrorMessage' => true),
				'ajax' => $this->enableAjax,
			),
			'class' => 'pictureCommentAdd',
			'action' => url('/picture/comment/add', array('postId' => $this->model()->postId, 'listId' => $this->model()->listId, 'asView' => $this->model()->asView)),
			'elements' => array(
				CHtml::tag('div', array('class' => 'CommentLeft'), $this->t('{num} left',array('{num}'=>$left))),
				'text' => array('type' => 'textarea',
					'label' => $this->render('avatar', array('model' => app()->user->model()), true),
					'attributes' => array(
						'maxlength' => $left,
						'placeholder' => $this->t('Add a comment...')
					),
					'afterLabel' => '',
					//'hint' => $this->t('Type @ to recommend this {#post_n} to another person.'),
					'required' => false),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => $this->isNewRecord ? $this->t('Post') : $this->t('Update')),
			),
			'model' => $this->model()
		);
	}

	public function taskSave() {
		$this->model()->userId = app()->user->id;
		$this->model()->created = time();
		parent::taskSave();

		wm()->get('picture.event')->comment($_GET['postId']);
		wm()->get('picture.helper')->updateStats($_GET['postId'], 'comments');
	}

	public function ajaxSuccess() {
		$json = array(
			'content' => array(
				'append' => CHtml::script('$("#' . $this->model()->listId . ' form").get(0).reset();'),
			),
			'worklet' => array(
				'content' => array('appendReplace' =>
					CHtml::script('$.fn.yiiListView.update("' . $this->model()->listId . '-list");'))),
		);

		wm()->get('base.init')->addToJson($json);
	}

	public function getDOMId() {
		return parent::getDOMId() . ($this->model()->asView ? '-view' : '') . '-' . $this->model()->postId;
	}

	public function afterCreateForm() {
		$this->form->setId($this->form->getId() . ($this->model()->asView ? '-view' : '') . '-' . $this->model()->postId);
	}

}