<?php
class WPictureIndex extends UWidgetWorklet
{
	public $show = false;
	
	public function taskConfig()
	{
		$c = new CDbCriteria;
		if(isset($_GET['category']))
		{
			$category = MPictureCategory::model()->find('id=? or url=?',array($_GET['category'],$_GET['category']));
			if($category){
				$c->with['board'] = array('together' => true);
				$c->compare('board.categoryId',$category->id);
			}else
				$c->addCondition('parentId is null');
			
		}		
		wm()->add('picture.list',null,array('dto'=>array('criteria' => $c), 'centralize' => true));
		wm()->add('base.menu');
		
		wm()->get('picture.helper')->inviteNotice();
	}
	
}
