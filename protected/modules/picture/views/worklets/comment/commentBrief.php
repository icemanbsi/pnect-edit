<div class='clearfix post'>
	<div class='column'><?php $this->render('avatar', array('model' => $data->user)); ?></div>
	<div class='message'>
		<div class='message-txt'><?php echo CHtml::link($data->user->name,$data->user->url).' ';
			echo app()->format->formatNText($data->text); ?></div>
	</div>
</div>