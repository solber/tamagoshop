<?php
	function str_random($length)
	{
		$alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}
?>