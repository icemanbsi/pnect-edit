<?php
class WNetworkFollowing extends UListWorklet
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
		$this->model->userId = $this->user()->id;
		$this->options['template'] = "{items}\n{pager}";
	}
	
	public function itemView()
	{
		return 'following';
	}
	
	public function title()
	{
		return $this->t('Users {user} Follows', array(
			'{user}' => $this->user()->name
		));
	}
}