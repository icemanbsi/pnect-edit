<?php

class WInstallAppUpgrade_1_0_4 extends UInstallWorklet {

	public $fromVersion = '1.0.3';
	public $toVersion = '1.0.4';

	public function getModule() {
		return app();
	}

}