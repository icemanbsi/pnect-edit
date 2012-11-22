<div class="gift">
	<?php
	$link = $this->render('price', array('clsCnt' => 'view', 'price' => $gift->price), true);
	if ($post->img) {
		$link .= CHtml::image($post->img);
		if ($post->source)
			$link = CHtml::link($link, $post->source, array('target' => '_blank'));
	}
	echo $link;
	?>
</div>
