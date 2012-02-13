<?php
    $DirNameLocal=dirname(__FILE__).'/';
    include_once($DirNameLocal."./include.php");

    $site = parse_ini_file($localPath['ini'] . "bvs.ini", true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>

        </title>
        <? include($DirNameLocal."./head.php"); ?>
         <link rel="stylesheet" href="/iah/css/stylesheet.css" type="text/css" media="screen" />
    </head>
    <body class="heading">
        <div>


            <div class="searchwidget">


                <div class="searchwidget">
                    <? include($localPath['html'] . "/metasearch_blank.html"); ?>
                    <div class="centerLeftColumn">

                    </div>
                </div>


            </div>
   
        </div>
	

    </body>
</html>
