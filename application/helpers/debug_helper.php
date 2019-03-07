<?php
	
if(function_exists('dump') === false)
{
	function dump($data)
	{
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
	}
}