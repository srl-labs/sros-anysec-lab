

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AnysecDemo</title>
</head>

<body>

<center><h1>ANYSec Demo</h1></center>

<table align="center" bordercolor="" >
   <tr>
    <td>
	</td>
   </tr>
  
  <tr align="top">
    <td align="center"><h3><hr>


<center><h2>Test 1 - Enable and Disable ANYSec</h2></center>

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
  
    <form method="post"> 
        <input type="submit" name="button11"
                class="button" value="Disable ANYSec" /> 
          
        <input type="submit" name="button12"
                class="button" value="Enable ANYSec" /> 
    </form>
    <p>&nbsp;</p><p>&nbsp;</p>



	</h3></td>
	</tr>
	
	
	<tr align="top">
	<td align="center"><h3><hr>


<center><h2>Test 2 - Enable and Disable Link between R1 and R2 (Port 1/1/c1)</h1></center>

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
  
    <form method="post"> 
        <input type="submit" name="button21"
                class="button" value="Disable Top Link" /> 
          
        <input type="submit" name="button22"
                class="button" value="Enable Top Link" /> 
    </form>


    <p>&nbsp;</p><p>&nbsp;</p>
	

	</h3></td>
  </tr>
  
</table>
</body>
</html>


