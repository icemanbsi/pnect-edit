<?php
class PictureModule extends UWebModule
{
	public function preinit()
	{
		if(!YII_DEBUG)
		{
			Yii::addCustomClasses(array(
			));
		}
		return parent::preinit();
	}
	
	public function getTitle()
	{
		return 'Picture';
	}
	
	public function t($message, $params = array(), $source = null, $language = null)
	{
		return wm()->get('picture.helper')->tr($message, $params, $source, $language);
	}
	
	public function getRequirements()
	{
		return array('user' => self::getVersion());
	}
}
