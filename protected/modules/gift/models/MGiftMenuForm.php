<?php

class MGiftMenuForm extends UActiveRecord {

	public static function module() {
		return 'gift';
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{GiftMenu}}';
	}

	public function rules() {
		return array(
			array('priceStart', 'required'),
			array('id,priceEnd', 'safe'),
		);
	}

	public function attributeLabels() {
		return array(
			'priceStart' => $this->t('Price Start'),
			'priceEnd' => $this->t('Price End'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);

		$criteria->compare('priceStart', $this->priceStart);

		$criteria->compare('priceEnd', $this->priceEnd);

		return new CActiveDataProvider(__CLASS__, array(
					'criteria' => $criteria,
				));
	}

}
