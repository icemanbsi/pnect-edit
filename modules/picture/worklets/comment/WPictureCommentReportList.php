<?php
class WPictureCommentReportList extends UListWorklet {
    
    public $modelClassName = 'MPictureCommentReport';
	public $addMassButton = false;

	public function title()
    {
		return m('picture')->t('Reported Comments');
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
		$gridId = $this->getDOMId().'-grid';
		$ignoreButtonImage = url('/').'/images/mark.png';
		
        return array(
            array(
				'header'=>$this->t('Comment'), 
				'type' => 'ntext', 
				'name'=>'commentId', 
				'value' => '$data->comment->text',
			),
			array(
				'header'=>$this->t('Author'), 
				'name'=>'userId', 
				'value' => '$data->comment->user->username',
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
			'buttons' => array(
				'class' => 'CButtonColumn',
				'template' => '{view} {ignore} {delete}',
				'viewButtonUrl' => 'url("/picture/view",array("id" => $data->comment->postId))',
				'deleteButtonUrl' => 'url("/picture/comment/reportDelete",array("id" => $data->primaryKey))',
				'buttons' => array(
					'ignore' => array(
						'label' => $this->t('Ignore'),
						'url' => 'url("/picture/comment/reportIgnore",array("id"=>$data->primaryKey))',
						'imageUrl' => $ignoreButtonImage,
						'click' => 'function(){
							$.fn.yiiGridView.update("'.$gridId.'", {
								type:"POST",
								url:$(this).attr("href"),
								success:function() {
									$.fn.yiiGridView.update("'.$gridId.'");
								}
							});
						return false;}'
					)
				),
			),
        );
    }
    public function buttons()
	{
		$buttons = array();
		$buttons[] = CHtml::ajaxSubmitButton($this->t('Delete'), url('/picture/comment/reportDelete'), array(
			'success' => 'function(){$.fn.yiiGridView.update("' .$this->getDOMId(). '-grid");}',
		));
		$buttons[] = CHtml::ajaxSubmitButton($this->t('Ignore'), url('/picture/comment/reportIgnore'), array(
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
    
}
