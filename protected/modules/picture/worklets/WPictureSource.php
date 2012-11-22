<?php
class WPictureSource extends UWidgetWorklet
{
	public function taskConfig()
	{
		$domain = $this->domain();
		if(!$domain)
			return $this->show = false;
		
		$c = new CDbCriteria;
		$c->compare('sourceDomain',$domain);
		$options = array('criteria' => $c);
		
		wm()->add('picture.list',null,array('dto'=>$options, 'position' => array('after' => $this->id)));
		parent::taskConfig();
	}
	
	public function taskDomain()
	{
		static $d;
		if(!isset($d))
			$d = isset($_GET['domain'])?$_GET['domain']:null;
		return $d;
	}
	
	public function title()
	{
		return $this->t('{#post_ns_ucf} from {source}', array(
			'{source}' => CHtml::link($this->domain(),'http://'
				. $this->domain(), array('target' => '_blank'))
		));
	}
}