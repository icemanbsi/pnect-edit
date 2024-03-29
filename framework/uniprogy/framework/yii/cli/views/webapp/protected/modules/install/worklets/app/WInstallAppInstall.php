<?php
class WInstallAppInstall extends UInstallWorklet
{
	public function getModule()
	{
		return app();
	}
	
	public function taskModuleParams()
	{
		return CMap::mergeArray(parent::taskModuleParams(),array(
			'adminLogin' => 'admin',
		    'adminPassword' => 'password',
		    'adminUrl' => 'admincp',
		    'publicAccess' => '1',
		    'maxCacheDuration' => '3600',
		    'dst' => '1',
		    'systemEmail' => 'no-reply@localhost.com',
		    'contactEmail' => 'contact@localhost.com',
		    'htmlEmails' => '1',
		    'poweredBy' => '<a href="http://uniprogy.com" target="_blank">Powered by UniProgy Framework</a>',
		    'keywords' => 'uniprogy',
		    'description' => 'This site is powered by UniProgy',
		));
	}
}