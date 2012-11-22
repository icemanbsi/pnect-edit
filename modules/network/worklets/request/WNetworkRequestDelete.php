<?php
class WNetworkRequestDelete extends UDeleteWorklet
{	
	public $modelClassName = 'MNetworkRequest';
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
}