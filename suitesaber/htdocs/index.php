<?
session_start();
include("central/config.php");
include("$app_path/common/get_post.php");

if (isset($_SESSION["lang"])){

	$arrHttp["lang"]=$_SESSION["lang"];

}else{

	$arrHttp["lang"]=$lang;
	$_SESSION["lang"]=$lang;

}
include ("$app_path/lang/admin.php");
include ("$app_path/lang/lang.php");
include ("meta.php");
?>

<html lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR">
	<head>
	
	<?php include ("meta.php");?>
	
		<!--Permite o iframe que executa o BVS-Site tenha uma altura de acordo com a página-->

		<script type="text/javascript">

		function iframeAutoHeight(quem){

		if(navigator.appName.indexOf("Internet Explorer")>-1){ //ie sucks
   
		var func_temp = function(){
            var val_temp = quem.contentWindow.document.body.scrollHeight + 15
            quem.style.height = val_temp + "px";
        }

        setTimeout(function() { func_temp() },100) //ie sucks
		}else{
        var val = quem.contentWindow.document.body.parentNode.offsetHeight + 15
        quem.style.height= val + "px";
		}    
		}
		</script>

<script src=<? echo $app_path?>/dataentry/js/lr_trim.js></script>

<script languaje=javascript>

document.onkeypress =

	function (evt) {

			var c = document.layers ? evt.which

	       		: document.all ? event.keyCode

	       		: evt.keyCode;

			if (c==13) Enviar()

			return true;
	}

function UsuarioNoAutorizado(){

	alert("<?php echo $msgstr["menu_noau"]?>")
		return
}

function Enviar(){
	login=Trim(document.administra.login.value)
	password=Trim(document.administra.password.value)
	if (login=="" || password==""){
		alert("<?php echo $msgstr["datosidentificacion"]?>")
		return

		}else{

		if (document.administra.newindow.checked){
			document.administra.target="new_window";
			ancho=screen.availWidth-15
			alto=(screen.availHeight||screen.height) -50
			msgwin=window.open("","new_window","menubar=no, toolbar=no, location=no, scrollbars=yes, status=yes, resizable=yes, top=0, left=0, width="+ancho+", height="+alto)
			msgwin.focus()
		} else{
			document.administra.target=""
		}

		document.administra.submit()

	}

}

</script>


<script src="jquery/javascripts/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
        $(document).ready(function() {

            $(".signin").click(function(e) {          
				e.preventDefault();
                $("fieldset#signin_menu").toggle();
				$(".signin").toggleClass("menu-open");
            });
			
			$("fieldset#signin_menu").mouseup(function() {
				return false
			});
			$(document).mouseup(function(e) {
				if($(e.target).parent("a.signin").length==0) {
					$(".signin").removeClass("menu-open");
					$("fieldset#signin_menu").hide();
				}
			});			
			
        });
</script>
<script src="jquery/javascripts/jquery.tipsy.js" type="text/javascript"></script>
<script type='text/javascript'>
    $(function() {
	  $('#forgot_username_link').tipsy({gravity: 'w'});   
    });
  </script>

  </head>


	
<body>

<div id="container">
	<div id="topnav" class="topnav"> <a href="login" class="signin">
	<span><img src="central/css/<? echo $theme  ?>/images/cadeado.png" /></span></a> </div>
	<input type=hidden name=Opcion value=admin>
	<input type=hidden name=cipar value=acces.par>
	<input type=hidden name=lang value=<?php echo $arrHttp["lang"]?>>

	<fieldset id="signin_menu">
	<form name=administra onsubmit="javascript:return false" method=post action=<?php echo $app_path?>/common/inicio.php>

<?php
if (isset($arrHttp["login"]) and $arrHttp["login"]=="N"){
		echo "
			<div class=\"helper alert\">".$msgstr["menu_noau"]."</div> ";
}
?>


			<label for="user"><?php echo $msgstr["userid"]?></label><br />
<?php
if (isset($arrHttp["login"]) and $arrHttp["login"]=="N"){
		echo "
			<input type=\"text\" name=\"login\" id=\"user\" value=\"\" class=\"inputAlert\"  />\n";
}else{
		echo "
			<input type=\"text\" name=\"login\" id=\"user\" value=\"\"  />\n";
}

?>
      </p>
    <p>
        <label for="password">Senha</label><br />
        <input type="password"  name="password" id="pwd" value="" onClick="this.value='';" />
      </p>
      
    		<div style="display:hidden;" class="formRow formRowFocus">
			<label ><?php echo $msgstr["lang"]?></label> <select name=lang class="textEntry singleTextEntry">
<?php

 	$a=$db_path."lang.tab";
 	if (file_exists($a)){
		$fp=file($a);
		$selected="";
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				$l=explode('=',$value);
				if ($l[0]!="lang"){
					if ($l[0]==$_SESSION["lang"]) $selected=" selected";
					echo "<option value=$l[0] $selected>".$msgstr[$l[0]]."</option>";
					$selected="";
				}
			}
		}
	}else{
		echo $msgstr["flang"].$db_path."lang/".$_SESSION["lang"]."/lang.tab";
		die;
	}
?>
			</select>
		</div>  
      
      
      
      <p class="remember">
      			<input type="hidden" name="newindow" value= 
<?php

if (isset($open_new_window) and $open_new_window=="Y")

	echo "Y checked";

else
	echo "N";
?> />

	<input type="submit" onclick="javascript:Enviar()" value="Conectar">
		
        <input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox">
        <label for="remember">Lembrar de mim</label>
      </p>
  <!-- <p class="forgot"> <a href="#" id="resend_password_link">Perdeu sua senha?</a> </p>
       <p class="forgot-username"> <a id=forgot_username_link title="If you remember your password, try logging in with your email" href="#">Perdeu seu login?</a> </p> -->
    </form>
  </fieldset>
</div>

<div id="todo">
<iframe  id='ha' src="/site"  onload='iframeAutoHeight(this)' frameborder='0' width="100%" scrolling="auto"></iframe>
</div>
</body>
</html>
