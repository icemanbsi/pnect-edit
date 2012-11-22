<?php
class WPicturePost extends UFormWorklet
{
	public $modelClassName = 'MPictureForm';
	public $post;
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function afterModel()
	{
		if($this->isPopup())
		{
			if(isset($_GET['image']))
				$this->model->imageUrl = $_GET['image'];
			if(isset($_GET['source']))
				$this->model->source = $_GET['source'];
			
			app()->controller->layout = 'popup';
		}
	}
	
	public function taskIsPopup()
	{
		return app()->controller->routeEased == 'picture/post' && (!isset($_POST['isPopup']) || $_POST['isPopup']);
	}
	
	public function properties()
	{
		return array(
			'action' => url('/picture/post'),
			'elements' => array(
				CHtml::hiddenField('isPopup', $this->isPopup()),
				'parentId' => array('type' => 'hidden'),
				'imageUrl' => array('type' => 'hidden'),
				'source' => array('type' => 'hidden'),
				'boardType' => array('type' => 'radiolist',
					'items' => array(
						0 => $this->t('Select Board'),
						1 => $this->t('Create New Board'),
					), 'layout' => "<fieldset>{input}</fieldset>"),
				'<div id="picturePostBoardSelect" style="display: none">',
				'boardId' => array('type' => 'dropdownlist', 'items' => wm()->get('picture.helper')->boards()),
				'</div>',
				'<div id="picturePostBoardCreate" style="display: none">',
				'boardTitle' => array(
					'type' => 'text', 
					'attributes' => array('placeholder' => $this->t('Board Title')),
					'layout' => "{input}"
				),
				'categoryId' => array('type' => 'dropdownlist', 'label' => $this->t('Category'),
					'items' => wm()->get('picture.category.helper')->categoryAsList()),
				'</div>',
				'message' => array(
					'type' => 'textarea', 
					'layout' => "{input}\n{hint}",
					'attributes' => array('placeholder' => $this->t('Description')),
				),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => $this->t('{#post_v_ucf} It'))
			),
			'model' => $this->model
		);
	}
	
	public function beforeRenderOutput()
	{
		cs()->registerScriptFile(asma()->publish($this->module->basePath.DS.'js'.DS.'simpleSlide'.DS.'jquery.simpleSlide.js'));
	}
	
	public function taskSettings()
	{
		return array(
			'noImagesFound' => str_replace('"','\"',$this->t('Unfortunately we were not able to find any big images.')),
			'minWidth' => $this->param('minWidth'),
		);
	}
	
	public function afterRenderOutput()
	{
		$settings = CJavaScript::encode($this->settings());
		cs()->registerScript(__CLASS__,'$.uniprogy.picture.post.init('.$settings.');');
		if($this->isPopup())
		{
			$images = CJavaScript::jsonEncode(array($this->model->imageUrl));
			cs()->registerScript('$.uniprogy.picture.post.load',
				'$.uniprogy.picture.post.load('. $images.',"'.CJavaScript::quote($this->model->source).'")');
		}
		$att = 'boardType';
		$name = CHtml::resolveName($this->model(), $att);
		$id = $this->getDOMId().'_'.CHtml::$count++;
		cs()->registerScript(__CLASS__ . $id, 'jQuery("#' . $this->getDOMId() . ' input[name=\'' . $name . '\']:radio").change(function(){
			$("#picturePostBoardCreate").hide();
			$("#picturePostBoardSelect").hide();
			if($(this).is(":checked") && $(this).val() == "1")
				$("#picturePostBoardCreate").show();
			else
				$("#picturePostBoardSelect").show();
		});jQuery("#' . $this->getDOMId() . ' input[name=\'' . $name . '\']:radio").change();');
	}
	
	public function taskSave()
	{
		$helper = wm()->get('picture.helper');
		$channel = '';
		$picture = null;
		
		if($this->model->parentId)
		{
			$parent = MPicturePost::model()->findByPk($this->model->parentId);
			$this->post = $helper->repost($parent, $this->model->boardId, $this->model->message);
			
			wm()->get('picture.event')->repost($parent->id,$this->post->id);			
			wm()->get('picture.helper')->updateStats($this->model->parentId, 'reposts');
			
			$this->successUrl = url('/picture/view', array('id' => $this->post->id));
			return true;
		}
		elseif(is_numeric($this->model->source))
		{
			$bin = wm()->get('base.helper')->bin($this->model->source);
			if($bin)
			{
				$picture = $helper->savePicture($bin->getFilePath('original'), $bin);
				$channel = 'upload';
				$this->model->source = null;
			}
		}
		elseif($this->model->imageUrl)
		{
			$file = $helper->saveInStorage($this->model->imageUrl);
			if($file)
			{
				$picture = $helper->savePicture($file);
				$channel = 'web';
			}
		}
		
		if($picture)
		{
			$this->post = $helper->post($picture->id, $this->model->boardId, $this->model->message, $channel, $this->model->source);
			wm()->get('picture.event')->post($this->post->id);
			$this->successUrl = url('/picture/view', array('id' => $this->post->id));
			return true;
		}
		$this->model->addError('boardId', $this->t('Unknown error occured. Please try again later.'));
	}
	
	public function ajaxSuccess()
	{
		if($this->isPopup())
		{
			$content = $this->render('thankYou',array(),true);
			wm()->get('base.init')->addToJson(array(
				'content' => array('replace' => 
					$content
					.CHtml::script('jQuery("#closeButton").click(function(){window.close();});')
					.CHtml::script('jQuery("#viewButton").click(function(){window.open("'.aUrl('/picture/view', array('id' => $this->post->id)).'");});')
				),
			));
		}
		else
			parent::ajaxSuccess();
	}
}