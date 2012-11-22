<?php
class WPicturePopular extends UWidgetWorklet
{
	public $show = false;
	
	public function taskConfig()
	{
		$options = array('order' => strtr($this->param('formula'),
			array(
				'{likes}' => '(likes)',
				'{reposts}' => '(reposts)',
				'{comments}' => '(comments)',
				'{time}' => '(NOW() - created)',
			)
		).' DESC');	
		wm()->add('picture.list',null,array('dto'=>$options, 'centralize' => true));
		wm()->add('base.menu');
		
		wm()->get('picture.helper')->inviteNotice();
	}
}