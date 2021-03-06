<?php namespace jpuck\wordpress\plugins\SemanticScale;

class Scaler {
	protected $grade = 0;

	public function __construct(\WP_Post $post, WordSource $wordsource, array $options = []) {
		$words = $wordsource->fetch($post);
		$content = strtolower($post->post_content);

		$wordcount = 0;
		foreach ($words as $word) {
			foreach ($word as $alias) {
				if ( false !== strpos($content, strtolower($alias)) ) {
					$wordcount++;
					continue 2;
				}
				if ( !empty($options['echo-missed']) && !next($word) ) {
					echo $alias.PHP_EOL;
				}
			}
		}

		$this->grade = (int)round( ($wordcount/count($words)) * 100 );
	}

	public function grade() {
		return $this->grade;
	}

	public function __toString() {
		return (string) $this->grade();
	}
}
