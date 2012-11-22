<div class='signInBox box'>
	<h3><?php echo $this->t('Already Have an Account?'); ?></h3>
	<?php echo CHtml::button($this->t('Sign In'),array('id' => 'signInButton')); ?>
</div><?php
cs()->registerScript('signInButton', 'jQuery("#signInButton").click(function(){
	$.uniprogy.dialog("'.url('/user/login').'");
});');