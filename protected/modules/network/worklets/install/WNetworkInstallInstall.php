<?php
class WNetworkInstallInstall extends UInstallWorklet
{
	public function taskModuleParams()
	{
		return CMap::mergeArray(parent::taskModuleParams(),array (
			'invitesPerDay' => '100',
			'inviteTimeLimit' => '24',
			'notifyEmail' => '',
		));
	}
	
	public function taskModuleFilters()
	{
		return array(
			'user' => 'network.main',
			'admin' => 'network.main',
		);
	}
}