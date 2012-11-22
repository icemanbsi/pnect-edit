<?php

class WInstallAppUpgrade_1_1_1 extends UInstallWorklet {

	public $fromVersion = '1.1.0';
	public $toVersion = '1.1.1';

	public function getModule() {
		return app();
	}

	public function taskSuccess() {
		$config = require(app()->basePath . DS . 'config' . DS . 'public' . DS . 'modules.php');
		$poweredBy = $config['params']['poweredBy'];
		$config['params']['poweredBy'] = array(app()->language => $poweredBy);
		UHelper::saveConfig(app()->basePath . DS . 'config' . DS . 'public' . DS . 'modules.php', $config);
		parent::taskSuccess();
	}

}