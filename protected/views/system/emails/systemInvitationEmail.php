<?php $mailer->Subject = $this->t('Invitation to the site {site}.', array('{site}'=>$site)); ?>
Your invitation to <?php echo app()->name; ?> is now available!<br /><br />
Please click on the link to register:<br />
<?php echo CHtml::link($link,$link); ?><br />
<br />
<?php app()->controller->renderPartial('/system/emails/signature'); ?>