<?php
        require_once (dirname(__FILE__)."/../config.php");
        $def = parse_ini_file($db_path."abcd.def");
        //print_r($def);
?>
	<div class="footer">
				<strong><?php echo $def["LEGEND1"]; ?> | versão <?php echo $def["VERSION"] ?></strong><br />
				<a href="<?php echo $def["URL1"]; ?>" target=_blank><span><?php echo $def["LEGEND2"]; ?></span></a> -
				<a href="<?php echo $def["URL2"]; ?>" target=_blank><span><?php  echo $institution_name; ?></span></a><br />
		</div>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-13154500-5']);
  _gaq.push(['_setDomainName', 'suitesaber.org']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>