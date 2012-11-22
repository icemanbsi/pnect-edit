<?php

class MPictureCategory extends UActiveRecord {

	public static function module() {
		return 'picture';
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{PictureCategory}}';
	}

	public function rules() {
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, image, enabled', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'i18n' => array(self::HAS_MANY, 'MI18N', 'relatedId', 'on' => "model='PictureCategory'"),
			'i18n2' => array(self::HAS_MANY, 'MI18N', 'relatedId', 'on' => "model='PictureCategory' and language='" . app()->language . "'"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => $this->t('Id'),
			'url' => $this->t('Url'),
			'image' => $this->t('Image'),
			'enabled' => $this->t('Enabled'),
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

		$criteria->with = array('i18n' => array('together' => true));

		$criteria->compare('id', $this->id, true);

		$criteria->compare('url', $this->url, true);

		$criteria->compare('image', $this->image, true);

		$criteria->compare('enabled', $this->enabled);

		if ($this->name)
			$criteria->compare('i18n.value', $this->name, true);

		return new CActiveDataProvider(__CLASS__, array(
					'criteria' => $criteria,
					'sort' => array(
						'defaultOrder' => 'i18n.value ASC'
					)
				));
	}

	public function getName() {
		return $this->translate('name');
	}

}