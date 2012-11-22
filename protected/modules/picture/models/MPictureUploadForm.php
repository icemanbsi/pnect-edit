<?php
class MPictureUploadForm extends UFormModel
{
	public $image;
	
	public static function module()
	{
		return 'picture';
	}
	
    public function rules()
    {
		return array(
			array('image', 'file', 'types'=>$this->getModule()->param('extensions')),
		);
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}