<?php
class WPictureShareHelper extends USystemWorklet
{
	public function taskReportTypeAsString($reportType)
	{
		$types = $this->reportTypeAsList();
		return $types[$reportType];
	}
	
	public function taskReportTypeAsList()
	{
		return array(
			'nudity' => $this->t('Nudity or Pornography'),
			'attacks' => $this->t('Attacks a group or individual'),
			'graphic-violence' => $this->t('Graphic Violence'),
			'hate-speech' => $this->t('Hateful Speech or Symbols'),
			'spam' => $this->t('Spam'),
			'other' => $this->t('Other'),
		);
	}
}