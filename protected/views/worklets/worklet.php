<div id="<?php echo $id; ?>" class="<?php echo ($id != "wlt-PictureList" ? "worklet" : "section")?>">
	<?php if($title) { ?><h3 class="worklet-title"><?php echo $title; ?></h3><?php } ?>
	<div class="worklet-info notice hide"></div>
	<div class="worklet-content"><?php echo $content; ?></div>
</div>