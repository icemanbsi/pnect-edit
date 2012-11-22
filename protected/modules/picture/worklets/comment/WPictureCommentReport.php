<?php

class WPictureCommentReport extends UFormWorklet {

	public $modelClassName = 'MPictureCommentReport';

	public function title() {
		return m('picture')->t('Report Comment');
	}

	public function afterConfig() {
		$this->model->commentId = $_GET['id'];
		$this->model->userId = app()->user->id;
	}

	public function properties() {

		return array(
			'elements' => array(
				$this->t('Why are you reporting this comment?'),
				'reportType' => array(
					'type' => 'radiolist',
					'items' => wm()->get('picture.comment.helper')->reportTypeAsList(),
					'layout' => "<fieldset>{input}\n{hint}</fieldset>",
				)
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => m('picture')->t('Report Comment')),
			),
			'model' => $this->model);
	}

	public function beforeBuild() {
		if (app()->user->isGuest)
			$this->attachBehavior('base.captcha', 'base.captcha');
	}

	public function ajaxSuccess() {
		wm()->get('base.init')->addToJson(array(
			'info' => array(
				'replace' => $this->t('Thank you for reporting this comment to us!'),
			),
			'content' => array('replace' => '<!-- -->')
		));
	}

}