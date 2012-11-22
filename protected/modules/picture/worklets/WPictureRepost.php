<?php
class WPictureRepost extends UFormWorklet
{
	public $images;
	public $space = 'inside';
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function beforeConfig()
	{
		if(isset($_GET['postId']))
		{
			$post = MPicturePost::model()->findByPk($_GET['postId']);
			if($post)
			{
				$this->images = array($post->img);
				return;
			}
		}
		return $this->show = false;
	}
	
	public function title()
	{
		return $this->t('{#repost_ucf}');
	}
	
	public function afterBuild()
	{
		$w = wm()->add('picture.post', null,
			array('position' => array('after' => $this->id)));
		$w->model->parentId = $_GET['postId'];
	}
	
	public function afterRenderOutput()
	{
		cs()->registerScript('$.uniprogy.picture.post.load',
				'$.uniprogy.picture.post.load('.CJavaScript::jsonEncode($this->images).',"");');
	}
}