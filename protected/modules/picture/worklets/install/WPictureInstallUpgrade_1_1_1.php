<?php

class WPictureInstallUpgrade_1_1_1 extends UInstallWorklet {

	public $fromVersion = '1.1.0';
	public $toVersion = '1.1.1';

	public function taskModuleParams() {
		return CMap::mergeArray(parent::taskModuleParams(), array(
					'commentLength' => 500,
					'words' => array(
						'posting' => 'posting',
						'posting_ucf' => 'Posting',
					)
				));
	}
}