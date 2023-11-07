

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AnysecDemo</title>

<link href="css/main.css" rel="stylesheet" type="text/css">

</head>

<body>

<center><h1><font color="#005AFF">ANYSec Demo</font></h1></center>

<table align="center" bordercolor="" >
   <tr>
    <td>
	</td>
   </tr>
  
  <tr align="top">
    <td align="center"><h3><hr>


<center><h2><font color="#005AFF">Test 1 - Enable/Disable ANYSec</font></h2></center>



    <form method="post"> 
        <input type="submit" name="button11"
                class="button" value="Disable ANYSec" style="color:red;"/> 
          
        <input type="submit" name="button12"
                class="button" value="Enable ANYSec" style="color:green;"/> 
    </form>


    <?php
        if(array_key_exists('button11', $_POST)) { 
            button11(); 
			shell_exec('bash ./test2_disable_anysec_peer.gnmic');
			var_dump(http_response_code(200));
        } 
        else if(array_key_exists('button12', $_POST)) { 
            button12(); 
			shell_exec('bash ./test2_enable_anysec_peer.gnmic');
			var_dump(http_response_code(200));
        } 
        function button11() { 
            echo "Anysec has been disable          -   "; 
        } 
        function button12() { 
            echo "Anysec has been enabled          -   "; 
        } 
    ?> 

    <p>&nbsp;</p><p>&nbsp;</p>

<!-- Rounded switch 
<label class="switch">
  <input type="checkbox">
  <span class="slider round"></span>
</label> 
-->


	</h3></td>
	</tr>
	
	
	<tr align="top">
	<td align="center"><h3><hr>


<center><h2><font color="#005AFF">Test 2 - Enable/Disable Top Link</font></h1></center>


  
    <form method="post"> 
        <input type="submit" name="button21"
                class="button" value="Disable Top Link" style="color:red;"/> 
          
        <input type="submit" name="button22"
                class="button" value="Enable Top Link" style="color:green;"/> 
    </form>

    <?php
        if(array_key_exists('button21', $_POST)) { 
            button21(); 
			shell_exec('bash ./test1_disable_port.gnmic');
			var_dump(http_response_code(200));
        } 
        else if(array_key_exists('button22', $_POST)) { 
            button22(); 
			shell_exec('bash ./test1_enable_port.gnmic');
			var_dump(http_response_code(200));
        } 
        function button21() { 
            echo "Top link has been disabled          -   "; 
        } 
        function button22() { 
            echo "Top link has been enabled          -   "; 
        } 
    ?> 




    <p>&nbsp;</p><p>&nbsp;</p>
	

	</h3></td>
  </tr>
  
</table>
</body>
</html>


