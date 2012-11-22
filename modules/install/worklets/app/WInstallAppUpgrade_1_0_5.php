<?php

class WInstallAppUpgrade_1_0_5 extends UInstallWorklet {

	public $fromVersion = '1.0.4';
	public $toVersion = '1.0.5';

	public function getModule() {
		return app();
	}

}