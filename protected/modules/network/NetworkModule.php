<?php
class NetworkModule extends UWebModule
{
	public function getTitle()
	{
		return 'Network';
	}
	
	public function getRequirements()
	{
		return array('user' => self::getVersion());
	}
}
