<?php
class WInstallAppInstall extends UInstallWorklet
{
	public function getModule()
	{
		return app();
	}
	
	public function taskModuleParams()
	{
		$host = app()->request->getHostInfo();
		$host = str_replace('http://','',$host);
		$host = str_replace('https://','',$host);
		$host = str_replace('www.','',$host);
		if(($pos=strpos($host,':'))!==false)
			$host = substr($host,0,$pos);
		return CMap::mergeArray(parent::taskModuleParams(),array(
			'adminLogin' => 'admin',
		    'adminPassword' => 'password',
		    'adminUrl' => 'admincp',
		    'publicAccess' => '1',
			'inviteOnly' => '0',
		    'maxCacheDuration' => '3600',
		    'dst' => '1',
		    'systemEmail' => 'no-reply@'.$host,
		    'contactEmail' => 'contact@'.$host,
		    
		    'htmlEmails' => '1',
		    'poweredBy' => array(app()->language => '<a href="http://uniprogy.com/pinnect" target="_blank">Powered by Pinnect</a>'),
		    'keywords' => 'pinnect, uniprogy',
		    'description' => 'This site is powered by Pinnect',
		    'mailPriority' => '3',
		    'mailCharSet' => 'utf-8',
		    'mailEncoding' => '8bit',
		    'mailMailer' => 'mail',
		    'mailSendmail' => '/usr/sbin/sendmail',
		    'mailHost' => 'localhost',
		    'mailPort' => '25',
		    'mailSMTPSecure' => '',
		    'mailSMTPAuth' => '0',
		    'mailUsername' => '',
		    'mailPassword' => '',
		    'mailTimeout' => '10',
		    'timeZone' => '0',
		    'cronSecret' => md5(UHelper::salt(5)),
		    'uploadWidget' => '1',
		));
	}

	public function taskSuccess() {
        parent::taskSuccess();
        $config['name'] = 'Pinnect';
		$config['theme'] = 'classic';
        UHelper::saveConfig(Yii::getPathOfAlias('application.config.public.modules') . '.php', $config);
    }

}