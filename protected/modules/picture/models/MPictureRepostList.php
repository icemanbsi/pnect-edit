<?php
class MPictureRepostList extends MPicturePost
{
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

		$criteria->compare('parentId',$this->parentId);

		return new CActiveDataProvider(__CLASS__, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.created DESC'),
			'pagination' => array('pageSize' => $this->getModule()->param('reposts'))
		));
	}
}