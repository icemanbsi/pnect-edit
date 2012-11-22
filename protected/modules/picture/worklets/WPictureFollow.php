<?php
class WPictureFollow extends UWidgetWorklet
{
	public $show = false;
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function taskConfig()
	{
		$options = array();
		$c = new CDbCriteria;
		$c->condition = "userId IN (SELECT followUserId FROM {{NetworkFollowUser}} WHERE userId=:id)
			OR boardId IN (SELECT boardId FROM {{NetworkFollowBoard}} WHERE userId=:id)
			OR userId=:id";
		$c->params = array(':id' => app()->user->id);
		$options['criteria'] = $c;
				
		wm()->add('picture.list',null,array('dto'=>$options, 'centralize' => true));
		wm()->add('base.menu');
	}
}