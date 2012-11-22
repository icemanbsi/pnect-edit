<div class="boardsList">
	<?php 
		foreach (wm()->get('board.helper')->newBoards() as $k => $v) {
			if($k>4) break;
			$this->render('newBoard',array('value'=>$v));
		}
	?>
</div>
