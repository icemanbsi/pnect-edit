<div class='clearfix'>
	<div class='column colborder'><?php
		echo $this->form->render();
	?></div>
	<div class='column last' id="wlt-PictureList"><?php
		$this->render('pictureCard',array('data'=>$this->original));
	?></div>
</div>