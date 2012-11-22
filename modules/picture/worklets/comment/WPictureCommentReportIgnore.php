<?php
class WPictureCommentReportIgnore extends UDeleteWorklet
{
	public $modelClassName = array(
		'MPictureCommentReport' => 'id',
	);
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
}