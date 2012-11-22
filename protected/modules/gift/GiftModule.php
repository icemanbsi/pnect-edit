<?php
class GiftModule extends UWebModule
{
	public function getVersion()
	{
        return '1.0.6';
    }

    public function getTitle()
	{
        return 'Gift';
    }

    public function getRequirements()
	{
        return array('app' => '1.0.5');
    }
    
    public function preinit()
	{
		if (!YII_DEBUG)
		{
            Yii::addCustomClasses(array(
				'MGift' => $this->basePath.'/models/MGift.php',
				'MGiftMenuForm' => $this->basePath.'/models/MGiftMenuForm.php',
				'MGiftParamsForm' => $this->basePath.'/models/MGiftParamsForm.php',
            ));
        }
        return parent::preinit();
    }
	
	public function getVersionHistory()
	{
		return array(
			'1.0.0',
			'1.0.1',
			'1.0.2',
			'1.0.3',
			'1.0.4',
			'1.0.5',
			'1.0.6',
		);
	}
}
