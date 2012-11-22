<?php
class WPictureList extends UListWorklet
{
	/**
	 * Data provider options.
	 * @var array
	 */
	public $dto = array();
	public $type = 'list';
	public $centralize = true;
	
	public function itemView()
	{
		return 'pictureCard';
	}
	
	public function filter()
	{
		return false;
	}
	
	public function dataProvider()
	{
		$criteria = isset($this->dto['criteria'])?$this->dto['criteria']:new CDbCriteria;
		$order = isset($this->dto['order'])?$this->dto['order']:'t.created DESC';
		
		return new CActiveDataProvider('MPicturePostList', array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => $order),
			'pagination' => array('pageSize' => 25, 'validateCurrentPage' => false)
		));
	}
	
	public function afterConfig()
	{
		$this->options['template'] = "{items}\n{pager}";
		$this->options['emptyText'] = '';
		app()->controller->layout = 'fullscreen';
		
		wm()->add('picture.scroll');
		
		if($this->centralize)
			cs()->registerCss(__CLASS__,'#main {margin-left: 0;} #wlt-PictureList .items {margin: 0 auto;}');
	}

	public function taskRenderOutput()
	{
		$this->beginContent('pictureList');
		parent::taskRenderOutput();
		$this->endContent();

		cs()->registerScriptFile(asma()->publish(Yii::getPathOfAlias('picture.js.masonry.jquery').'.masonry.min.js'));
		cs()->registerScriptFile(asma()->publish(Yii::getPathOfAlias('picture.js.infinitescroll.jquery').'.infinitescroll.min.js'));
		cs()->registerScript(__CLASS__,'
			var $container = $("#'.$this->getDOMId().'-list > .items");
			$container.masonry({
				itemSelector: ".pictureItem",
				columnWidth: 222,
				gutterWidth: 15,
				isFitWidth: true
			});
			
			if($("#'.$this->getDOMId().'-list .pager").length)
				$container.infinitescroll({
					navSelector  : "#'.$this->getDOMId().'-list .pager",
					nextSelector : "#'.$this->getDOMId().'-list .pager .next a",
					itemSelector : ".pictureItem",
					bufferPx     : 500,
					loading: {
						img: "'.url('/').'/css/loading.gif'.'",
						msgText: "'.$this->t('Loading more {#post_ns}...').'",
						finishedMsg: "",
						selector: ".loadingDiv"
					}
				},
				// trigger Masonry as a callback
				function( newElements ) {
				var $newElems = $( newElements );
				$container.masonry( "appended", $newElems );
				});');
	}
	
	public function form()
	{
		return false;
	}
}