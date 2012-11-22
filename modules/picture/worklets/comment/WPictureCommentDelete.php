<?php
class WPictureCommentDelete extends UDeleteWorklet
{	
	public $modelClassName = 'MPictureComment';
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function taskComment($id)
	{
		static $ms=array();
		if(!isset($ms[$id]))
			$ms[$id] = MPictureComment::model()->findByPk($id);
		return $ms[$id];
	}
	
	public function beforeDelete($id)
	{
		if(!app()->user->checkAccess('administrator')
				&&(!$this->comment($id) || $this->comment($id)->userId != app()->user->id))
		{
			$this->accessDenied();
			return false;
		}
	}

	public function taskDelete($id)
	{
		$comment = $this->comment($id);
		$postId = $comment->postId;
		
		parent::taskDelete($id);

		if($postId)
			wm()->get('picture.helper')->updateStats($postId, 'comments');
	}
}