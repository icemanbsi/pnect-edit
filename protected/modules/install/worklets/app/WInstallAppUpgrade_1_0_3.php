<?php
class WInstallAppUpgrade_1_0_3 extends UInstallWorklet
{
	public $fromVersion = '1.0.2';
	public $toVersion = '1.0.3';
	
	public function getModule()
	{
		return app();
	}
	
	public function taskSuccess()
	{
		parent::taskSuccess();
		
		$sql = "SHOW TABLES";
		$data = app()->db->createCommand($sql)->queryAll();
		foreach($data as $row)
		{
			$table = current($row);
			if(strstr($table,'PictureReportComment'))
			{
				$sql = "RENAME TABLE {{PictureReportComment}} TO {{PictureCommentReport}}";
				app()->db->createCommand($sql)->execute();
				break;
			}
		}
	}
}