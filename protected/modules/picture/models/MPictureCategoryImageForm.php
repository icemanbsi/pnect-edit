<?php
class MPictureCategoryImageForm extends MPictureCategory {
	
    public function rules()
    {
		return array(
			array('image', 'file',
				'types'=>'jpg, gif, png'),
		);
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}