<div class='clearfix post'>
	<div class='column'><?php $this->render('avatar', array('model' => $data->user)); ?></div>
	<div class='message txt-left'>
		<div class='author'><?php echo CHtml::link($data->user->name,$data->user->url); ?></div>
		<div class='message-txt'><?php echo app()->format->formatNText($data->text); ?></div>
		<div class='actionLinks'><?php
			echo CHtml::link($this->t('Report'), url('/picture/comment/report',
				array('id' => $data->id)), array('class' => 'uDialog'));

			if((app()->user->id == $data->user->id) || app()->user->checkAccess('administrator'))
				echo CHtml::link($this->t('Delete'), url('/picture/comment/delete', array('id' => $data->id)), array(
					'class' => 'deleteLink'
				));
		?></div>
	</div>
</div>