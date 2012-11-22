<?php $isAdmin = wm()->get('admin.helper')->layout(); ?>
<?php $this->renderPartial('/layouts/wrappers/head'); ?>

<body class='classic-theme'>
<div id="page">
	
	<div id="header">
		<div class='container'>
			<h2 class='column'><?php echo CHtml::link(CHtml::image(app()->theme->baseUrl.'/images/logo.png', app()->name),url('/')); ?></h2>
			<?php 
				$this->worklet('base.language');
				if(!$isAdmin) {
					$this->worklet('picture.searchForm');
					?><div class='topmenu'><?php
						$this->worklet('base.topMenu');
					?></div>
			<?php } ?>
		</div>
	</div><!-- header -->
	
	<?php if(app()->user->hasFlash('info')) : ?>
	<div class='container'><div id="info"><div class="notice">
		<?php echo app()->user->getFlash('info'); ?>
	</div></div></div><!-- info -->	
	<?php
	if(!app()->user->hasFlash('info.fade') || app()->user->getFlash('info.fade')!==false)
		Yii::app()->clientScript->registerScript(
			'hideEffect',
			'$("#info").animate({opacity: 1.0}, 3000).fadeOut("normal");',
			CClientScript::POS_READY
		);
	endif; ?>
	
	<div class='container'>
		<?php echo $content; ?>
		<div class='txt-center prepend-top'><?php echo isset(app()->params['poweredBy'][app()->language])?app()->params['poweredBy'][app()->language]:''; ?></div>
	</div>
	
</div><!-- page -->
<?php
if(isset($this->clips['outside']))
	echo $this->clips['outside'];
?>
</body>
</html><?php

wm()->get('customize.theme.helper')->css('main');