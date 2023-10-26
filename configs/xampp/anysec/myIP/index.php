

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PCAP</title>
</head>

<body>

<table align="center" bordercolor="" >

<td align="center" valign="top" bgcolor="#FFFFFF"><p><strong>
  </pre>
  </strong></p>
    <p>&nbsp;</p>
    <p><font color="#005AFF"><strong>ANYSec PCAP Example</strong></font></p>
	<div align="center"><img src="imagens/pcap.jpg" width="800" height="500" align="middle"></div>
    <p>&nbsp;</p>
	<div align="center"><img src="imagens/Nokia logo RGB_Black.png" width="150" height="30" align="middle"></div>
    <p>&nbsp;</p>
</td>

  
  
  <tr align="top">
    <td align="top"><h3><hr>
		<?php 
		### Client IP
		echo "Your IP address is:     <b>" . $_SERVER['REMOTE_ADDR']. "</b><br><br>";
		### Server IP
		echo "Server IP address is:   <b>" . $_SERVER['SERVER_ADDR'] . "</b><br>";
		?> 
	</h3></td align="top">
	<td align="top"><h3><hr>
		<?php 
		### Client Port
		echo "Your Port is:     <b>" . $_SERVER['REMOTE_PORT']. "</b><br><br>";
		echo "Server Port is:   <b>" . $_SERVER['SERVER_PORT'] . "</b><br>";
		?> 
	</h3></td align="top">
  </tr>
  
</table>
</body>
</html>


