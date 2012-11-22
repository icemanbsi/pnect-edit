<?php

class MBoard extends UActiveRecord {

	public static function module() {
		return 'picture';
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{Board}}';
	}

	public function rules() {
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, categoryId, title, description, access, url, cover, sortOrder', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'usernames' => array(self::HAS_MANY, 'MBoardUser', 'boardId', 'order' => 'id'),
			'user' => array(self::BELONGS_TO, 'MUser', 'userId'),
			'category' => array(self::BELONGS_TO, 'MPictureCategory', 'categoryId'),
			'postsCount' => array(self::STAT, 'MPicturePost', 'boardId'),
			'imageBin' => array(self::BELONGS_TO, 'MStorageBin', 'cover'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => $this->t('Id'),
			'userId' => $this->t('User'),
			'categoryId' => $this->t('Category'),
			'title' => $this->t('Title'),
			'description' => $this->t('Description'),
			'access' => $this->t('Access'),
			'url' => $this->t('Url'),
			'sortOrder' => $this->t('Sort Order'),
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

		$criteria->compare('userId', $this->userId, true);

		$criteria->compare('categoryId', $this->categoryId, true);

		$criteria->compare('title', $this->title, true);

		$criteria->compare('description', $this->description, true);

		$criteria->compare('access', $this->access);

		$criteria->compare('url', $this->url);

		return new CActiveDataProvider(__CLASS__, array(
					'criteria' => $criteria,
					'sort' => array('defaultOrder' => 'sortOrder'),
				));
	}

	public function getLink() {
		return $this->user->url . '/' . $this->url;
	}

	public function getSmall() {
		$c = new CDbCriteria;
		$c->limit = 9;
		$c->order = '`created` DESC';
		$c->compare('boardId', $this->id);

		return MPicturePost::model()->findAll($c);
	}

	public function getMini($cover = null) {
		$result = '';
		$count = 0;
		$cover = $cover ? $cover : $this->imageBin;
		if ($cover)
			$result .= '<div class="cover"><p>' . CHtml::image(wm()->get('base.helper')->bin($cover)->getFileUrl('medium'), null) . '</p></div>';
		foreach ($this->small as $value) {
			$result .= '<div class="mini"><p>' . CHtml::image($value->small, null) . '</p></div>';
			$count++;
			if ($count == 9 || ($count == 3 && $cover))
				break;
		}

		return $result;
	}

}