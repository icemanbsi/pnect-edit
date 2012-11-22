<?php
class MPicturePost extends UActiveRecord
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
		return '{{PicturePost}}';
	}

	public function rules()
	{
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pictureId, parentId, userId, boardId, source, sourceDomain, channel, message, likes, reposts, comments, created', 'safe', 'on'=>'search'),
		);
	}
	
	public function behaviors()
	{
		return array(
			'TimestampBehavior' => array(
				'class' => 'UTimestampBehavior',
				'modified' => null,
			)
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'picture' => array(self::BELONGS_TO, 'MPicture', 'pictureId'),
			'parent' => array(self::BELONGS_TO, 'MPicturePost', 'parentId'),
			'user' => array(self::BELONGS_TO, 'MUser', 'userId'),
			'board' => array(self::BELONGS_TO, 'MBoard', 'boardId'),
			'comments' => array(self::HAS_MANY, 'MPictureComment', 'postId'),
			'likes' => array(self::HAS_MANY, 'MPictureLike', 'postId'),
			'likesCount' => array(self::STAT, 'MPictureLike', 'postId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => $this->t('Id'),
			'pictureId' => $this->t('Picture'),
			'parentId' => $this->t('Parent'),
			'userId' => $this->t('User'),
			'boardId' => $this->t('Board'),
			'source' => $this->t('Source URL'),
			'sourceDomain' => $this->t('Source Domain'),
			'channel' => $this->t('Channel'),
			'message' => $this->t('Message'),
			'likes' => $this->t('1#Likes|n=2#Likes|n=3#Likes',array(1)),
			'reposts' => $this->t('Reposts'),
			'comments' => $this->t('Comments'),
			'created' => $this->t('Created'),
		);
	}
	
	public function getImg()
	{
		return $this->picture->imageBin
			? wm()->get('base.helper')->bin($this->picture->imageBin)->getFileUrl('large')
			: null;
	}

	public function getMedium()
	{
		return $this->picture->imageBin
			? wm()->get('base.helper')->bin($this->picture->imageBin)->getFileUrl('medium')
			: null;
	}

	public function getSmall()
	{
		return $this->picture->imageBin
			? wm()->get('base.helper')->bin($this->picture->imageBin)->getFileUrl('small')
			: null;
	}
}