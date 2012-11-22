<?php
class BBaseOptimize extends UWorkletBehavior
{
	public function beforeBuild()
	{
		$all = asma()->publish(app()->basePath .DS. 'assets' .DS. 'all.css');
		cs()->registerCssFile($all);
		$scriptMap = array(
			'network.eventList.css' => $all,
			'network.followers.css' => $all,
			'network.following.css' => $all,
			'network.invite.css' => $all,
			'network.inviteMenu.css' => $all,
			'board.card.css' => $all,
			'board.cover.index.css' => $all,
			'board.init.css' => $all,
			'board.initSide.css' => $all,
			'board.list.css' => $all,
			'board.view.css' => $all,
			'picture.category.list.css' => $all,
			'picture.comment.add.css' => $all,
			'picture.comment.list.css' => $all,
			'picture.css' => $all,
			'picture.edit.css' => $all,
			'picture.info.follow.css' => $all,
			'picture.options.css' => $all,
			'picture.post.css' => $all,
			'picture.share.menu.css' => $all,
			'picture.view.css' => $all,
			'base.dialog.css' => $all,
			'base.language.css' => $all,
			'base.menu.css' => $all,
			'base.topMenu.css' => $all,
			'location.select.css' => $all,
			'user.menu.css' => $all,
		);
		cs()->scriptMap = CMap::mergeArray(cs()->scriptMap,$scriptMap);
		$all = asma()->publish(app()->basePath .DS. 'assets' .DS. 'all.js');
		cs()->registerScriptFile($all);
		$scriptMap = array(
			'jquery.scrollTo-min.js' => $all,
			'jquery.uniprogy.binds.js' => $all,
			'jquery.uniprogy.js' => $all,
			'network.follow.js' => $all,
			'board.cover.index.js' => $all,
			'board.create.js' => $all,
			'board.init.js' => $all,
			'picture.comment.add.js' => $all,
			'picture.comment.list.js' => $all,
			'picture.js' => $all,
			'picture.list.js' => $all,
			'picture.post.js' => $all,
			'picture.share.embed.js' => $all,
			'jquery.uniprogy.loc.js' => $all,
		);
		cs()->scriptMap = CMap::mergeArray(cs()->scriptMap,$scriptMap);

		Yii::addCustomClasses(array('MNetworkParamsForm' => app()->basePath.'/modules/network/models/MNetworkParamsForm.php',
'MNetworkRequestForm' => app()->basePath.'/modules/network/models/MNetworkRequestForm.php',
'UBoardTitleValidate' => app()->basePath.'/modules/board/components/UBoardTitleValidate.php',
'MBoardCoverForm' => app()->basePath.'/modules/board/models/MBoardCoverForm.php',
'MBoardForm' => app()->basePath.'/modules/board/models/MBoardForm.php',
'MBoardParamsForm' => app()->basePath.'/modules/board/models/MBoardParamsForm.php',
'MCmsArticleForm' => app()->basePath.'/modules/customize/models/MCmsArticleForm.php',
'MCmsBlockForm' => app()->basePath.'/modules/customize/models/MCmsBlockForm.php',
'MCmsPageForm' => app()->basePath.'/modules/customize/models/MCmsPageForm.php',
'simple_html_dom' => app()->basePath.'/modules/picture/components/simple_html_dom.php',
'MPictureCategoryForm' => app()->basePath.'/modules/picture/models/MPictureCategoryForm.php',
'MPictureCategoryImageForm' => app()->basePath.'/modules/picture/models/MPictureCategoryImageForm.php',
'MPictureCommentAdd' => app()->basePath.'/modules/picture/models/MPictureCommentAdd.php',
'MPictureForm' => app()->basePath.'/modules/picture/models/MPictureForm.php',
'MPictureParamsForm' => app()->basePath.'/modules/picture/models/MPictureParamsForm.php',
'MPicturePostList' => app()->basePath.'/modules/picture/models/MPicturePostList.php',
'MPictureRepostList' => app()->basePath.'/modules/picture/models/MPictureRepostList.php',
'MPictureUploadForm' => app()->basePath.'/modules/picture/models/MPictureUploadForm.php',
'MAdminLoginForm' => app()->basePath.'/modules/admin/models/MAdminLoginForm.php',
'MAdminToolsMessageModel' => app()->basePath.'/modules/admin/models/MAdminToolsMessageModel.php',
'MAdminToolsThemeModel' => app()->basePath.'/modules/admin/models/MAdminToolsThemeModel.php',
'MBaseAppParamsForm' => app()->basePath.'/modules/base/models/MBaseAppParamsForm.php',
'MBaseCaptchaForm' => app()->basePath.'/modules/base/models/MBaseCaptchaForm.php',
'MBaseContactForm' => app()->basePath.'/modules/base/models/MBaseContactForm.php',
'MBaseFollowForm' => app()->basePath.'/modules/base/models/MBaseFollowForm.php',
'MBaseLanguageForm' => app()->basePath.'/modules/base/models/MBaseLanguageForm.php',
'MLocationForm' => app()->basePath.'/modules/location/models/MLocationForm.php',
'UUsernameValidate' => app()->basePath.'/modules/user/components/UUsernameValidate.php',
'MUserAccountForm' => app()->basePath.'/modules/user/models/MUserAccountForm.php',
'MUserAvatarForm' => app()->basePath.'/modules/user/models/MUserAvatarForm.php',
'MUserInstallForm' => app()->basePath.'/modules/user/models/MUserInstallForm.php',
'MUserListModel' => app()->basePath.'/modules/user/models/MUserListModel.php',
'MUserLoginForm' => app()->basePath.'/modules/user/models/MUserLoginForm.php',
'MUserParamsForm' => app()->basePath.'/modules/user/models/MUserParamsForm.php',
'MUserResetForm' => app()->basePath.'/modules/user/models/MUserResetForm.php',
'MUserRestoreForm' => app()->basePath.'/modules/user/models/MUserRestoreForm.php',
'MUserSignupForm' => app()->basePath.'/modules/user/models/MUserSignupForm.php',
'MInstallLoginForm' => app()->basePath.'/modules/install/models/MInstallLoginForm.php',
));

	}
}