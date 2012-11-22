<?php
class MGiftParamsForm extends UFormModel
{
	public $symbol;
	public $template;
	
	public static function module()
	{
		return 'gift';
	}
	
	public function rules()
	{
		return array(
			array(implode(',',array_keys(get_object_vars($this))),'required')
		);
	}
}