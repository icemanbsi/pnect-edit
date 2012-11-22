<?php
class WPictureProfileMenu extends UMenuWorklet
{
	public $user;
	
	public function properties()
	{
		$h = wm()->get('picture.helper');
		return array(
			'items' => array(
				array('label' => $this->t('{num} Boards',
						array('{num}' => $h->stats($this->user->id,'boards'))),
					'url' => $this->user->url,
					'active' => app()->controller->routeEased == 'board/list'),
				
				array('label' => $this->t('{num} {#post_ns_ucf}',
						array('{num}' => $h->stats($this->user->id,'posts'))),
					'url' => array('/picture/user', 'username' => $this->user->username)),
				
				array('label' => $this->t('{num} Likes',
						array('{num}' => $h->stats($this->user->id,'likes'))),
					'url' => array('/picture/likes/user', 'username' => $this->user->username)),
			),
			'htmlOptions' => array(
				'class' => 'horizontal clearfix'
			)
		);
	}
}