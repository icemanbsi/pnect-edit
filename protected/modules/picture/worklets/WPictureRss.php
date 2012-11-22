<?php
class WPictureRss extends UWidgetWorklet
{
	public $user;
	public $posts;
	public $layout = false;
	
	public function taskLink($user)
	{
		return aUrl('/picture/rss',array('username' => $user->username));
	}
	
	public function taskConfig()
	{
		if(isset($_GET['username'])){
			$this->user = MUser::model()->find('username=?',array($_GET['username']));
			$c = new CDbCriteria;
			$c->limit = 20;
			$c->compare('userId',$this->user->id);
			$c->order = '`created` DESC';
			$this->posts = MPicturePost::model()->findAll($c);		
		}
		
		wm()->get('base.init')->renderType = 'ajax-no-scripts';
		parent::taskConfig();
	}
	
	public function taskRenderOutput()
	{
		Header('Content-Type:text/xml; charset=UTF-8');
		$this->render('rss');
	}
}