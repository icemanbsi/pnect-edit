<div class='follower clearfix'>
	<div class='column'><?php
		$this->render('avatar', array('model' => $data->follow));
	?></div>
	<div class='column'><?php
		echo CHtml::link($data->follow->name, $data->follow->url);
	?></div>
	<div class='floatRight'><?php
		echo wm()->get('network.helper')->followLink($data->follow);
	?></div>
</div>

