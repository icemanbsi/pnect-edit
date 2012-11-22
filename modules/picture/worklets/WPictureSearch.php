<?php
class WPictureSearch extends UWidgetWorklet
{
	public $show = false;
	
	public function taskConfig()
	{
		$options = array();
		if(isset($_GET['q']))
		{
			$c = new CDbCriteria;
			$c->together = true;
			$c->with = array('board','user');

			$phrases = explode(' ', $_GET['q']);
			foreach ($phrases as $phrase) {
				$c->addCondition("t.message LIKE '%$phrase%' OR board.title LIKE '%$phrase%' OR user.username LIKE '%$phrase%'");
			}
			
			$options['criteria'] = $c;
		}		
		wm()->add('picture.list',null,array('dto'=>$options));
		wm()->add('base.menu');
	}
}