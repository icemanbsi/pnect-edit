<?php

class WBoardHelper extends USystemWorklet {

	// You can use the following function to translit chars in you language into English chars. 
	// Or generate the unique board URL using e.g. uniqid(); function
	function taskLang2Lat($string) {

		// return uniqid();
		$tr = array(
			"q" => "q", "w" => "w", "e" => "e", "r" => "r", "t" => "t", "y" => "y", "u" => "u", "i" => "i",
			"o" => "o", "p" => "p", "a" => "a", "s" => "s", "d" => "d", "f" => "f", "g" => "g", "h" => "h",
			"j" => "j", "k" => "k", "l" => "l", "z" => "z", "x" => "x", "c" => "c", "v" => "v", "b" => "b",
			"n" => "n", "m" => "m", "Q" => "Q", "W" => "W", "E" => "E", "R" => "R", "T" => "T", "Y" => "Y",
			"U" => "U", "I" => "I", "O" => "O", "P" => "P", "A" => "A", "S" => "S", "D" => "D", "F" => "F",
			"G" => "G", "H" => "H", "J" => "J", "K" => "K", "L" => "L", "Z" => "Z", "X" => "X", "C" => "C",
			"V" => "V", "B" => "B", "N" => "N", "M" => "M", "." => "_", " " => "_", "?" => "_", "/" => "_",
			"\\" => "_", "*" => "_", ":" => "_", "*" => "_", "\"" => "_", "<" => "_", ">" => "_", "|" => "_"
		);
		return strtr($string, $tr);
	}

	public function taskUrl($model) {
		$string = $this->lang2Lat($model->title);
		$url = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
		if (!$url)
			$url = $model->id;
		else
			$url = strtolower(preg_replace('/[^A-Za-z|0-9|_|-|\']{1,}/', '-', $url));
		return $url;
	}

	public function taskNewBoards() {
		$boards = explode("\n", $this->module->params['newBoards']);
		return $boards;
	}

}