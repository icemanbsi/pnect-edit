<?php
class WPictureMore extends UWidgetWorklet
{
	public $space = 'sidebar';
	public $post;
	public $more;
	
	public function taskConfig()
	{
		if($this->post->sourceDomain)
		{
			$more = MPicturePost::model()->findAll(array(
				'condition' => 'sourceDomain=?',
				'params' => array($this->post->sourceDomain),
				'limit' => 9,
			));
			if(count($more))
			{
				$this->more = '';
				foreach ($more as $value) 
					$this->more .= '<div class="mini"><p>'.CHtml::image($value->small,null).'</p></div>';
				return true;
			}
		}
		return $this->show = false;
	}
	
	public function taskRenderOutput()
	{
		$this->render('moreCard');
	}
}