<?php
class WPictureSearchForm extends UWIdgetWorklet
{
	public function accessRules()
	{
		return array(array('allow','users'=>array('*')));
	}
	
	public function taskValue()
	{
		return isset($_GET['q'])?$_GET['q']:null;
	}
	
	public function taskRenderOutput()
	{
		$this->render('form');
	}
}