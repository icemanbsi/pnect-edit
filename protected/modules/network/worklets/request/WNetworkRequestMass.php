<?php
class WNetworkRequestMass extends UFormWorklet
{
	public $modelClassName = 'UDummyModel';
	
	public function title()
	{
		return $this->t('Mass Send Invitations');
	}
	
	public function properties()
	{
		return array(
			'action' => url('/network/request/mass'),
			'elements' => array(
				'attribute' => array('type' => 'text', 'label' => $this->t('Number of invitations to send'),
					'hint' => $this->t('It will send invitation in the order they have been requested.')),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => $this->t('Mass Send'))
			),
			'model' => $this->model
		);
	}
	
	public function taskSave()
	{
		$num = $this->model->attribute;
		settype($num,'integer');
		
		if(!$num)
			return $this->model->addError('attribute', $this->t('Please specify correct number.'));
		
		$c = new CDbCriteria;
		$c->order = 'created ASC';
		$c->limit = $num;
		
		$models = MNetworkRequest::model()->findAll($c);
		foreach($models as $m)
		{
			$invite = wm()->get('network.helper')->invite($m->email,0);

			app()->mailer->send($m->email, 'systemInvitationEmail', array(
				'link' => aUrl('/user/signup', array('h' => $invite->hash), 'http')
			));
			
			$m->delete();
		}
	}
	
	public function ajaxSuccess()
	{
		$listWorklet = wm()->get('network.request.list');
		wm()->get('base.init')->addToJson(array(
			'info' => array(
				'appendReplace' => $this->t('{num} invitations have been sent.', array(
					'{num}' => $this->model->attribute
				)),
				'focus' => true
			),
			'content' => array('append' => CHtml::script('$.fn.yiiGridView.update("' . $listWorklet->getDOMId() . '-grid")'))
		));
	}
}