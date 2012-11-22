<div class='invitation clearfix'>
	<div class='buttonLink fixed floatRight'><?php
		echo CHtml::link($this->t('Request an Invite'), url('/network/request/invite'));
		echo CHtml::link($this->t('Login'), url('/user/login'));
	?></div>
	<!--[if IE 8]>
	<p>Your browser is <em>ancient!</em> Upgrade to a latest different browser.</p>
	<![endif]-->	
	<p><?php
	echo $this->t('At this time you can join {site} only via invitation.', array(
		'{site}' => app()->name
	));
	?></p>
</div>