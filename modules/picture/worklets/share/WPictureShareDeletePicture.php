<?php
class WPictureShareDeletePicture extends UDeleteWorklet
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
		if($report->post)
			wm()->get('picture.admin.deleteAll')->delete($report->post->pictureId);
	}
}