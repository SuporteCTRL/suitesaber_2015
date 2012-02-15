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
        <div class="container">
            <?
            include($localPath['html'] . "/bvs.html");
            flush();
            ?>

            <div class="middle">
                <div class="firstColumn">
                    <?
                     foreach ($site["col1"] as $id=>$file){
                         $html = $localPath['html'] . $file . ".html";
                         include($html);
                     }
                     flush();
                    ?>
                </div>

                <div class="secondColumn">
                    <? include($localPath['html'] . "/metasearch.html"); ?>
                    <div class="centerLeftColumn">
                        <?
                         foreach ($site["col2"] as $id=>$file){
                            $html = $localPath['html'] . $file . ".html";
                             include($html);
                         }
                         flush();
                        ?>
                    </div>
                </div>
                <div class="thirdColumn">
                    <?
                     foreach ($site["col3"] as $id=>$file){
                         $html = $localPath['html'] . $file . ".html";
                         include($html);
                     }
                     flush();
                    ?>
                </div>
                <div class="spacer"> </div>
            </div>
            <div class="bottom">
                <? include($localPath['html'] . "/responsable.html"); ?>
            </div>
        </div>
        <div class="copyright">
            <a href="http://bvsmodelo.bvsalud.org/php/level.php?lang=pt&component=27&item=10" target="_blank">&copy; BVS Site <?= VERSION ?> </a>
    <p>Recomendamos o uso do <a href="http://br.mozdev.org/download/" target="_blank" title="Firefox" alt="Firefox"><img src="/central/css/saber/images/firefox.png" border="0" alt="Firefox." /></a></p>
        </div>
        <? include($DirNameLocal. "./foot.php");  ?>
    </body>
</html>