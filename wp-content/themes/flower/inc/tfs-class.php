<?php

class TfsClass{

	public static function substrword($text, $length = 100, $replacer = '...', $isStrips = true, $stringtags = '') {
		if($isStrips){
			$text = preg_replace('/\<p.*\>/Us','',$text);
			$text = str_replace('</p>','<br/>',$text);
			$text = strip_tags($text, $stringtags);
		}
		$tmp = explode(" ", $text);

		if (count($tmp) < $length)
			return $text;

		$text = implode(" ", array_slice($tmp, 0, $length)) . $replacer;

		return $text;
	}	
}
	
?>