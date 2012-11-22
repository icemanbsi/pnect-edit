<?php
	$event = wm()->get('network.eventManager')->read($data);
	if($event):
?><div class='clearfix event'>
	<div class='column avatar'>
		<p><?php echo CHtml::image($event['image']); ?></p>
	</div>
	<div class='span-4 last message'><?php
		echo $event['message'];
	?></div>
</div><?php
	endif;