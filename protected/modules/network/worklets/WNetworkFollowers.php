<?php
class WNetworkFollowers extends UListWorklet
{
	public $modelClassName = 'MNetworkFollowUser';
	public $type = 'list';
	
	public function beforeConfig()
	{
		if(!$this->user())
			throw new CHttpException(404, $this->t('Page not found.'));
	}
	
	public function taskUser()
	{
		static $u;
		if(!isset($u))
			$u = isset($_GET['username'])
			? MUser::model()->find('username=?', array($_GET['username']))
			: null;
		return $u;
	}
	
	public function afterConfig()
	{
		$this->model->followUserId = $this->user()->id;
		$this->options['template'] = "{items}\n{pager}";
	}
	
	public function itemView()
	{
		return 'follower';
	}
	
	public function title()
	{
		return $this->t('{user}\'s Followers', array(
			'{user}' => $this->user()->name
		));
	}
}