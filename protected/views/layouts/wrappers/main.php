<?php $isAdmin = wm()->get('admin.helper')->layout(); ?>
<?php $this->renderPartial('/layouts/wrappers/head'); ?>

<body>
<div class="container" id="page">
	
	<div class="span-24 last prepend-top" id="header">
		<h2 class='column'><?php echo app()->name; ?></h2>
		<?php 
		$this->worklet('base.language');
		if(!$isAdmin) { ?>
		<div class='topmenu'><?php
			$this->worklet('base.topMenu');
			$this->worklet('picture.searchForm');
		?></div>
		<?php } ?>
	</div><!-- header -->
	
	<hr />
	
	<?php if($isAdmin): ?>
	<div class="span-24 last" id="mainmenu"><?php
			$this->worklet('admin.menu');
	?></div><!-- mainmenu -->
	
	<hr />
	
	
	<?php if(count($this->breadcrumbs)):
	$this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
		'homeLink'=> CHtml::link($this->t('Home'),wm()->get('admin.helper')->homeLink()),
	));
	?><hr /><?php
	endif; ?><!-- breadcrumbs -->
	
	<?php endif; ?>
	
	<?php if(app()->user->hasFlash('info')) : ?>
	<div class="span-24 last" id="info"><div class="notice">
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
	
	<div id='footer' class='container txt-center'><hr /><?php echo isset(app()->params['poweredBy'][app()->language])?app()->params['poweredBy'][app()->language]:''; ?></div>
	
</div><!-- page -->

<?php
if(isset($this->clips['outside']))
	echo $this->clips['outside'];
?>
</body>
</html>