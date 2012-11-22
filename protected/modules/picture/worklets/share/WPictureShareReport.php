<?php

class WPictureShareReport extends UFormWorklet {

	public $modelClassName = 'MPictureReport';
	public $primaryKey = 'id';

	public function title() {
		return m('picture')->t('Report {#post_n_ucf}');
	}

	public function taskPost() {
		static $post;
		if (!$post)
			$post = MPicturePost::model()->findByPk($_GET['post']);
		return $post;
	}

	public function taskConfig() {
		if (!$this->post())
			$this->show = false;
		parent::taskConfig();
	}

	public function afterConfig() {
		$this->model->postId = $this->post()->id;
		$this->model->userId = app()->user->id;
	}

	public function properties() {

		return array(
			'elements' => array(
				$this->t('Why are you reporting this {#post_n_ucf}?'),
				'reportType' => array(
					'type' => 'radiolist',
					'items' => wm()->get('picture.share.helper')->reportTypeAsList(),
					'layout' => "<fieldset>{input}\n{hint}</fieldset>",
				)
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => m('picture')->t('Report {#post_n_ucf}')),
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
				'replace' => $this->t('Thank you for reporting this {#post_n_ucf} to us!'),
			),
			'content' => array('replace' => '<!-- -->')
		));
	}

}