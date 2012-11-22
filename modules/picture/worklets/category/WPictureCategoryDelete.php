<?php
class WPictureCategoryDelete extends UDeleteWorklet
{
	public $modelClassName = array(
		'MPictureCategory' => 'id',
	);
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
}