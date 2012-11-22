<?php
class WPictureHelper extends USystemWorklet
{
	public function taskChannel($post)
	{
		$when = UTimeWording::timeAgoInWords($post->created);
		switch($post->channel)
		{
			case 'web':
				return $this->t('{#posted_ucf} {when} via {channel}', array(
					'{when}' => $when,
					'{channel}' => $this->t('web')
				));
				break;
			case 'upload':
				return $this->t('{#posted_ucf} {when} by {channel}', array(
					'{when}' => $when,
					'{channel}' => CHtml::link($this->t('user'),$post->user->url)
				));
				break;
			case 'button':
				return $this->t('{#posted_ucf} {when} via {channel}', array(
					'{when}' => $when,
					'{channel}' => CHtml::link($this->t('{#post_button}',
						url('/customize/article/view', array('view' => 'goodies'))))
				));
				break;
			case 'repost':
				if($post->parent)
					return $this->t('{#reposted_ucf} {when} from {from}', array(
						'{when}' => $when,
						'{from}' => CHtml::link($post->parent->board->title,$post->parent->board->link)
					));
				else
					return $this->t('{#reposted_ucf} {when}', array(
						'{when}' => $when
					));
				break;
		}
	}
	
	public function taskChannelBrief($post)
	{
		$this->t('{verb} by {user} onto {board}{from}');
		$this->t(' from {source}');
		
		$phrase = '{verb} by {user} onto {board}{from}';
		$params = array();
		
		$params['{verb}'] = $this->t('{#posted_ucf}');
		$params['{user}'] = CHtml::link($post->user->name,$post->user->url);
		$params['{board}'] = CHtml::link($post->board->title,$post->board->link);
		$params['{from}'] = $post->source
			? $this->t(' from {source}',array('{source}' => CHtml::link($post->sourceDomain,$post->source,array('target' => '_blank'))))
			: '';
		
		if($post->channel == 'repost')
			$params['{verb}'] = $this->t('{#reposted_ucf}');
		
		return $this->t($phrase,$params);
	}
	
	public function taskChannelShare($post)
	{
		$phrase = '{source} via {user} on {site}';
		$params = array(
			'{source}' => $post->source?CHtml::link($post->source, $post->source, array('target' => '_blank')):$this->t('Uploaded by user'),
			'{user}' => CHtml::link($post->user->name, $post->user->getUrl(true), array('target' => '_blank')),
			'{site}' => CHtml::link(app()->name,aUrl('/'), array('target' => '_blank'))
		);
		
		return $this->t($phrase,$params);
	}
	
	public function taskCheckFile($file)
	{
		$headers = @get_headers($file);
		return isset($headers[0]) ? strpos($headers[0],'404') === false : false;
	}
	
	public function taskNormalizePath($file, $url = null)
	{
		$parsed = parse_url($url);
		
		if(!isset($parsed['scheme']))
			return;
		
		$first = substr($file,0,1);
		$second = substr($file,0,2);
		
		if($url && $first == '.')
			$file = dirname($url).'/'.$file;
		elseif($second == '//')
			$file = $parsed['scheme'].':'.$file;
		elseif($url && $first == '/')
			$file = $parsed['scheme'].'://'.$parsed['host'].$file;
		elseif($url && $first != 'h')
			$file = $parsed['scheme'].'://'.$parsed['host'].'/'.$file;

		return $file;
	}
	
	public function taskSupported($path)
	{
		static $extensions;
		if(!isset($extensions))
			$extensions = explode(',', $this->module->params['extensions']);
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		return in_array(strtolower($ext),$extensions);
	}
	
	public function taskImageSize($url)
	{
		$curl = Yii::createComponent(array('class'=>'uniprogy.extensions.curl.CCurl'));
		$curl->addSession($url, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_FAILONERROR => true,
			CURLOPT_HTTPHEADER => array("Range: bytes=0-32768"),
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20100101 Firefox/12.0'
		));
		$result = $curl->exec();
		$curl->clear();
		
		if($result)
		{
			$im = @imagecreatefromstring($result);
			if($im)
				return array(imagesx($im),imagesy($im));
		}
		
		return false;
	}
	
	public function taskGrab($url)
	{
		$curl = Yii::createComponent(array('class'=>'uniprogy.extensions.curl.CCurl'));
		$curl->addSession($url, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_FAILONERROR => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_HEADER => true,
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20100101 Firefox/12.0'
		));
		$result = $curl->exec();
		$curl->clear();
		
		$headers = preg_replace('/\r/','',$result);
		$headers = explode("\n\n",$headers);
		$headers = count($headers)?$headers[0]:'';

		if(preg_match('/Location: ([^\n|\r]+)/i',$headers,$matches))
			$url = rtrim($matches[1],'/');
		
		return array($url, $result);
	}
	
	public function taskCopyFile($url,$dist,$unknownType=false)
	{
		$file = fopen($dist,'w');
		$curl = Yii::createComponent(array('class'=>'uniprogy.extensions.curl.CCurl'));
		$curl->addSession($url, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_FAILONERROR => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_HEADER => false,
			CURLOPT_FILE => $file,
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20100101 Firefox/12.0'
		));
		$curl->exec();
		$curl->clear();
		fclose($file);
		
		$result = file_exists($dist) && filesize($dist);
		if($result)
		{
			if($unknownType)
			{
				$imageinfo = getimagesize($dist);
				$extension = image_type_to_extension($imageinfo[2], false);
				$filename = substr($dist,0,strrpos($dist,'.')+1);
				$newDist = $filename.$extension;
				rename($dist,$newDist);
				return $newDist;
			}
			return $dist;
		}
		
		return $result;
	}
	
	public function taskDom($url,$html=false)
	{
		static $data = array();
		if(!isset($data[$url]))
		{
			Yii::import('application.modules.picture.components.simple_html_dom');
			if($html)
			{
				$data[$url] = new simple_html_dom;
				$data[$url]->load($html);
			}
			else
				$data[$url] = new simple_html_dom($url);
			foreach($data[$url]->find('head,script,link,comment') as $tmp) $tmp->outertext = '';
		}
		return $data[$url];
	}
	
	public function taskImagesFromUrl($url)
	{
		set_time_limit(300);
		
		$images = array();
		
		if($this->supported($url))
			return array($url);
		
		if(!$this->checkFile($url))
			return array();
		
		list($url,$html) = $this->grab($url);
		$data = $this->dom($url,$html);
		// going through all images
		$tags = $data->find('img');
		if(count($tags))
			foreach($tags as $img)
			{
				$src = $this->normalizePath($img->src,$url);
				if($src && !in_array($src,$images) && $this->supported($src) && $this->checkFile($src))
					$images[] = $src;
			}
		
		return $images;
	}
	
	public function taskTr($message, $params = array(), $source = null, $language = null)
	{
		static $words;
		if(!isset($words))
		{
			$words = array();
			if($this->param('words'))
				foreach($this->param('words') as $k=>$v)
					if(!isset($params['{#'.$k.'}']))
						$words['{#'.$k.'}'] = t($v, 'picture', array(), $source, $language);
		}
		$params = array_merge($params,$words);
		return t($message, 'picture', $params, $source, $language);
	}
	
	public function taskWord($form)
	{
		$words = $this->param('words');
		return isset($words[$form])?$words[$form]:null;
	}
	
	public function taskSaveInStorage($url){
		$filename = null;
		if($this->checkFile($url)){
			$end = end(explode(".", $url));
			if(strpos($end, '#'))
				$end = substr($end, 0 ,strpos($end, '#'));
			
			$unknownType = false;
			if(preg_match('/[^A-Za-z|0-9]/',$end))
			{
				$end = 'jpg';
				$unknownType = true;
			}
			$filename = app()->getBasePath().'/runtime/'.uniqid().'.'.$end; 
			$filename = $this->copyFile($url, $filename, $unknownType);
			if(!$filename)
				return null;
		}
		return $filename;
	}
	
	public function taskSavePicture($filename,$bin=null,$userId=null)
	{		
		$userId = $userId?$userId:app()->user->id;
		$picture = null;
		
		if(!is_null($userId) && !is_null($filename) && file_exists($filename))
		{
			$bin = $bin?$bin:wm()->get('base.helper')->bin();
			$bin->put($filename, 'original');

			Yii::import('uniprogy.extensions.image.Image');
			
			$original = $bin->get('original');
			$tmp = Yii::getPathOfAlias($bin->path.'.tmp').'.'.$original->extension;
			
			// large
			copy($bin->getFilePath('original'),$tmp);
			$image = new Image($tmp);							
			if($image->width > $this->module->params['resizeLarge'])
			{
				$image->resize($this->module->params['resizeLarge'], null, Image::WIDTH);
				$bin->put($image, 'large', 'UImageStorageFile');
			}
			else
			{
				$image = $tmp;
				$bin->put($image, 'large');
			}
			
			// medium
			copy($bin->getFilePath('original'),$tmp);
			$medium = new Image($tmp);
			$medium->resize($this->module->params['resizeMedium'], null, Image::WIDTH);
			
			// small
			copy($bin->getFilePath('original'),$tmp);
			$small = new Image($tmp);
			$small->resize($this->module->params['resizeSmall'], null, Image::WIDTH);

			$bin->put($medium, 'medium', 'UImageStorageFile');
			$bin->put($small, 'small', 'UImageStorageFile');
			
			// we have to refresh thumbnail to get its size
			$medium = new Image($bin->getFilePath('medium'));

			$picture = new MPicture;
			$picture->bin = $bin->id;
			$picture->userId = $userId;		
			$picture->height = $medium->height;
			$picture->save();

			$bin->makePermanent($userId);
			
			if(file_exists($tmp))
				unlink($tmp);
		}
		
		return $picture;
	}
	
	public function taskDomain($url)
	{
		$parsed = parse_url($url);
		return isset($parsed['host'])?str_replace('www.', '', $parsed['host']):null;	
	}
	
	public function taskSavePost($pictureId, $boardId, $message, $channel, $source=null, $userId=null, $parentId=null)
	{
		$model = new MPicturePost;
		$model->pictureId = $pictureId;
		$model->boardId = $boardId;
		$model->source = $source;
		$model->sourceDomain = $source?$this->domain($source):null;
		$model->message = htmlspecialchars($message);
		$model->channel = $channel;
		$model->parentId = $parentId;
		$model->userId = $userId ? $userId : app()->user->id;
		$model->save();
		
		return $model;
	}
	
	public function taskPost($pictureId, $boardId, $message, $channel, $source=null, $userId=null)
	{
		return $this->savePost($pictureId, $boardId, $message, $channel, $source, $userId);
	}
	
	public function taskRepost($parent, $boardId, $message, $userId=null)
	{
		return $this->savePost($parent->pictureId, $boardId, $message, 'repost', $parent->source, $userId, $parent->id);
	}
	
	public function taskBoards($userId=null)
	{
		$items = array();
		
		$userId = $userId ? $userId : app()->user->id;

		$models = MBoard::model()->findAll(array(
			'condition' => 'userId=:userId',
			'params' => array(':userId' => $userId),
			'order' => 'title ASC'
		));
		
		if(count($models)){
			$myBoards = array();
			foreach ($models as $value)
				$myBoards[$value->id] = html_entity_decode ($value->title);
			$items[$this->t('My Boards')] = $myBoards;
		}
		
		$models = MBoardUser::model()->findAll('userId=?',array($userId));
		
		if(count($models)){
			$myBoards = array();
			foreach ($models as $value)
				$myBoards[$value->boardId] = html_entity_decode ($value->board->title);
			$items[$this->t('Other Boards')] = $myBoards;
		}

		return $items;
	}
	
	public function taskLikes($postId, $userId=null)
	{
		$userId = $userId?$userId:app()->user->id;
		return MPictureLike::model()->exists('postId=? AND userId=?', array(
			$postId, $userId
		));
	}
	
	public function taskStats($id,$type)
	{
		switch($type)
		{
			case 'boards':
				return MBoard::model()->count('userId=?', array($id));
			case 'posts':
				return MPicturePost::model()->count('userId=?', array($id));
			case 'likes':
				return MPictureLike::model()->count('userId=?', array($id));
		}
	}
	
	public function taskUpdateStats($id,$type)
	{
		$post = MPicturePost::model()->findByPk($id);
		if(!$post)
			return;
		
		switch($type)
		{
			case 'comments':
				$post->comments = MPictureComment::model()->count('postId=?', array($id));
				break;
			case 'likes':
				$post->likes = MPictureLike::model()->count('postId=?', array($id));
				break;
			case 'reposts':
				$post->reposts = MPicturePost::model()->count('parentId=?', array($id));
				break;
		}
		
		$post->save();
	}
	
	public function taskInviteNotice()
	{
		if(app()->param('inviteOnly') && app()->user->isGuest && !app()->user->hasFlash('info'))
		{
			app()->user->setFlash('info', wm()->get('picture.list')->render('invitation',null,true));
			app()->user->setFlash('info.fade', false);
		}
	}
	
	public function taskCardContent($data) {
		return CHtml::link(
				CHtml::image(
						wm()->get('base.helper')->bin($data->picture->imageBin)->getFileUrl('medium'), $data->message
				), url('/picture/view', array('id' => $data->id)),
				array('class'=> 'lightbox')
		);
	}
}