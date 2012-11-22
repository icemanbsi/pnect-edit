<?php

class WGiftMenuList extends UListWorklet {

	public $modelClassName = 'MGiftMenuForm';

	public function accessRules() {
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users' => array('*'))
		);
	}

	public function title() {
		return $this->t('Menu');
	}

	public function columns() {
		return array(
			array('header' => $this->t('Price Start'), 'name' => 'priceStart',),
			array('header' => $this->t('Price End'), 'name' => 'priceEnd',),
			'buttons' => array(
				'class' => 'CButtonColumn',
				'template' => '{update} {delete}',
				'updateButtonUrl' => 'url("' . $this->getParentPath() . '/update",array("id"=>$data["id"]))',
				'deleteButtonUrl' => 'url("' . $this->getParentPath() . '/delete",array("id"=>$data["id"]))',
				'buttons' => array(
					'update' => array('click' => 'function(){
						$("#' . $this->getDOMId() . '").uWorklet().load({position:"appendReplace",url: $(this).attr("href")});
						return false;}'),
				),
			),
		);
	}

	public function buttons() {
		$link = url('/gift/menu/update');
		$id = $this->getDOMId() . CHtml::ID_PREFIX . CHtml::$count++;
		cs()->registerScript($this->getId() . $id, 'jQuery("#' . $id . '").click(function(e){
		e.preventDefault();
		$.uniprogy.loadingButton("#' . $id . '",true);
		$("#' . $this->getDOMId() . '").uWorklet().load({
			url: "' . $link . '",
			position: "appendReplace", 
			success: function(){
				$.uniprogy.loadingButton("#' . $id . '",false);
			}
		});
		});');
		return array(CHtml::button($this->t('Add New Menu Item'), array('id' => $id)));
	}

}