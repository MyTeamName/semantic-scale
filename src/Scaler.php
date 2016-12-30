<?php namespace jpuck\wordpress\plugins\SemanticScale;

class Scaler {
	protected $grade = 0;

	public function __construct(\WP_Post $post, WordSource $wordsource) {
		$words = $wordsource->fetch($post->post_date);
		$content = strtolower($post->post_content);

		$wordcount = 0;
		foreach ($words as $word) {
			foreach ($word as $alias) {
				if ( false !== strpos($content, $alias) ) {
					$wordcount++;
					continue;
				}
			}
		}

		$this->grade = (int)( ($wordcount/count($words)) * 100 );
	}

	public function grade() {
		return $this->grade;
	}

	public function __toString() {
		return (string) $this->grade();
	}
}