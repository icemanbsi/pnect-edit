<?php
class WBaseMeta extends UMetaWorklet
{
	public function metaData()
	{
		$md = array(
			'index' => array(
				'title' => ''
			),
		);
		if(app()->controller->action->id == 'page' && isset($_GET['view']))
		{
			switch($_GET['view'])
			{
				case 'privacy':
					$md['page']['title'] = $this->t('Privacy Policy');
					break;
				case 'terms':
					$md['page']['title'] = $this->t('Terms of Use');
					break;
			}
		}
		return $md;
	}
}
