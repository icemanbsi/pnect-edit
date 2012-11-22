<?php

class WNetworkInviteMenu extends UMenuWorklet {

	public $space = 'outside';

	public function accessRules() {
		return array(
			array('deny', 'users' => array('?'))
		);
	}

	public function properties() {
		return array('items' => array(
			array('label' => $this->t('Email'), 'url' => array('/network/invite')),
		));
	}

}