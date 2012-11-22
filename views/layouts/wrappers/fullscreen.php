<?php $this->renderPartial('/layouts/wrappers/head'); ?>
<body>
<div class='fullscreen' id="page">
	
	<div class="prepend-top" id="header">
		<h2 class='column'><?php echo app()->name; ?></h2>
		<div class='topmenu'><?php
			$this->worklet('base.language');
			$this->worklet('base.topMenu');
			$this->worklet('picture.searchForm');
		?></div>
	</div><!-- header -->
	
	<hr />
	
	<?php if(isset($this->clips['menu'])): ?>
	<div id="mainmenu"><?php
		echo $this->clips['menu'];
	?></div><!-- mainmenu -->
	
	<hr />
	<?php endif; ?>
	
	<?php if(app()->user->hasFlash('info')) : ?>
	<div id="info"><div class="notice">
		<?php echo app()->user->getFlash('info'); ?>
	</div></div><!-- info -->	
	<?php
	if(!app()->user->hasFlash('info.fade') || app()->user->getFlash('info.fade')!==false)
		Yii::app()->clientScript->registerScript(
			'hideEffect',
			'$("#info").animate({opacity: 1.0}, 3000).fadeOut("normal");',
			CClientScript::POS_READY
		);
	endif; ?>
	
	<?php echo $content; ?>
	
</div><!-- page -->
<?php
if(isset($this->clips['outside']))
	echo $this->clips['outside'];
?>
</body>
</html>