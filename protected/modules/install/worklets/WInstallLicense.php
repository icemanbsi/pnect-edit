<?php
class WInstallLicense extends UFormWorklet
{
	public $modelClassName = 'UDummyModel';
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function title()
	{
		return $this->t('Installation');
	}
	
	public function properties()
	{
		return array(
			'elements' => array(				
				'attribute' => array('type' => 'text', 
					'label' => $this->t('License Key'), 'class' => 'large', 'required' => true),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Continue'))
			),
			'model' => $this->model
		);
	}
	
	public function taskSave()
	{
		if(!$this->model->attribute)
		{
			$message = Yii::t('yii','{attribute} cannot be blank.',array('{attribute}'=>'License Key'));
			return $this->model->addError('attribute',$message);
		}
		
		$l = $this->model->attribute;
		$d = app()->request->getHostInfo();
		$curl = Yii::createComponent(array('class'=>'uniprogy.extensions.curl.CCurl'));
		$curl->addSession('http://uniprogy.com/pinnect/verify?l='.urlencode($l).'&d='.urlencode($d), array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_FAILONERROR => true,
		));
		$result = $curl->exec();
		$curl->clear();
		if($result)
		{
			$result = CJavaScript::jsonDecode($result);	
			if(!$result['status'])
				return $this->model->addError('attribute',isset($result['message'])
						? $result['message']
						: Yii::t('yii','You are not authorized to perform this action.'));
		}
	}
	
	public function successUrl()
	{
		return url('/install/home');
	}
}