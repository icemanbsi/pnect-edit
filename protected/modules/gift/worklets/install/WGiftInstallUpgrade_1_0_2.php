<?php
class WGiftInstallUpgrade_1_0_2 extends UInstallWorklet
{
	public $fromVersion = '1.0.1';
	public $toVersion = '1.0.2';
	
	public function taskModuleParams()
	{
		$param = m('gift')->param('tamplate');
		if(!$param)
			$param = '{symbol}{price}';
		return CMap::mergeArray(parent::taskModuleParams(),array (
			'template' => $param,
		));
	}
	
}