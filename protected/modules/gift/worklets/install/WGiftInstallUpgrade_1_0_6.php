<?php
class WGiftInstallUpgrade_1_0_6 extends UInstallWorklet
{
	public $fromVersion = '1.0.5';
	public $toVersion = '1.0.6';
	
	public function taskSuccess() {
		$config = require(app()->basePath . DS . 'config' . DS . 'public' . DS . 'modules.php');
		$menu = $config['modules']['gift']['params']['menu'];
		$config['modules']['gift']['params']['menu'] = '';
		UHelper::saveConfig(app()->basePath . DS . 'config' . DS . 'public' . DS . 'modules.php', $config);
		foreach ($menu as $key => $value) {
			$m = new MGiftMenuForm;
			$m->priceStart = $key;
			$m->priceEnd = $value;
			$m->save();
		}
		parent::taskSuccess();
	}
}