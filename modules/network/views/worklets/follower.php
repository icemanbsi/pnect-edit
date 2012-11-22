<div class='follower clearfix'>
	<div class='column'><?php
		$this->render('avatar', array('model' => $data->user));
	?></div>
	<div class='column'><?php
		echo CHtml::link($data->user->name, $data->user->url);
	?></div>
	<div class='floatRight'><?php
		echo wm()->get('network.helper')->followLink($data->user);
	?></div>
</div>

