<?php
class WPictureJs extends UWidgetWorklet
{
	public function accessRules()
	{
		return array(array('allow','users'=>array('*')));
	}
	
	public function taskConfig()
	{
		$file = app()->basePath.'/runtime/picture.parser.js';
		if(!file_exists($file) || YII_DEBUG)
		{
			$url = aUrl('/');
			$parsed = parse_url($url);
			$domain = str_replace("www.","",$parsed['host']);
			
			$source = file_get_contents(Yii::getPathOfAlias('picture.data.picture').'.parser.js');
			$params = array(
				'{popupUrl}' => aUrl('/picture/post'),
				'{alreadyInstalled}' => $this->escape($this->t('Drag and drop this button to your Bookmarks Bar. Once installed in your browser the "{#post_button}" lets you grab an image from any website and add it to one of your boards.')),
				'{noImagesFound}' => $this->escape($this->t('Unfortunately we were not able to find any big images.')),
				'{baseUrlRegex}' => '^(http|https):\/\/('.preg_quote($domain,'/').'|'.preg_quote('www.'.$domain,'/').')',
				'{minWidth}' => $this->param('minWidth'),
				'{cancel}' => $this->escape($this->t('Cancel')),
				'{logo}' => CHtml::link(
					(app()->theme?CHtml::image(app()->request->hostInfo.app()->theme->baseUrl.'/images/logo.png'):$this->escape(app()->name)),
					aUrl('/'),
					array('target' => '_blank')
				),
				'{postit}' => $this->escape($this->t('{#post_v_ucf}')),
				'{finder}' => $this->finder(),
				'{spot}' => $this->spot(),
				'{style}' => $this->style(),
			);
			$source = strtr($source,$params);
			file_put_contents($file,$source);
		}
		else
			$source = file_get_contents($file);
		
		$this->send($source);
	}
	
	public function taskSend($source)
	{
		Header("content-type: application/x-javascript");
		echo $source;
		app()->end();
	}
	
	public function taskEscape($str)
	{
		return str_replace("'","\'",$str);
	}
	
	public function taskFinder()
	{
		return strtr('for (var i = 0; i < document.images.length; i++)
		{
			var img = document.images[i];

			if ((img.width >= {minWidth} || img.height >= {minWidth}) && (typeof img.src != \'undefined\') && !in_array(img.src, srcs, true))
			{				
				imgs.push(img);
				srcs.push(img.src);
			}
		}', array(
			'{minWidth}' => $this->param('minWidth'),
		));
	}
	
	public function taskStyle()
	{
		return '';
	}
	
	public function taskSpot()
	{
		return '';
	}
}