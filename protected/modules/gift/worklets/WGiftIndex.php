<?php
class WGiftIndex extends UWidgetWorklet
{
	public $show = false;
	
	public function accessRules()
	{
		return array(
			array('allow', 'users'=>array('*'))
		);
	}
	
	public function taskConfig()
	{
		$priceStart = isset($_GET['priceStart'])?$_GET['priceStart']:null;
		$priceEnd = isset($_GET['priceEnd'])?$_GET['priceEnd']:null;
		
		$c = new CDbCriteria;
		$c->condition = 'SELECT id FROM {{Gift}} WHERE 1';
		$c->params = array();
		if($priceStart)
		{
			$c->condition.= ' AND price>=:start';
			$c->params[':start'] = $priceStart;
		}
		if($priceEnd)
		{
			$c->condition.= ' AND price<=:end';
			$c->params[':end'] = $priceEnd;
		}
		$c->condition = 'id IN ('.$c->condition.')';

		$options = array();
		$options['criteria'] = $c;
				
		wm()->add('picture.list',null,array('dto'=>$options, 'centralize' => true));
		wm()->add('base.menu');
	}
}