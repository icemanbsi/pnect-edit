<?php
class MNetworkEvent extends UActiveRecord
{
	public static function module()
	{
		return 'network';
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{NetworkEvent}}';
	}

	public function rules()
	{
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, eventModule, eventType, created, params', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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
			'eventModule' => $this->t('Event Module'),
			'eventType' => $this->t('Event Type'),
			'created' => $this->t('Created'),
			'params' => $this->t('Params'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('userId',$this->userId);

		$criteria->compare('eventModule',$this->eventModule);

		$criteria->compare('eventType',$this->eventType);

		$criteria->compare('created',$this->created,true);

		$criteria->compare('params',$this->params,true);

		return new CActiveDataProvider(__CLASS__, array(
			'criteria'=>$criteria,
                        'sort' => array('defaultOrder' => 'created DESC'),
		));
	}
}