<?php
echo "<pre>";
print_r($_REQUEST);exit;
$imgPath = $_REQUEST;
echo $imgPath;exit;
$imageData = base64_encode(file_get_contents($imgPath));
echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
?>