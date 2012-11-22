<?php
class WPictureShareIgnore extends UDeleteWorklet
{
	public $modelClassName = array(
		'MPictureReport' => 'id',
	);
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
}