<?php

class WPictureAdminParams extends UParamsWorklet {

	public function accessRules() {
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users' => array('*'))
		);
	}

	public function properties() {
		$properties = array(
			'elements' => array(
				'homepage' => array('type' => 'radiolist', 'items' => array(
						'picture.index' => $this->t('All Pins'),
						'picture.follow' => $this->t('Users You Follow')),
					'layout' => "{label}\n<fieldset>{input}\n{hint}</fieldset>",
					'label' => $this->t('Site Home Page')),
				'url' => array('type' => 'text', 'label' => $this->t('Picture Module URL'),
					'hint' => aUrl('/') . '/', 'layout' => "{label}\n<span class='hintInlineBefore'>{hint}\n{input}</span>"),
				'likes' => array('type' => 'text', 'label' => $this->t('Likes on Post View Page'),
					'hint' => $this->t('Number of likes to show on post main view page')),
				'reposts' => array('type' => 'text', 'label' => $this->t('Reposts on Post View Page'),
					'hint' => $this->t('Number of reposts to show on post main view page')),
				'formula' => array(
					'type' => 'text', 'class' => 'large',
					'label' => $this->t('"Popularity" Calculation Formula'),
					'hint' => $this->t('Here you can specify a formula, which will be used to determine each post popularity. You can use {reposts}, {comments}, {likes} and {time} variables, where {time} - is the number of seconds that have passed since the post has been created. Ex.: {reposts}*150+{comments}*100+{likes}*50-{time}'),
				),
				'extensions' => array('type' => 'text', 'hint' => $this->t('ex.: jpg, gif, png'), 'label' => 'Supported Image Formats'),
				'minWidth' => array('type' => 'text', 'hint' => $this->t('ex.: 150'), 'label' => 'Minimum width/height of an image to consider for grabbing'),
				'dimsHeader' => '<h4>' . $this->t('Resize Uploaded Images To') . '</h4>',
				'resizeLarge' => array('type' => 'text', 'label' => $this->t('Large View'),
					'hint' => $this->t('ex.: 600 (width only)')),
				'resizeMedium' => array('type' => 'text', 'label' => $this->t('Medium Preview'),
					'hint' => $this->t('ex.: 190 (width only)')),
				'resizeSmall' => array('type' => 'text', 'label' => $this->t('Small Thumbnail'),
					'hint' => $this->t('ex.: 75 (width only)')),
				'commentHeader' => '<h4>' . $this->t('Comments') . '</h4>',
				'commentInCard' => array('type' => 'text', 'label' => $this->t('Amount on a main page')),
				'commentInView' => array('type' => 'text', 'label' => m('picture')->t('Amount for {#post_ns} per page')),
				'commentLength' => array('type' => 'text', 'label' => $this->t('Comment length')),
				'wordsHeader' => '<h4>' . $this->t('Brand Wording') . '</h4>',
				$this->t('Here you can specify all possible variations of your branded word which will replace default "post".'),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Save'))
			),
			'model' => $this->model
		);

		$words = array(
			'post_n' => $this->t('"post" - noun'),
			'post_n_ucf' => $this->t('"Post" - noun'),
			'post_ns' => $this->t('"posts" - noun, plural'),
			'post_ns_ucf' => $this->t('"Posts" - noun, plural'),
			'post_v' => $this->t('"post" - verb'),
			'post_v_ucf' => $this->t('"Post" - verb'),
			'posted' => $this->t('"posted"'),
			'posted_ucf' => $this->t('"Posted"'),
			'repost' => $this->t('"repost"'),
			'reposts_ucf' => $this->t('"Reposts - noun, plural'),
			'repost_ucf' => $this->t('"Repost"'),
			'reposted' => $this->t('"reposted"'),
			'reposted_ucf' => $this->t('"Reposted"'),
			'post_button' => $this->t('"Post Button"'),
			'posting' => $this->t('"posting"'),
			'posting_ucf' => $this->t('"Posting"'),
		);

		$current = $this->param('words');

		foreach ($words as $key => $label) {
			$m = new UDummyModel;
			$m->attribute = isset($current[$key]) ? $current[$key] : '';
			$item = array(
				'type' => 'UForm',
				'elements' => array('attribute' => array('type' => 'text',
						'label' => $label,
						'attributes' => array('name' => get_class($this->model) . '[words][' . $key . ']'))),
				'model' => $m
			);
			$properties['elements']['words_' . $key] = $item;
		}
		return $properties;
	}

}