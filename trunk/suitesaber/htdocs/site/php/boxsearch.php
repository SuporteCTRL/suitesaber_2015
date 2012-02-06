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
            <?= $site['title']?>
        </title>
        <? include($DirNameLocal."./head.php"); ?>
    </head>
    <body>
        <div class="secondColumn">
            <? include($localPath['html'] . "/metasearch.html"); ?>

        </div>
    </body>
</html>