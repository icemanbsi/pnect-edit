<?php
class MBoardParamsForm extends UFormModel
{
	public $newBoards;
	
	public static function module()
	{
		return 'board';
	}
	
	public function rules()
	{
		return array(
			array(implode(',',array_keys(get_object_vars($this))),'safe')
		);
	}
}