<?php

class WBoardInitSide extends UWidgetWorklet {

	public $space = 'sidebar';

	public function title() {
		return $this->t('Board Ideas');
	}

	public function taskConfig() {
		if (count(wm()->get('board.helper')->newBoards()) < 5)
			$this->show = false;
		parent::taskConfig();
	}

	public function taskRenderOutput() {
		parent::taskRenderOutput();
		$content = '';
		foreach (wm()->get('board.helper')->newBoards() as $k => $v) {
			if ($k < 5)
				continue;
			$content .= CHtml::tag('li', array(), CHtml::link($v . CHtml::image(aUrl("/images/plus.png")), '#', array('class' => 'addBoard','name' => $v)));
		}
		echo CHtml::tag('ul', array(), $content);

		$script = 'jQuery("#wlt-BoardInitSide .addBoard").click(function(){
			var link = this;
			var doAdd = true;
			
			$(\'#wlt-BoardInit input[name="boards[]"]\').each(function(){
				if($(this).val() == $(link).attr("name"))
					doAdd = false;
			});
			
			if(doAdd)
			{
				var newField = $("' . wm()->get('board.init')->render('newBoard', array(), true) . '");
				newField.find("input").val($(link).attr("name"));
				$(".boardsList").append(newField);
			}
			
			return false;
		});';
		cs()->registerScript(__CLASS__, $script);
	}

}
