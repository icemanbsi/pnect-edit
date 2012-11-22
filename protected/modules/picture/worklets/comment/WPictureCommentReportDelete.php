<?php
class WPictureCommentReportDelete extends UDeleteWorklet
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
	
	public function beforeDelete($id)
	{
		$model = MPictureCommentReport::model()->findByPk($id);
		if($model)
		{
			wm()->get('picture.comment.delete')->delete($model->commentId);
		}
	}
}