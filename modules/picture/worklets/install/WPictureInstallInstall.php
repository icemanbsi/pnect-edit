<?php
class WPictureInstallInstall extends UInstallWorklet
{
	public function taskModuleParams()
	{
		return CMap::mergeArray(parent::taskModuleParams(),array (
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
			'words' => array(
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
		));
	}
	
	public function taskModuleFilters()
	{
		return array(
			'admin' => 'picture.main',
			'base' => 'picture.main',
			'user' => 'picture.main',
		);
	}
	
	public function taskModuleAuth()
	{
		return array(
			'items' => array(	
				'post.editor' => array(1,NULL,'return $params->userId == app()->user->id;',NULL),
				'post.edit' => array(1,'Post edit access',NULL,NULL),
			),
			'children' => array(
				'user' => array('post.editor'),
				'post.editor' => array('post.edit'),
				'administrator' => array('post.edit')
			),
		);
	}
	
	public function taskSuccess()
	{
		parent::taskSuccess();
		
		$preset = array('Architecture','Art','Cars & Motorcycles','Design',
			'DIY & Crafts','Education','Film, Music & Books','Fitness',
			'Food & Drink','Gardening','Geek','Hair & Beauty','History',
			'Holidays','Home Decor','Humor','Kids','My Life','Women\'s Apparel',
			'Men\'s Apparel','Outdoors','People','Pets','Photography',
			'Print & Posters','Products','Science & Nature','Sports',
			'Technology','Travel & Places','Wedding & Events','Other');
		
		Yii::import('picture.models.MPictureCategoryForm',true);
		foreach($preset as $p)
		{
			$m = new MPictureCategoryForm;
			$m->enabled = 1;
			$m->url = strtolower(preg_replace('/[^A-Za-z|0-9]{1,}/','-',$p));
			$m->name = array('en_us' => $p);
			$m->save();
			
			wm()->get('base.helper')->translations('PictureCategory',$m,'name');
		}
	}
}