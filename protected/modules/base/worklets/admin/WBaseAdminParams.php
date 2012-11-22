<?php
class WBaseAdminParams extends UWidgetWorklet
{
	public function taskRenderOutput()
	{
		parent::taskRenderOutput();
		app()->controller->worklet('base.language.list');
	}
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function title()
	{
		return txt()->format(ucfirst($this->module->name),' ',$this->t('Module'));
	}
}