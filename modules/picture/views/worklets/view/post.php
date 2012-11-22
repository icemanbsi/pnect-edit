<div class='clearfix append-bottom'>
	<div class='column'><?php
		$this->render('avatar', array('model' => $post->user));
	?></div>
	<div class='column last'>
		<h2><?php
			echo CHtml::link($post->user->firstName.' '.$post->user->lastName,$post->user->Url);
		?></h2><div class='channelInfo'><?php
		echo wm()->get('picture.helper')->channel($post);
		?></div>
	</div>
</div>

<hr />

<div class='pictureButtons'><?php
	app()->controller->worklet('picture.buttons', array('post' => $post));
?></div>

<div class='pictureImage'><?php
	echo $this->content();
?></div>

<div class='pictureMessage'><?php echo $post->message; ?></div>