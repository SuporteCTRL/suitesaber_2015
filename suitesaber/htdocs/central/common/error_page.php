<?php
session_start();
include("get_post.php");
include("header.php");
include("../lang/admin.php");

?>
<head>
<meta http-equiv="REFRESH" content="0;url=/">
</head>
<body>
<div class="middle form">
	<div class="formContent">
	<center>
<?php
echo "<h1>".$msgstr["sessionexpired"]."</h1>";
?>

</center>
</div>
</div>
<?php include("footer.php")?>
</body>
</html>
