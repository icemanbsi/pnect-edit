<?php

class WBoardAdminParams extends UParamsWorklet {

	public function accessRules() {
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users' => array('*'))
		);
	}

	public function properties() {
		return array(
			'elements' => array(
				'newBoards' => array('type' => 'textarea', 'label' => $this->t('Default Boards'),
					'hint' => $this->t('One board name per line')),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Save'))
			),
			'model' => $this->model
		);
	}

}