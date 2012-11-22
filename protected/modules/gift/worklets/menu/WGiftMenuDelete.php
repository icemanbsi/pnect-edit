<?php
class WGiftMenuDelete extends UDeleteWorklet
{	
	public $modelClassName = 'MGiftMenuForm';
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
}