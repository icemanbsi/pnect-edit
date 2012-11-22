<?php $this->renderPartial('/layouts/wrappers/head'); ?>
<body class='classic-theme singlepage'>
 <div id="top" class="section full">
	
	<?php /*if(isset($this->clips['menu'])): ?>
	<div id="mainmenu"><?php
		echo $this->clips['menu'];
	?></div><!-- mainmenu -->
	<?php endif; */?>
	<div class="head alt">
        <div class="wrap">
          <div class="logo"><a href="index.php"><?php echo CHtml::link(CHtml::image(app()->theme->baseUrl.'/images/logo.png', app()->name),url('/')); ?></a></div>
          <!-- /logo-->
          <ul class="menu">
            <li><a href="#wlt-PictureList">Picture</a></li>
          </ul>
          <!-- /menu-->
		  <div class="search">
			<?php
			$this->worklet('base.language');
			$this->worklet('picture.searchForm');
			?>
		  </div>
		  <div class='topmenu'><?php
			$this->worklet('base.topMenu');
		?></div>
        </div>
      </div>
      <!-- /head.alt (white colored)-->
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
</div><!-- top -->
	
	<div class="head top">
        <div class="wrap">
          <div class="logo"><a href="index.php"><?php echo CHtml::link(CHtml::image(app()->theme->baseUrl.'/images/logo.png', app()->name),url('/')); ?></a></div>
          <!-- /logo-->
          <ul class="menu">
            <li><a href="#wlt-PictureList">Picture</a></li>
          </ul>
          <!-- /menu-->
		  <div class="search">
			<?php
			$this->worklet('base.language');
			$this->worklet('picture.searchForm');
			?>
		  </div>
        </div>
      </div>
      <!-- /head.top (white colored)-->
	<?php echo $content; ?>
<?php
if(isset($this->clips['outside']))
	echo $this->clips['outside'];
?>
</body>
</html><?php

wm()->get('customize.theme.helper')->css('main');