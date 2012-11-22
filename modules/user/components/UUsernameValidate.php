<?php
class UUsernameValidate extends CValidator
{
	protected function validateAttribute($object,$attribute)
	{
		// extract the attribute value from it's model object
		$value=$object->$attribute;
		
		if (m($value)
				|| m('picture')->params['url'] == $value
				|| in_array($value, m('picture')->params['words'])
				|| $value == app()->params['adminUrl'])
			$this->addError($object,$attribute, $object->t('This username is already in use.'));
	}
}