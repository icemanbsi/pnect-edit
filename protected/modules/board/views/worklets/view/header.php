<div class='container'>
	<h3><?php
echo $this->board()->title;
?></h3>
	<?php if ($this->board()->description) { ?>
		<div class='description'><?php
	echo $this->board()->description;
		?></div>
	<?php } ?>
	<div class='clearfix'>
		<div class='column'><?php
	$this->render('avatarAndInfo', array(
		'model' => $this->board()->user,
		'info' => CHtml::link($this->board()->user->name, $this->board()->user->url)
	));
	?></div>
		<div class='floatRight'><?php
			echo $this->t('{num} followers', array(
				'{num}' => wm()->get('network.helper')->stats($this->board()->id, 'boardFollowers')
			));
			echo ', ';
			echo m('picture')->t('{num} {#post_ns_ucf}', array(
				'{num}' => $this->board()->postsCount
			));
	?></div>
		<div class='txt-center buttonLink'><?php
			echo ($this->board()->userId == app()->user->id || app()->user->checkAccess('administrator')) ?
					CHtml::link($this->t('Edit'), url('/board/update', array('id' => $this->board()->id))) :
					wm()->get('network.helper')->followLink(null, $this->board());
	?></div>
	</div>
</div>