<?php echo "<?php\n"; ?>
class <?php echo $name; ?>Theme extends UTheme
{	
	public function spaces()
	{
		return array(
			'main' => array(
				'inside',
				'outside',
				'header',
				'menu',
				'content',
				'sidebar',
				'footer',
				'default' => 'content'
			),
			'fullscreen' => array(
				'inside',
				'outside',
				'header',
				'menu',
				'content',
				'sidebar',
				'footer',
				'default' => 'content'
			),
			'popup' => array(
				'content',
				'default' => 'content'
			),
			'email' => array(
				'content'
			),
			'system' => array(
				'content',
				'default' => 'content'
			),
		);
	}
	
	public function routes()
	{
		return array();
	}
	
	public function worklets()
	{
		return array(
		);
	}
	
	public static function getThemeName()
	{
		return '<?php echo $name; ?>';
	}
}