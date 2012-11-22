<?php
class BGiftBaseMenu extends UWorkletBehavior
{
	public function afterConfig($result)
	{
		$this->owner->insert('bottom',array(array('label' => $this->t('Gifts'), 'url' => url("/gift"), 'items' => $this->menu())));
	}

	public function menu()
	{
		$items = array();
		$menu = MGiftMenuForm::model()->findAll();
		$symbol = m('gift')->params['symbol'];
		foreach ($menu as $m){
			$params = array();
			$params[] = '/gift/index';
			$params['priceStart'] = $m->priceStart;
			if($m->priceEnd)
				$params['priceEnd'] = $m->priceEnd;
			$items[] = array('label' => $this->t('{priceStart}{priceEnd}', array('{priceStart}' => wm()->get('gift.helper')->priceFormat($m->priceStart),
					'{priceEnd}' => $m->priceEnd ? '-' . wm()->get('gift.helper')->priceFormat($m->priceEnd) : '+')),
				'url' => $params);
		}
		return $items;
	}

}
