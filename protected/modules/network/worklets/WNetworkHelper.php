<?php
class WNetworkHelper extends USystemWorklet
{	
	public function taskAutoFollow($board)
	{
		$followers = MNetworkFollowUser::model()->findAll('followUserId=?',array($board->userId));
		foreach ($followers as $user)
			$this->followBoard($user,$board);
	}
	
	public function taskIsFollowingUser($user,$follow)
	{
		return MNetworkFollowUser::model()->exists('userId=? AND followUserId=?',
			array($user->id,$follow->id));
	}
	
	public function taskIsFollowingBoard($user,$board)
	{
		return MNetworkFollowBoard::model()->exists('userId=? AND boardId=?',
			array($user->id,$board->id));
	}
	
	public function taskFollowBoard($user,$board,$event=true)
	{
		if($this->isFollowingBoard($user,$board))
			return;
		
		$m = new MNetworkFollowBoard;
		$m->userId = $user->id;
		$m->boardId = $board->id;
		$m->save();
		
		if($event)
			wm()->get('network.event')->followBoard($user,$board);
	}
	
	public function taskUnfollowBoard($user,$board)
	{
		MNetworkFollowBoard::model()->deleteAll('userId=? AND boardId=?', array(
			$user->id, $board->id
		));
	}
	
	public function taskFollowUser($user,$follow)
	{
		if($this->isFollowingUser($user,$follow))
			return;
		
		$m = new MNetworkFollowUser;
		$m->userId = $user->id;
		$m->followUserId = $follow->id;
		$m->save();
		
		$boards = MBoard::model()->findAll('userId=?',array($follow->id));
		foreach($boards as $b)
			$this->followBoard($user,$b,false);
		
		wm()->get('network.event')->followUser($user,$follow);
	}
	
	public function taskUnfollowUser($user,$follow)
	{
		MNetworkFollowUser::model()->deleteAll('userId=? AND followUserId=?', array(
			$user->id, $follow->id
		));
		
		$boards = MBoard::model()->findAll('userId=?',array($follow->id));
		foreach($boards as $b)
			$this->unFollowBoard($user,$b);
	}
	
	public function taskFollow($user,$follow=null,$board=null)
	{		
		$isFollowing = false;
		if($follow)
		{
			// follow or unfollow
			$isFollowing = $this->isFollowingUser($user,$follow);
			
			if(!$isFollowing)
				$this->followUser($user,$follow);
			else
				$this->unFollowUser($user,$follow);
		}
		elseif($board)
		{
			// follow or unfollow
			$isFollowing = $this->isFollowingBoard($user,$board);
			
			if(!$isFollowing)
				$this->followBoard($user,$board);
			else
				$this->unFollowBoard($user,$board);
		}
		return $isFollowing
			? ($follow?$this->t('Follow All'):$this->t('Follow'))
			: ($follow?$this->t('Unfollow All'):$this->t('Unfollow'));
	}

	public function taskFollowLink($follow=null, $board=null)
	{
		$user = app()->user->model();
		if(!$user)
			return '';
		
		cs()->registerScriptFile(asma()->publish(Yii::getPathOfAlias('network.js.network').'.follow.js'));
		cs()->registerScript(__CLASS__,'$.uniprogy.networkFollow.init();');
		
		$word = $follow
			? ($this->isFollowingUser($user,$follow) ? $this->t('Unfollow All') : $this->t('Follow All'))
			: ($this->isFollowingBoard($user,$board) ? $this->t('Unfollow') : $this->t('Follow'));
		
		$params = $follow
			? array('username' => $follow->username)
			: array('board' => $board->id);
		
		return CHtml::link($word, url("/network/follow",$params), array(
			'class' => 'follow'
		));
	}
	
	public function taskStats($id,$type)
	{
		switch($type)
		{
			case 'followers':
				return MNetworkFollowUser::model()->count('followUserId=?', array($id));
			case 'boardFollowers':
				return MNetworkFollowBoard::model()->count('boardId=?', array($id));
			case 'following':
				return MNetworkFollowUser::model()->count('userId=?', array($id));
		}
	}
	
	public function taskUserInvites($id)
	{
		static $d = array();
		if(!isset($d[$id]))
			$d[$id] = MNetworkInvite::model()->count('userId=? AND created > ?', array(
				$id, (time()-24*3600)
			));
		return $d[$id];
	}
	
	public function taskInvited($email,$id=0,$recent=false)
	{
		$c = new CDbCriteria;
		$c->condition = 'email=:e AND userId=:u';
		$c->params = array(':e' => $email, ':u' => $id);
		
		if($recent)
			$c->addCondition('created > ' . (time() - $this->param('inviteTimeLimit')*3600));
		
		return MNetworkInvite::model()->find($c) || MUser::model()->find('email=?',array($email));
	}

	public function taskInvite($email,$id=0)
	{
		if(!($invite = $this->invited($email,$id)))
		{	
			// hash
			$model = new MHash;
			$model->hash = UHelper::hash();
			$model->type = 10;
			$model->id   = $id;
			$model->expire = 0;
			$model->save();

			// invite
			$invite = new MNetworkInvite;
			$invite->userId = $id;
			$invite->email = $email;
			$invite->hash = $model->hash;
			$invite->created = time();
			$invite->save();
		}
		
		return $invite;
	}
	
	public function taskValidInvite($hash)
	{
		return MHash::model()->find('hash=? AND type=?', array($hash, 10));
	}
}