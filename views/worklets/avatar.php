<?php
	if(!$model)
		return;
	$size = isset($size)?$size:'thumbnail';
?><a class='avatar' href='<?php echo $model->url; ?>'>
	<p><?php echo CHtml::image($model->getAvatarImg($size),$model->name); ?></p>
</a>