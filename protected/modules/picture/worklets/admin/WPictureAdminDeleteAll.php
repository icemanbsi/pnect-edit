<?php
class WPictureAdminDeleteAll extends UDeleteWorklet
{
	public $modelClassName = 'MPicture';
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function beforeDelete($id)
	{
		$picture = MPicture::model()->findByPk($id);
		$posts = MPicturePost::model()->findAll('pictureId=?', array($id));
		foreach($posts as $p)
			wm()->get('picture.delete')->delete($p->id);
		wm()->get('base.helper')->bin($picture->bin)->purge();
	}
}