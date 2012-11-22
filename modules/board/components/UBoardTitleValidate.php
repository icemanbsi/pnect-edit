<?php
class UBoardTitleValidate extends CValidator
{
	protected function validateAttribute($object,$attribute)
	{
		// extract the attribute value from it's model object
		$value=$object->$attribute;

		$board = MBoard::model()->find('userId=? AND title=?',array($object->userId?$object->userId:app()->user->id,$value));
		if ($board && $board->id != $object->id)
			$this->addError($object,$attribute, $object->t('This Board is already created.'));
	}
}