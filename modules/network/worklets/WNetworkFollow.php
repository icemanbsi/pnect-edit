<?php
class WNetworkFollow extends UWidgetWorklet
{
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function taskConfig()
	{
		$user = null;
		$board = null;
		
		if(isset($_GET['username']))
			$user = MUser::model()->find('username=?',array($_GET['username']));
		
		if(isset($_GET['board']))
			$board = MBoard::model()->findByPk($_GET['board']);
		
		$word = wm()->get('network.helper')->follow(app()->user->model(),$user,$board);
		wm()->get('base.init')->addToJson(array('follow' => $word));
	}
}