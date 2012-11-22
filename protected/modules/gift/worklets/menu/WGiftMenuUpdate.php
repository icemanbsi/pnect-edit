<?php
class WGiftMenuUpdate extends UFormWorklet
{	
	public $modelClassName = 'MGiftMenuForm';
	public $primaryKey = 'id';
	public $space = 'inside';
	
	public function title()
	{
		return $this->t('Add New Menu Item');
	}
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function properties()
	{			
		return array(
			'elements' => array(
				'priceStart' => array('type' => 'text','class' => 'short',
					'hint' => m('gift')->param('symbol'), 'layout' => "{label}\n<span class='hintInlineBefore'>{hint}\n{input}</span>"),
				'priceEnd' => array('type' => 'text','class' => 'short',
					'hint' => m('gift')->param('symbol'), 'layout' => "{label}\n<span class='hintInlineBefore'>{hint}\n{input}</span>"),
			),
			'buttons' => array(
				'cancel' => app()->request->isAjaxRequest
					? array('type' => 'UJsButton', 'attributes' => array(
						'label' => $this->t('Close'),
						'callback' => '$(this).closest(".worklet-pushed-content").remove()'))
					: null,
				'submit' => array('type' => 'submit',
					'label' => $this->t('Add')),
			),
			'model' => $this->model
		);
	}
	
	public function afterConfig()
	{
		if(isset($_GET['ajax']))
			$this->layout = false;
	}
	
	public function ajaxSuccess()
	{
		$listWorklet = wm()->get('gift.menu.list');
		$json = array(
			'content' => array(
				'append' => CHtml::script('$.fn.yiiGridView.update("' .$listWorklet->getDOMId(). '-grid");
				$("#'.$this->getDOMId().'").closest(".worklet-pushed-content").remove();')
			),
		);
			
		wm()->get('base.init')->addToJson($json);
	}
}