<?php
class UApp extends UWebApplication
{
	public function getVersion()
	{
		return '1.1.2';
	}
	
	public function getTitle()
	{
		return 'UniProgy Pinnect';
	}
	
	public function getAppModules()
	{
		return array(
			'user',
			'admin',
			'base',
			'location',
			'network',
			'picture',
			'board',
			'customize'
		);
	}
	
	public function getVersionHistory()
	{
		return array(
			'1.0.0',
			'1.0.1',
			'1.0.2',
			'1.0.3',
			'1.0.4',
			'1.0.5',
			'1.1.0',
			'1.1.1',
			'1.1.2',
		);
	}
}