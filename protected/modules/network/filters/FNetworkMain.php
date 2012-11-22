<?php
class FNetworkMain extends UWorkletFilter
{	
	public function filters()
	{
		return array(
			'admin.menu' => array('behaviors' => array('network.adminMenu')),
			'user.helper' => array('behaviors' => array('network.userHelper')),
			'base.init' => array('behaviors' => array('network.rules')),
			'user.admin.delete' => array('behaviors' => array('network.userDelete')),
		);
	}
	
}