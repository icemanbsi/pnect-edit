<?php
class WPictureLike extends UWidgetWorklet
{
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function taskConfig()
	{
		if(isset($_GET['postId']))
		{
			$m = MPictureLike::model()->find('postId=? and userId=?',array($_GET['postId'],app()->user->id));
			$like = $this->t('Like');
			if(!$m)
			{
				$like = $this->t('Unlike');
				$m = new MPictureLike;
				$m->postId = $_GET['postId'];
				$m->userId = app()->user->id;
				$m->created = time();
				$m->save();
				
				wm()->get('picture.event')->like($_GET['postId']);
			}
			else
				$m->delete();

			wm()->get('picture.helper')->updateStats($_GET['postId'], 'likes');
			if(app()->request->isAjaxRequest)
				wm()->get('base.init')->addToJson(array('like' => $like));
			else
				app()->request->redirect(url('/picture/view', array('id' => $_GET['postId'])));
		}
	}
}

