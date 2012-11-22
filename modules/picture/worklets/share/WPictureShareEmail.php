<?php
class WPictureShareEmail extends UFormWorklet
{		
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function title()
	{
		return $this->t('Email this {#post_n_ucf}');
	}

	public function taskPost()
	{
		static $post;
		if(!isset($post))
			$post = MPicturePost::model()->findByPk ($_GET['post']);
		return $post;
	}
	
	public function model()
	{
		static $model;
		if(!isset($model))
		{
			$model = new UDynamicModel;
			$names = 'messageRecipientName,messageRecipientEmail,messageBody';
			$rules = array(
				array('messageBody', 'safe'),
				array('messageRecipientName,messageRecipientEmail', 'required'),
				array('messageRecipientEmail', 'email'),
			);
			$model->import(explode(',', $names), $rules);
		}
		return $model;
	}
	
	public function properties()
	{
		return array(
			'elements' => array(
				'messageRecipientEmail' => array('type' => 'text', 'label' => $this->t('Recipient Email')),
				'messageRecipientName' => array('type' => 'text', 'label' => $this->t('Recipient Name')),
				'messageBody' => array('type' => 'textarea', 'label' => $this->t('Your Message')),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Send Email'))
			),
			'model' => $this->model()
		);
	}
	
	public function beforeSave()
	{
		$validator = new CEmailValidator;
		if(!$validator->validateValue($this->model()->messageRecipientEmail))
			return $this->model()->addError('messageRecipientEmail', $this->t('Invalid Email.'));
	}
	
	public function taskSave() {
		$registerLink = '';
		if(!MUser::model()->exists('email=?',array($this->model()->messageRecipientEmail))){
			$hash = UHelper::hash();
			// save hash in a DB
			$model = new MHash;
			$model->hash = $hash;
			$model->type = 10;
			$model->id   = app()->user->id;
			$model->expire = 0;
			$model->save();
			$registerLink = aUrl('/user/signup', array('h' => $hash), 'http');
		}
		app()->mailer->send(
				array(
					'from' => array(
						'name' => app()->user->model()->name,
						'email' => app()->user->model()->email,
						),
					'to' => $this->model()->messageRecipientEmail,
				),				 
				'shareEmail', 
				array(
					'messageRecipientName' => $this->model()->messageRecipientName,
					'messageBody' => $this->model()->messageBody,
					'post' => $this->post(),
					'registerLink' => $registerLink,
				)
			);
	}
	
	public function ajaxSuccess()
	{
		wm()->get('base.init')->addToJson(array(
			'content' => array(
				'info' => array(
                'replace' => $this->t('Your Message Sent.'),
                'fade' => 'target',
                'focus' => true,
				),
				'append' => CHtml::script('$.uniprogy.dialogClose();'),
			)
		));
	}	
	
}