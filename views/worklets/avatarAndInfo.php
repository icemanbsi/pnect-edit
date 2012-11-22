<div class='clearfix'>
	<div class='column'><?php
		$this->render('avatar', array('model' => $model));
	?></div>
	<div class='column avatarInfo'><?php
		echo $info;
	?></div>
</div>