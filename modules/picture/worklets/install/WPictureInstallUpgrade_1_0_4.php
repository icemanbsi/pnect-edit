<?php

class WPictureInstallUpgrade_1_0_4 extends UInstallWorklet {

	public $fromVersion = '1.0.3';
	public $toVersion = '1.0.4';

	public function taskModuleParams() {
		return CMap::mergeArray(parent::taskModuleParams(), array(
					'attribute' => 'Post Button',
				));
	}

}