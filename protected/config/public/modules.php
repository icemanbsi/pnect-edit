<?php
 return array (
  'modules' => 
  array (
    'gift' => 
    array (
      'params' => 
      array (
        'symbol' => 'Rp',
        'template' => '{symbol} {price}',
        'version' => '1.0.6',
      ),
    ),
    'admin' => 
    array (
      'params' => 
      array (
        'version' => '1.1.2',
      ),
      'filters' => 
      array (
        'customize.main' => true,
        'user.main' => true,
        'picture.main' => true,
        'network.main' => true,
        'admin.main' => true,
      ),
    ),
    'base' => 
    array (
      'params' => 
      array (
        'version' => '1.1.2',
        'languages' => 
        array (
          'en_us' => 'English (US)',
        ),
      ),
      'filters' => 
      array (
        'customize.main' => true,
        'user.main' => true,
        'board.main' => true,
        'picture.main' => true,
        'base.main' => true,
        'admin.main' => true,
        'gift.main' => true,
      ),
    ),
    'location' => 
    array (
      'params' => 
      array (
        'version' => '1.1.2',
      ),
    ),
    'network' => 
    array (
      'params' => 
      array (
        'version' => '1.1.2',
        'invitesPerDay' => '100',
        'inviteTimeLimit' => '24',
        'notifyEmail' => '',
      ),
    ),
    'picture' => 
    array (
      'params' => 
      array (
        'version' => '1.1.2',
        'extensions' => 'jpeg,jpg,tif,tiff,bmp,gif,png',
        'minWidth' => '150',
        'resizeLarge' => '600',
        'resizeMedium' => '190',
        'resizeSmall' => '75',
        'url' => 'pin',
        'likes' => '24',
        'reposts' => '24',
        'formula' => '{reposts}*150+{comments}*100+{likes}*50-{time}',
        'homepage' => 'picture.index',
        'commentInCard' => 10,
        'commentInView' => 100,
        'commentLength' => 500,
        'words' => 
        array (
          'post_n' => 'post',
          'post_n_ucf' => 'Post',
          'post_ns' => 'posts',
          'post_ns_ucf' => 'Posts',
          'post_v' => 'post',
          'post_v_ucf' => 'Post',
          'posted' => 'posted',
          'posted_ucf' => 'Posted',
          'repost' => 'repost',
          'reposts_ucf' => 'Reposts',
          'repost_ucf' => 'Repost',
          'reposted' => 'reposted',
          'reposted_ucf' => 'Reposted',
          'post_button' => 'Post Button',
          'posting' => 'posting',
          'posting_ucf' => 'Posting',
        ),
      ),
      'filters' => 
      array (
        'gift.main' => true,
      ),
    ),
    'board' => 
    array (
      'params' => 
      array (
        'version' => '1.1.2',
        'allowBoardUrl' => '0',
        'newBoards' => 'Products I Love
Favorite Places & Spaces
Books Worth Reading
My Style
For the Home
Dream Home
Neighborhood Finds
Wedding Ideas
Favorite Recipes
Craft Ideas
Things for My Wall
Places I\'d Like to Go
People I Admire
Party Ideas
Kid\'s Room',
      ),
      'filters' => 
      array (
        'board.main' => true,
      ),
    ),
    'user' => 
    array (
      'params' => 
      array (
        'version' => '1.1.2',
        'emailVerification' => '1',
        'approveNewAccounts' => '0',
        'unverifiedAccess' => '1',
        'unapprovedAccess' => '1',
        'verificationTimeLimit' => '48',
        'passwordResetTimeLimit' => '24',
        'captcha' => '1',
        'inactivityTimeLimit' => '15',
        'fileTypes' => 'jpg, gif, png',
        'fileSizeLimit' => '4',
        'fileOriginalResize' => '200',
        'fileThumbnailResize' => '100',
        'bannedIPs' => '',
      ),
      'filters' => 
      array (
        'user.main' => true,
        'board.main' => true,
        'picture.main' => true,
        'network.main' => true,
        'admin.main' => true,
      ),
    ),
    'customize' => 
    array (
      'params' => 
      array (
        'version' => '1.1.2',
      ),
    ),
    'install' => 
    array (
    ),
  ),
  'params' => 
  array (
    'version' => '1.1.2',
    'adminLogin' => 'admin',
    'adminPassword' => 'password',
    'adminUrl' => 'admincp',
    'publicAccess' => '1',
    'inviteOnly' => '0',
    'maxCacheDuration' => '3600',
    'dst' => '1',
    'systemEmail' => 'no-reply@localhost',
    'contactEmail' => 'contact@localhost',
    'htmlEmails' => '1',
    'poweredBy' => 
    array (
      'en_us' => '<a href="http://uniprogy.com/pinnect" target="_blank">Powered by Pinnect</a>',
    ),
    'keywords' => 'pinnect, uniprogy',
    'description' => 'This site is powered by Pinnect',
    'mailPriority' => '3',
    'mailCharSet' => 'utf-8',
    'mailEncoding' => '8bit',
    'mailMailer' => 'mail',
    'mailSendmail' => '/usr/sbin/sendmail',
    'mailHost' => 'localhost',
    'mailPort' => '25',
    'mailSMTPSecure' => '',
    'mailSMTPAuth' => '0',
    'mailUsername' => '',
    'mailPassword' => '',
    'mailTimeout' => '10',
    'timeZone' => '0',
    'cronSecret' => '059fd20faa084f3b8aed0aedcf4dcfa8',
    'uploadWidget' => '1',
  ),
  'name' => 'Pinnect',
  'theme' => 'classic',
);