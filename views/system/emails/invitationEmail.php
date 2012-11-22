<?php $mailer->Subject = $this->t('Invitation to the site {site} from the {user}.', array('{site}'=>$site,'{user}' => $user->username)); ?>
<?php echo nl2br($message); ?>
<br />
Please click on the link for registration:<br />
<?php echo CHtml::link($link,$link); ?><br />
<br />
<?php app()->controller->renderPartial('/system/emails/signature'); ?>