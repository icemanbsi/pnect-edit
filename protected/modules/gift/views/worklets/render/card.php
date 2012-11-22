<div class="gift">
	<?php
	$content = $this->render('price', array('clsCnt' => 'card', 'price' => $gift->price), true);
	$content .= CHtml::image(wm()->get('base.helper')->bin($data->picture->imageBin)->getFileUrl('medium'), $data->message);
	echo CHtml::link($content, url('/picture/view', array('id' => $data->id)),array('class' => 'lightbox'));
	?>
</div>

