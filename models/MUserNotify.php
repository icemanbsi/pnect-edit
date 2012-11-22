<?php
class MUserNotify extends UActiveRecord
{
	public static function module()
	{
		return 'user';
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{UserNotify}}';
	}

	public function rules()
	{
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, comment, like, repost, follow, unfollow', 'safe'),
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
			'comment' => $this->t('Comment'),
			'like' => $this->t('Like'),
			'repost' => $this->t('Repost'),
			'follow' => $this->t('Follow'),
			'unfollow' => $this->t('Unfollow'),
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

		$criteria->compare('comment',$this->comment);

		$criteria->compare('like',$this->like);

		$criteria->compare('repost',$this->repost);

		$criteria->compare('follow',$this->follow);

		$criteria->compare('unfollow',$this->unfollow);

		return new CActiveDataProvider(__CLASS__, array(
			'criteria'=>$criteria,
		));
	}
}