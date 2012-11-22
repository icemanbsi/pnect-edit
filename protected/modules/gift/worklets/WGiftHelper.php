<?php
class WGiftHelper extends USystemWorklet
{
	public function taskCss()
	{
		$assets = asma()->publish($this->module->basePath . DS . 'assets');
		cs()->registerCssFile($assets . '/gift.css');
	}

	public function taskPriceViewFormat($price,$escape=false)
	{
		return $this->priceFormat(sprintf("%.2f",$price),$escape);
	}

	public function taskPriceFormat($price,$escape=false)
	{
		$symbol = m('gift')->params['symbol'];
		return strtr(m('gift')->params['template'], array(
			'{price}' => str_replace('.', app()->locale->getNumberSymbol('decimal'),$price),
			'{symbol}' => $escape?preg_quote($symbol,'/'):$symbol
		));
	}

	public function taskGetPrice($message)
	{
		$matches = array();
		$pattern	= '/' . $this->priceFormat('(\d+' . preg_quote(app()->locale->getNumberSymbol('decimal'),'/') . '?\d?\d?)', true) . '/';
		preg_match($pattern, $message, $matches);
		
		return $matches ? str_replace(app()->locale->getNumberSymbol('decimal'), '.', $matches[1]) : null;
	}

}