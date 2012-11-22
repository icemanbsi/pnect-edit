<?php

class BoardModule extends UWebModule {

	public function getTitle() {
		return 'Board';
	}

	public function preinit() {
		Yii::addCustomClasses(array(
			'UBoardTitleValidate' => $this->basePath . '/components/UBoardTitleValidate.php',
		));

		return parent::preinit();
	}

	public function getRequirements() {
		return array('user' => self::getVersion());
	}

}
