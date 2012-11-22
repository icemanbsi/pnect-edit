<?php
class WPictureShareDeletePost extends UDeleteWorklet
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
	
	public function beforeDelete($id)
	{
		$report = MPictureReport::model()->findByPk($id);
		wm()->get('picture.delete')->delete($report->postId);
	}
}