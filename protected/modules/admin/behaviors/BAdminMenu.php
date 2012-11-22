<?php
class BAdminMenu extends UWorkletBehavior
{
	public function afterMenu($result)
	{
		$result[1]['items'][] = array('label'=>$this->t('Admin Console'), 'url'=>array('/admin'),
			'visible' => app()->user->checkAccess('administrator'));
		return $result;
	}
}