<?php

class WGiftAdminParams extends UParamsWorklet {

	public function taskRenderOutput() {
		parent::taskRenderOutput();
		app()->controller->worklet('gift.menu.list');
	}

	public function accessRules() {
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users' => array('*'))
		);
	}

	public function properties() {
		return array(
			'elements' => array(
				'symbol' => array('type' => 'text', 'class' => 'short', 'label' => $this->t('Symbol')),
				'template' => array('type' => 'text', 'label' => $this->t('Template')),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Save'))
			),
			'model' => $this->model
		);
	}

}