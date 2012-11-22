<?php
class WPictureOptions extends UWidgetWorklet
{
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function title()
	{
		return $this->t('Add');
	}
	
	public function taskRenderOutput()
	{
		$this->render('options');
	}
}