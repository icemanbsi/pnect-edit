<?php
class BNetworkAdminMenu extends UWorkletBehavior
{
	public function afterConfig()
	{
		$this->getOwner()->insertBefore('Logout',array(
			array('label'=>$this->t('Invitation Requests'), 'url'=>array('/network/request/list'),
				'visible' => app()->user->checkAccess('administrator')),
		));
	}
}