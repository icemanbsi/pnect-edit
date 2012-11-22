<?php $mailer->Subject = m('picture')->t('Welcome to {site}!', array('{site}' => app()->name));?>
<br />
Hello <?php echo $user->getName(true); ?>!
<br />
<br />
You are the newest member of <?php echo app()->name ?>, our community to share collections of things you love. We're excited to see you as a member and can't wait to see your <?php echo m('picture')->t('{#post_ns}') ?>.
<br />
<br />
A few tips to get the most out of <?php echo app()->name ?>:
<br />
<br />
- Install the <?php echo CHtml::link($this->t('bookmarklet'), aUrl('/picture/info')) ?>. It lets you add a <?php echo m('picture')->t('{#post_n}') ?> from any website you want with just one click.
<br />
<br />
- Follow boards. <?php echo app()->name ?> is as much about discovering new things as it is about sharing.
<br />
<br />
- <?php echo m('picture')->t('{#post_v_ucf}') ?> carefully! Your <?php echo m('picture')->t('{#post_ns}') ?> will help set the tone for the whole community. Use big images, write thoughtful descriptions, and pin things you really love. 
<br />
<br />
Thanks for joining and happy <?php echo m('picture')->t('{#posting}') ?>!
<br />
<br />
<?php app()->controller->renderPartial('/system/emails/signature'); ?>
