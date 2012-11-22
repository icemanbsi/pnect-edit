<div class='clearfix'>
	<div class='column add'><?php
		echo CHtml::link(m('picture')->t('Add a {#post_n_ucf}'), url('/picture/add'), array('class' => 'uDialog'));
	?></div>
	<? if(!wm()->get('base.helper')->isMobile()){ ?>
	<div class='column upload'><?php
		echo CHtml::link(m('picture')->t('Upload a {#post_n_ucf}'), url('/picture/upload'), array('class' => 'uDialog'));
	?></div>
	<? } ?>
	<div class='column board'><?php
		echo CHtml::link(m('picture')->t('Create a Board'), url('/board/create'), array('class' => 'uDialog'));
	?></div>
</div>