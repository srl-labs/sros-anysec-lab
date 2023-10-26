<?php

include_once('classes/page/center.class.php');
include_once('classes/page/menuLeft.class.php');

?>



<!--Funções de display e fecho do Loader-->
<script>

var secondWindow = false;
var popupWindow=null;


function parent_disable() {
	if(!popupWindow.closed){
		popupWindow.focus();
		alert ("pop focus")
	}
}


//Open the Loader
function open_Loader() {

	if(secondWindow == false) { 
	//alert ("open_Loader")
	
	var leftVal = (screen.width-490) / 2;
	var topVal = (screen.height-20) / 2;
	var cellLayer="id1";

		//if (navigator.appName=="Microsoft Internet Explorer"){
			var theWindow = 'width=490,height=20,left='+leftVal+',top='+topVal+',menubar=no,toolbar=no,location=no,personalbar=no,status=no,scrollbars=no,directories=no,resizable=no';
			popupWindow = window.open('','wind',theWindow);
			popupWindow.document.open();
			popupWindow.document.write('<html><head><script>window.onunload=function(){window.close();} <\/script><title>Please Wait.....Page is loading.</title></head><body bgColor=#FFFFFF><table align="center"><tr><td><strong>Loading Data..........Please Wait!</strong></td></tr></table></body></html>');
			//popupWindow=window.alert("Loading Data..........Please Wait!");
		//}
		secondWindow = true;
		//parent_disable();
	}
} 

//Close the Loader
function close_Loader(){
	
	if (secondWindow == true){
		//if (navigator.appName=="Microsoft Internet Explorer"){
			//if(!popupWindow.closed){
				//popupWindow = window.open('','wind',theWindow);
				popupWindow.close(); 
			//}
		//}
	}
	secondWindow = false;
}
</script>
<!-- Fim Funções de display e fecho do Loader-->



<!--Inicio do HTML-->
<html>


<head><title>SRX Demo Portal</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="hiperlink_style.css" rel="stylesheet" type="text/css">
<link href="css/main.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a {
	color: #000000;
}
-->
</style></head>
<body onLoad="relogio();" onUnload="close_Loader();">



<!-- Tabela  -->
<table width="80%" height="498" border="0" align="center">


<!-- Cabecalho -->
<tr>
    <td width="15%" height="90" >	
    <div align="center"><img src="imagens/Nokia logo RGB_Bright blue.png" width="150" height="30" align="left"></div>
	</td>

    <td width="69%" ><div align="center">
    <h1><font color="#005AFF">SRX Demo Portal</font></h1></div></td>
	
    <td width="15%" height="90" >	
    <div align="center"><img src="imagens/clab.png" width="150" height="120" align="middle"></div>
	</td>
	
</tr>
<!-- Fim Cabecalho --> 
 

<!-- Barra Hora/Data -->   

<tr>
    <td height="43" colspan="3" bgcolor="#005AFF" align="right"><div align="right">		
        <?php print ("<strong><font color='#FFFFFF'>".Date("F d, Y l")."</font></strong>"); ?>	
    </td> 
</tr>
<!-- FIM Barra Hora/Data --> 
<!-- Coluna da Esquerda -->
<td width="15%" height="347" valign="top" bgcolor="#FFFFFF">
<?php
	new menuLeft();
?>
</td>
<!-- Corpo --> 

<!-- Zona dinâmica-->
    <td width="69%" >
<?php
	new center();
?>	
</td>
<!-- FIM Zona dinâmica-->  
	  
<!-- Coluna da Direita -->   
<td width="16%" bgcolor="#FFFFFF" valign="top">
<?php

?>
	</td>
 </tr>
<!-- FIM Coluna da Esquerda - Links --> 

<!-- FIM Corpo --> 


<!-- Footer	 -->
<tr><td height="43" colspan="3" bgcolor="#CCCCCC" align="center"><div align="center">		

	<font color="#000000"><strong>..::
  	<a href="mailto:someone@nokia.com?subject=SRX Demo Portal" style="color:blue">Contacts</a> 
	::..</strong></font> 
	
</td></tr>

<tr align="left">
    <td width="15%" height="90" >	
    <div align="center"><img src="imagens/Nokia logo RGB_Bright blue.png" width="150" height="30" align="left"></div>
	</td>


    <td width="15%" height="90" >	
    <div align="center"><img src="imagens/github.png" width="150" height="120" align="left"></div>

    <div align="center"><img src="imagens/gnmic.png" width="150" height="120" align="left"></div>

    <div align="center"><img src="imagens/grafana.png" width="150" height="120" align="left"></div>

    <div align="center"><img src="imagens/prometheus.png" width="150" height="120" align="left"></div>
	</td>
	
	
    <td width="15%" height="90" >	
    <div align="center"><img src="imagens/clab.png" width="150" height="120" align="left"></div>
	</td>
	
</tr>

<!-- FIM Footer	 -->

</table></body>
</html>
