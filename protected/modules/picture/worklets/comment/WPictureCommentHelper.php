<?php
class WPictureCommentHelper extends USystemWorklet
{
	public function taskReportTypeAsString($reportType)
	{
		$types = $this->reportTypeAsList();
		return $types[$reportType];
	}
	
	public function taskReportTypeAsList()
	{
		return array(
			'spam' => $this->t('Spam'),
			'attacks' => $this->t('Attacks a group or individual'),
			'hate-speech' => $this->t('Hateful Speech'),
		);
	}
}