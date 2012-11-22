<?php
class WNetworkRequestList extends UListWorklet {
    
    public $modelClassName = 'MNetworkRequest';
	public $addButtonColumn=false;
   	public $addMassButton = false;

	public function title()
    {
		return $this->t('Invitation Requests');
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
		
		wm()->add('network.request.mass',null,array('position' => array('after' => $this->id)));
	}
	
	public function columns() 
    {
		$gridId = $this->getDOMId().'-grid';
		
		$sendImage = asma()->publish($this->module->basePath.DS.'images'.DS.'mark.png');
		$sendCfg = array(
			'label' => $this->t('Send Invite'),
			'url' => 'url("/network/request/send",array("id"=>$data->primaryKey))',
			'imageUrl' => $sendImage,
		);
		
		$sendCfg['click'] = 'function(){
			$.fn.yiiGridView.update("'.$gridId.'", {
				type:"POST",
				url:$(this).attr("href"),
				success:function() {
					$.fn.yiiGridView.update("'.$gridId.'");
				}
			});
		return false;}';
		
        return array(
            array(
				'header'=>$this->t('Email'), 
				'name'=>'email',
			),
            'buttons' => array(
				'class' => 'CButtonColumn',
				'template' => '{sendButton} {delete}',
				'buttons' => array(
					'sendButton' => $sendCfg,
				),
			),
        );
	}
}
