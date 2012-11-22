<?php
class WPictureDelete extends UDeleteWorklet
{
	public $modelClassName = array(
		'MPicturePost' => 'id',
		'MPictureComment' => 'postId',
		'MPictureLike' => 'postId',
		'MPictureReport' => 'postId'
	);
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function beforeDelete($id)
	{
		$post = $this->post($id);
		if(!app()->user->checkAccess('post.edit', $post, false))
		{
			$this->accessDenied();
			return false;
		}
	}
	
	public function taskPost($id)
	{
		static $ms = array();
		if(!isset($ms[$id]))
			$ms[$id] = MPicturePost::model()->findByPk($id);
 		return $ms[$id];
	}
	
	public function taskDelete($id)
	{
		$parentId = $this->post($id)?$this->post($id)->parentId:null;
		parent::taskDelete($id);
		if($parentId)
			wm()->get('picture.helper')->updateStats($parentId,'reposts');
	}
}