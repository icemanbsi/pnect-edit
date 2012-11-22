<?php
class BPictureAdminMenu extends UWorkletBehavior
{
	public function afterConfig()
	{
		$this->getOwner()->insertBefore('Logout',array(
			array('label'=>$this->t('Reports'), 'url'=>array('/picture/share/list'),
				'visible' => app()->user->checkAccess('administrator')),
			array('label'=>$this->t('Categories'), 'url'=>array('/picture/category/list'),
				'visible' => app()->user->checkAccess('administrator')),
		));
	}
}