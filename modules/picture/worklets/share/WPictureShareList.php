<?php
class WPictureShareList extends UListWorklet {
    
    public $modelClassName = 'MPictureReport';
	public $addButtonColumn=false;
   	public $addMassButton = false;

	public function title()
    {
		return m('picture')->t('Reported {#post_ns_ucf}');
    }
    
    public function accessRules()
    {
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
    }
	
    public function taskConfig()
	{
		wm()->get('base.init')->setState('admin',true);
		parent::taskConfig();
	}
	
	public function columns() 
    {
        return array(
            array(
				'header'=>$this->t('{#post_n_ucf}'), 
				'type' => 'raw', 
				'name'=>'postId', 
				'value' => '$data->post
					? CHtml::link( 
					  CHtml::image(wm()->get("base.helper")->bin($data->post->picture->imageBin)->getFileUrl("small"),$data->post->message),
					  url("/picture/view",array("id"=> $data->post->id)),
					  array("target" => "_blank"))
					: ""'
			),
            array(
				'header'=>$this->t('Report Type'), 
				'name'=>'reportType',
				'filter'=> wm()->get('picture.share.helper')->reportTypeAsList(),
				'value'=> 'wm()->get("picture.share.helper")->reportTypeAsString($data->reportType)',
			),
            array(
				'header'=>$this->t('Reporter'), 
				'type' => 'raw', 
				'name'=>'userId',
				'value' => '$data->userId?CHtml::link($data->user->name, $data->user->url, array("target" => "_blank")):"'.$this->t('Visitor').'"'
			),
        );
    }
    public function buttons()
	{
		$buttons = array();
		$buttons[] = CHtml::ajaxSubmitButton($this->t('Ignore'), url('/picture/share/ignore'), array(
			'success' => 'function(){$.fn.yiiGridView.update("' .$this->getDOMId(). '-grid");}',
		));
		$buttons[] = CHtml::ajaxSubmitButton($this->t('Delete Post'), url('/picture/share/deletePost'), array(
			'success' => 'function(){$.fn.yiiGridView.update("' .$this->getDOMId(). '-grid");}',
		));
		$buttons[] = CHtml::ajaxSubmitButton($this->t('Delete Picture'), url('/picture/share/deletePicture'), array(
			'success' => 'function(){$.fn.yiiGridView.update("' .$this->getDOMId(). '-grid");}',
		));
		return $buttons;
	}
    public function taskBreadCrumbs()
    {
		$r = array();
		$r[] = m('picture')->t('Report {#post_n_ucf}');
		return $r;
    }
    
	public function afterBuild()
	{
		wm()->add('picture.comment.reportList');
	}
}
