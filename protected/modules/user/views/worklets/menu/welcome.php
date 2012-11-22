<div class="column welcome"><div>
	<?php
		if($model->avatar)
			echo CHtml::image(wm()->get('base.helper')->bin($model->avatarBin)->getFileUrl('original'), $model->name, array('align' => 'right'));
	?>
	<?php echo $this->t('Hi {user}!',array('{user}'=>$model->name)); ?><br />
	<span class='logoutLink'><?php echo CHtml::link($this->t('Sign Out'),url('/user/logout')); ?></span>
</div></div>