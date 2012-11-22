<?php
class WCustomizeArticleHelper extends USystemWorklet
{
	public function title()
	{
		return $this->t('Help Articles');
	}
	
	public function description()
	{
		return $this->t('Here you can create knowledge articles to help your users.');
	}
}