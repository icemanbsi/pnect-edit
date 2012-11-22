<?php
class WBaseInstallInstall extends UInstallWorklet
{	
	public function taskModuleFilters()
	{
		return array(
			'base' => 'base.main',
		);
	}
	
	public function taskModuleParams()
	{
		return CMap::mergeArray(parent::taskModuleParams(),array (
			'languages' => array(
				'en_us' => 'English (US)',
			),
		));
	}
}