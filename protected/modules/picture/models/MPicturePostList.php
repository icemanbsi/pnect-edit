<?php
class MPicturePostList extends MPicturePost
{
	public $likeUserId;
	public $categoryId;
	public $orderType;
	public $followUserId;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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

		if($this->likeUserId){
			$criteria->with['likes'] = array('together' => true);
			$criteria->compare('likes.userId',$this->likeUserId);
		}
		if($this->categoryId){
			$criteria->with['board'] = array('together' => true);
			$criteria->compare('board.categoryId',$this->categoryId);
		}
		
		if($this->followUserId){
			$criteria->with['board'] = array('together' => true);
			$criteria->addCondition('board.id in (
				SELECT boardId 
				FROM {{NetworkFollowBoard}} 
				WHERE userId in ('.$this->followUserId.'))
				OR
				board.id in (
				SELECT boardId 
				FROM {{Board}} 
				WHERE userId in ('.$this->followUserId.'))');

		}
		
		$order = 'created DESC';
		if($this->orderType)
		{
			switch($this->orderType)
			{
				case 'formula':
					$order = $this->t(m('picture')->params['formula'],
							array(
								'{likes}' => '(likes)',
								'{reposts}' => '(reposts)',
								'{comments}' => '(comments)',
								'{time}' => '(NOW() - created)',
								)
							);
					break;
				default:					
					break;
			}
		}
		
		$criteria->compare('id',$this->id);

		$criteria->compare('pictureId',$this->pictureId);

		$criteria->compare('parentId',$this->parentId);

		$criteria->compare('userId',$this->userId);

		$criteria->compare('boardId',$this->boardId);
		
		$criteria->compare('source',$this->source,true);
		
		$criteria->compare('sourceDomain',$this->sourceDomain,true);

		$criteria->compare('channel',$this->channel,true);

		$criteria->compare('message',$this->message,true);

		$criteria->compare('likes',$this->likes,true);

		$criteria->compare('reposts',$this->reposts,true);

		$criteria->compare('comments',$this->comments,true);

		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider(__CLASS__, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => $order),
		));
	}
}