<?php $mailer->Subject = $this->t('{email} asked for invite', array('{site}' => $site, '{email}' => $email));?>
<br />
Hello!
<br />
The user <?php echo $email; ?> asked you for an invitation on the site <?php echo $site; ?>.<br />
Please click on the link to view the request:<br />
<?php echo CHtml::link($link, $link); ?><br />
<br />
<?php app()->controller->renderPartial('/system/emails/signature'); ?>