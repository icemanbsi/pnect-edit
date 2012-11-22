<?php
class WBoardList extends UWidgetWorklet
{
	public $user;
	
	public function beforeConfig()
	{
		if(isset($_GET['id']))
		{
			$this->user = MUser::model()->findByPk($_GET['id']);
			if(!$this->user)
				throw new CHttpException(404,$this->t('The requested page does not exist.'));	
		}
		else
			throw new CHttpException(404,$this->t('The requested page does not exist.'));
	}
	
	public function afterConfig()
	{
		app()->controller->layout = 'fullscreen';
		wm()->add('board.user',null,array('user'=> $this->user));
	}

	public function taskRenderOutput()
	{
		echo '<div class="clearfix">';
		$id = $this->getDOMId().'-Sortable';
		cs()->registerScript(__CLASS__,'	
			
			jQuery("#StartOrder").click(function(){ 
				$("#'.$id.'").sortable( "option", "disabled", false );  
				$("#OrderControls").show();				
				$("#startButton").hide();
			});
			
			jQuery("#CancelOrder").click(function(){ 
				$("#'.$id.'").sortable( "option", "disabled", true );  
				$("#OrderControls").hide();				
				$("#startButton").show();
			});
			
			jQuery("#SaveOrder").click(function(){ 
				var items = $( "#'.$id.'" ).sortable("toArray");  
				$.ajax({
					url: "/board/saveSortable",
					method: "post",
					data: {order:items},
				});	

				jQuery("#CancelOrder").click();			
			});
		');
		
		$this->widget('zii.widgets.jui.CJuiSortable', array(
			'id' => $id,
			'items'=>  $this->items(),
			'options'=>array(
				'disabled' => true,
				'revert' => false,
				'opacity' => 0.5,
				'scroll' => true,
			),
		));
		echo '</div>';

	}
	
	public function taskItems()
	{
		$items = array();
		$c = new CDbCriteria;
		$c->order = 'sortOrder';
		$c->compare('userId', $this->user->id);
		$boards = MBoard::model()->findAll($c);
		
		foreach ($boards as $board)
			$items[$board->id] = $this->render('boardCard', array('data' => $board), true);
		return $items;
	}
	
	public function beforeRenderOutput()
	{
		$this->render('topMenu');
	}
}