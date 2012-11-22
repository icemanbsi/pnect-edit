<?php $mailer->Subject = m('picture')->t('{user} started following you', array('{user}' => $user->name));?>
<br />
Hello <?php echo $follow->name; ?>!
<br />
<?php echo CHtml::image($user->AvatarImg);?> <?php echo CHtml::link($user->name,$user->Url); ?> started following you.
<br />
<?php app()->controller->renderPartial('/system/emails/signature'); ?>
