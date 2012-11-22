<?php
class WNetworkInstallUpgrade_1_1_0 extends UInstallWorklet
{
	public $fromVersion = '1.0.5';
	public $toVersion = '1.1.0';
	
	public function taskModuleParams() {
		return CMap::mergeArray(parent::taskModuleParams(), array(
					'notifyEmail' => '',
				));
	}
}