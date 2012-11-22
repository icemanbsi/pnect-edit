<?php

class WNetworkRequestInvite extends UFormWorklet {

	public $modelClassName = 'MNetworkRequestForm';

	public function title() {
		return $this->t('Request Invitation to Join {site}', array(
					'{site}' => app()->name
				));
	}

	public function properties() {
		return array(
			'elements' => array(
				'email' => array('type' => 'text'),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => $this->t('Request Invitation'))
			),
			'model' => $this->model
		);
	}

	public function beforeSave() {
		$this->model->created = time();
		if ($this->module->params['notifyEmail'])
			app()->mailer->send($this->module->params['notifyEmail'], 'notifyAdimEmail', array(
				'email' => $this->model->email,
				'link' => aUrl('/network/request/list'),
			));
	}

	public function ajaxSuccess() {
		wm()->get('base.init')->addToJson(array(
			'info' => array(
				'replace' => $this->t('Thank you for subscribing to {site} invitations. We will send your invite soon!', array(
					'{site}' => app()->name
				)),
				'focus' => true
			),
			'content' => array(
				'replace' => '<!-- -->',
			),
		));
	}

}