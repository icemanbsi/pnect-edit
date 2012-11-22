<?php

class WInstallAppUpgrade_1_1_0 extends UInstallWorklet {

	public $fromVersion = '1.0.5';
	public $toVersion = '1.1.0';

	public function getModule() {
		return app();
	}

}