<?php
class MBoardForm extends MBoard
{
	public $usernamesField;
	public function rules()
	{
		return array(
			array('categoryId, title, access', 'required'),
			array('title','UBoardTitleValidate'),
			array('description','safe','on'=>'update'),
			array('usernamesField', 'safe'),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => $this->t('Id'),
			'userId' => $this->t('User'),
			'categoryId' => $this->t('Category'),
			'title' => $this->t('Title'),
			'description' => $this->t('Description'),
			'access' => $this->t('Access'),
			'usernamesField' => $this->t('Username'),
		);
	}

	
}