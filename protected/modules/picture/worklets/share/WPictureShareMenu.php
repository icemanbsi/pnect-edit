<?php

class WPictureShareMenu extends UMenuWorklet {

	public $space = 'outside';
	public $post;

	public function taskConfig() {
		if (!$this->post)
			return $this->show = false;
		parent::taskConfig();
	}

	public function taskItems() {
		$items = array();
		$items[] = array('label' => $this->t('Embed'), 'url' => url('/picture/share/embed', array('post' => $this->post->id)),
			'itemOptions' => array('class' => 'embedButton'),
			'linkOptions' => array('class' => 'uDialog'));

		$items[] = array('label' => $this->t('Report {#post_n}'), 'url' => url('/picture/share/report', array('post' => $this->post->id)),
			'itemOptions' => array('class' => 'reportButton'),
			'linkOptions' => array('class' => 'uDialog'));

		$items[] = array('label' => $this->t('Email'), 'url' => url('/picture/share/email', array('post' => $this->post->id)),
			'itemOptions' => array('class' => 'emailButton'),
			'linkOptions' => array('class' => 'uDialog'),
			'visible' => !app()->user->isGuest);
		
		$items[] = array('label' => $this->t('Delete Post'), 'url' => url('/picture/delete', array('id' => $this->post->id)),
			'visible' => app()->user->checkAccess('administrator'),
			'linkOptions' => array('class' => 'delete'));
		
		$items[] = array('label' => $this->t('Delete Picture'), 'url' => url('/picture/admin/deleteAll', array('id' => $this->post->pictureId)),
			'visible' => app()->user->checkAccess('administrator'),
			'linkOptions' => array('class' => 'delete'));
		
		return $items;
	}

	public function properties() {
		return array('items' => $this->items());
	}
	
	public function afterRenderOutput()
	{
		cs()->registerScript(__CLASS__,'jQuery(".delete").click(function(){
			if(confirm("'.$this->t('Are you sure?').'"))
			{
				$.ajax({
					url: $(this).attr("href"),
					success: function(data){
						window.location = "'.url('/').'";
					}
				});
			}
			return false;
		});');
	}

}