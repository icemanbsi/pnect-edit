<?php
class WInstallAppUpgrade_1_1_2 extends UInstallWorklet
{
	public $fromVersion = '1.1.1';
	public $toVersion = '1.1.2';
	
	public function getModule() {
		return app();
	}

}