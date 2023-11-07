<?php

class center
{
	var $debug = true;
	
	function __construct()
	{
		if (isset($_GET["page"]))
		{
			switch ($_GET['page'])
			{
				case 1:
					include 'home.php';
					break;
				case 10:
					include 'myIP/index.php';
					break;
				case 20:
					include 'anysec/index.php';
					break;
				
				default:
				{
					include 'home.php';
				}
			}
		}
		else
			include 'home.php';
	}
	
}

?>
