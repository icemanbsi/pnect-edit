<?php

class WPictureView extends UWidgetWorklet {

	public $post;

	public function accessRules() {
		return array(array('allow', 'users' => array('*')));
	}

	public function taskConfig() {
		if (isset($_GET['id']))
			$this->post = MPicturePost::model()->findByPk($_GET['id']);

		if (!$this->post)
			throw new CHttpException(404, $this->t('The requested page does not exist.'));

		wm()->add('picture.share.menu', null, array('post' => $this->post));

		parent::taskConfig();

		wm()->add('board.side', null, array('board' => MBoard::model()->findByPk($this->post->boardId)));
		wm()->add('picture.more', null, array('post' => $this->post));
	}

	public function taskRenderOutput() {
		$this->render('post', array('post' => $this->post));
		app()->controller->worklet('picture.comment.list', array('postId' => $this->post->id, 'asView' => 1));
		app()->controller->worklet('picture.likes.list', array('postId' => $this->post->id));
		app()->controller->worklet('picture.reposts.list', array('postId' => $this->post->id));

		if ($this->post->img)
			cs()->registerLinkTag('image_src', null, $this->post->img);
	}

	public function taskContent() {
		if ($this->post->img) {
			$link = CHtml::image($this->post->img);
			if ($this->post->source)
				$link = CHtml::link($link, $this->post->source, array('target' => '_blank'));
			return $link;
		}
	}

	public function meta() {
		$md = parent::meta();
		if ($this->post)
			$md['title'] = html_entity_decode($this->post->message);
		return $md;
	}

}