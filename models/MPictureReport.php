<?php
class MPictureReport extends UActiveRecord
{
	public static function module()
	{
		return 'picture';
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{PictureReport}}';
	}

	public function rules()
	{
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, postId, userId, reportType', 'safe'),
			array('reportType','required'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'MUser', 'userId'),
			'post' => array(self::BELONGS_TO, 'MPicturePost', 'postId')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => $this->t('Id'),
			'postId' => $this->t('Post'),
			'userId' => $this->t('User'),
			'reportType' => $this->t('Report Type'),
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

		$criteria->compare('id',$this->id,true);

		$criteria->compare('postId',$this->postId,true);

		$criteria->compare('userId',$this->userId,true);

		$criteria->compare('reportType',$this->reportType,true);

		return new CActiveDataProvider(__CLASS__, array(
			'criteria'=>$criteria,
		));
	}
}