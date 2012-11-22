<?php
class WPictureEvent extends USystemWorklet
{
	public function taskManager()
	{
		static $m;
		if(!isset($m))
			$m = wm()->get('network.eventManager');
		return $m;
	}
	
	public function taskPost($id,$userId=null)
	{
		$userId = $userId?$userId:app()->user->id;
		$this->manager()->add(
			$userId,
			'picture',
			'post',
			array('post' => $id)
		);
	}
	
	public function taskRepost($post,$repost,$userId=null)
	{
		$userId = $userId?$userId:app()->user->id;
		$this->manager()->add(
			$userId,
			'picture',
			'repost',
			array('post' => $post, 'repost' => $repost)
		);
		$this->manager()->mail('repost',$userId,$post);
	}
	
	public function taskLike($id,$userId=null)
	{
		$userId = $userId?$userId:app()->user->id;
		$this->manager()->add(
			$userId,
			'picture',
			'like',
			array('post' => $id)
		);
		$this->manager()->mail('like',$userId,$id);
	}
	
	public function taskComment($id,$userId=null)
	{
		$userId = $userId?$userId:app()->user->id;
		$this->manager()->add(
			$userId,
			'picture',
			'comment',
			array('post' => $id)
		);
		$this->manager()->mail('comment',$userId,$id);
	}
	
	public function taskRead($userId,$type,$params)
	{
		$user = wm()->get('user.helper')->user($userId);
		$data = array();
		switch($type)
		{
			case 'post':
				$post = MPicturePost::model()->findByPk($params['post']);
				if(!$post)
					return false;
				$data['image'] = $post->small;
				$data['message'] = $this->t('{who} {#posted} {what} to {where}.', array(
					'{who}' => $user->name,
					'{what}' => CHtml::link($post->message,url('/picture/view', array('id' => $post->id))),
					'{where}' => CHtml::link($post->board->title,$post->board->link)
				));
				break;
				
			case 'repost':
				$post = MPicturePost::model()->findByPk($params['post']);
				$repost = MPicturePost::model()->findByPk($params['repost']);
				if(!$post || !$repost)
					return false;
				$data['image'] = $post->small;
				$data['message'] = $this->t('{who} {#reposted} {what} to {where}.', array(
					'{who}' => $user->name,
					'{what}' => CHtml::link($post->message,url('/picture/view', array('id' => $post->id))),
					'{where}' => CHtml::link($repost->board->title,$repost->board->link)
				));
				break;
				
			case 'like':
				$post = MPicturePost::model()->findByPk($params['post']);
				if(!$post)
					return false;
				$data['image'] = $post->small;
				$data['message'] = $this->t('{who} likes {what} by {whom}.', array(
					'{who}' => $user->name,
					'{what}' => CHtml::link($post->message,url('/picture/view', array('id' => $post->id))),
					'{whom}' => CHtml::link($post->user->name,$post->user->url)
				));
				break;
				
			case 'comment':
				$post = MPicturePost::model()->findByPk($params['post']);
				if(!$post)
					return false;
				$data['image'] = $post->small;
				$data['message'] = $this->t('{who} commented on {what} by {whom}.', array(
					'{who}' => $user->name,
					'{what}' => CHtml::link($post->message,url('/picture/view', array('id' => $post->id))),
					'{whom}' => CHtml::link($post->user->name,$post->user->url)
				));
				break;
		}
		return $data;
	}
}