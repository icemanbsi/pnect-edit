<?php

class WGiftInstallInstall extends UInstallWorklet {

	public function taskModuleParams() {
		return array(
			'symbol' => '$',
			'template' => '{symbol}{price}',
		);
	}

	public function taskSuccess() {
		$menu = array(
				'1' => '20',
				'20' => '50',
				'50' => '100',
				'100' => '200',
				'200' => '500',
				'500' => '',
			);

		foreach ($menu as $key => $value) {
			$m = new MGiftMenuForm;
			$m->priceStart = $key;
			$m->priceEnd = $value;
			$m->save();
		}
		parent::taskSuccess();
	}

	public function taskModuleFilters() {
		return array(
			'base' => 'gift.main',
			'picture' => 'gift.main',
		);
	}

}
