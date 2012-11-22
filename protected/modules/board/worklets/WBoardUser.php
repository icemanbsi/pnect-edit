<?php
class WBoardUser extends UWidgetWorklet
{
	public $space = 'sidebar';
	public $user;
	
	public function afterConfig()
	{
		wm()->add('network.eventList',null,array('user'=> $this->user,'position' => array('after' => $this->id)));
		wm()->add('base.menu');
	}
	
	public function taskRenderOutput()
	{
		$this->render('userCard',array('data' => $this->user));
	}
}