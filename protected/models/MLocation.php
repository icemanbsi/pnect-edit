<?php
class MLocation extends UActiveRecord
{
	public static function module()
	{
		return 'location';
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return '{{Location}}';
	}
	
	public function relations()
	{
		return array(
		);
	}

	public function getCityName()
	{
		return $this->city;
	}
	
	public function rules()
	{
		return array(
			array('country,state,city,cityASCII','safe')
		);
	}
}