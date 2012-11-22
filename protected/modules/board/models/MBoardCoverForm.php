<?php
class MBoardCoverForm extends UFormModel
{
	public $postId;
	public $boardId;
	
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