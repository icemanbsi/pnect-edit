<?php
class MPictureCategoryForm extends MPictureCategory
{
	public $name;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{
		return array(
            array('url', 'length', 'max'=>250),
            array('name, url', 'required'),
			array('enabled', 'safe'),
			array('url', 'unique', 'className' => 'MPictureCategory'),
			array('image', 'safe', 'on' => 'update'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'name' => $this->t('Name'),
			'url' => $this->t('Shortcut URL'),
			'enabled' => $this->t('Enable'),
			'image' => $this->t('Category Image'),
		);
	}

	public function beforeValidate()
	{
		if(is_array($this->name))
			foreach($this->name as $k=>$v)
				if(!$v)
					unset($this->name[$k]);
		return parent::beforeValidate();
	}
}