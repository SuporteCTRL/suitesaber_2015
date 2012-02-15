<?php

        require_once (dirname(__FILE__)."/../config.php");
        $def = parse_ini_file($db_path."abcd.def");
        //print_r($def);
        ?>

		<div class="footer">

				<strong><?php echo $def["LEGEND1"]; ?> | versão <?php echo $def["VERSION"] ?></strong><br />
				<a href="<?php echo $def["URL2"]; ?>" target=_blank><span><?php echo $def["LEGEND2"]; ?></span></a> -
				<a href="<?php echo $institution_url; ?>" target=_blank><span><?php  echo $institution_name; ?></span></a><br />


		</div>
