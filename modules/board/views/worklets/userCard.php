<div class='clearfix userCard'>
	
	<h2><?php echo $data->name; ?></h2>
	
	<div class='append-bottom'><?php
		echo CHtml::link($this->t('{num} followers', array(
			'{num}' => wm()->get('network.helper')->stats($data->id,'followers')
		)),url('/network/followers', array('username' => $data->username)));
		echo ', ';
		echo CHtml::link($this->t('{num} following', array(
			'{num}' => wm()->get('network.helper')->stats($data->id,'following')
		)),url('/network/following', array('username' => $data->username)));
	?></div>
	
	<?php $this->render('avatar', array('model' => $data, 'size' => 'original')); ?>
	
	<div class="userAction prepend-top buttonLink"><?php
		echo app()->user->id == $data->id
			? CHtml::link($this->t('Edit Profile'), url('/user/account'))
			: wm()->get('network.helper')->followLink($data,null);
	?></div>
	
	<div class='prepend-top buttonLink'>
		<?php echo CHtml::link($this->t('RSS Feed'),wm()->get('picture.rss')->link($data)); ?>
	</div>
		
</div>