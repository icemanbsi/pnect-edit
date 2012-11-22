<?php $this->beginContent('/layouts/wrappers/'.(isset($wrapper)?$wrapper:'main')); ?>
	
	<div id="main" class="clearfix">
		
		<?php if(isset($this->clips['sidebar'])) { ?>
		<div class="span-6 colborder last" id="sidebar"><?php
		echo $this->clips['sidebar'];
		?></div><!-- sidebar -->
		<?php } ?>
		
		<div <?php echo isset($this->clips['sidebar'])?'class="withOffset"':''; ?> id="content">
		<?php
		echo $this->clips['content'];
		echo $content; ?>
		</div><!-- content -->
		
	</div><!-- main -->
	
<?php $this->endContent(); ?>