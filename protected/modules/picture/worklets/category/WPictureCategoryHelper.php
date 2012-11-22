<?php
class WPictureCategoryHelper extends USystemWorklet
{
	public function taskImage($image)
	{
		if($image)
		{
			$bin = wm()->get('base.helper')->bin($image);
			return CHtml::image($bin->getFileUrl('original'),null,array('class' => 'listImage'));
		}
		return null;
	}
	
	public function taskCategoryAsList()
	{
		$list = array();
		$models = MPictureCategory::model()->with(array('i18n'=>array('together'=>true)))->findAll(array(
			'condition' => 't.enabled > 0',
			'order' => 'i18n.value ASC'
		));
		
		foreach($models as $m)
			$list[$m->id] = $m->name;

		return $list;
	}
	
	public function taskCategoriesMenu()
	{
		$items = array();
		$list = MPictureCategory::model()->with(array('i18n2'=>array('together'=>true)))->findAll(array(
			'condition' => 't.enabled > 0',
			'order' => 'i18n2.value ASC'
		));
		foreach($list as $m)
			$items[] = array('label' => $m->name, 'url' => array('/picture/index', 'category' => $m->url));
		return $items;
	}
}