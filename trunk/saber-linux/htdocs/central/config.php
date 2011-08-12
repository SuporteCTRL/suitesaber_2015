<?
//Caminho físico no servidor
$localserver = "/var/www/suitesaber/saber-linux";

//Nome do arquivo CSS principal do tema
$theme ="saber";

//Nome do Arquivo de Logotipo
$imglogo ="logoabcd.png";

// Open the Central module in a new window for avoiding the use of the browse buttons
$open_new_window="N";
$context_menu="Y";

//Caminho do arquivo logotipo
$logo ="/css/$theme/images/$imglogo";

//Tamanho do logotipo em Largura
$sizelogo="164";

//USED FOR ALL THE DATE FUNCTIONS. DD=DAYS, MM=MONTH, AA=YEAR. USE / AS SEPARATOR
$config_date_format="DD/MM/YY";

//Folder with the administration modulo
$app_path="central";

//Path to the databases
$db_path="$localserver/bases/";

//Path to the folder where the uploaded images are to be stored (the database name will be added to this path)
$img_path="$localserver/htdocs/bases/";

//Path to the wwwisis executable (include the name of the program)
//$Wxis="$localserver/cgi-bin/wxis.exe";
$Wxis="$localserver/cgi-bin/wxis.exe";

//Path to the wxis scripts
$xWxis="$localserver/htdocs/$app_path/dataentry/wxis/";

//default language
$lang="pt";

//Default langue for the databases definition
$lang_db="pt";

// use este lenguaje para seguir desplegando los registros con un código de página específico aunque cambie el lenguaje de diálogo
//$display_lang="";

//Url for the execution of WXis, when using GGI in place of exec
$wxisUrl="";

//$wxisUrl="http://localhost:9090/cgi-bin/wxis.exe";

//Name of the institution
$institution_name="Saber ABCD";

//Ruta hacia el archivo con la configuración del FCKeditor
$FCKConfigurationsPath="/".$app_path."/dataentry/fckconfig.js";

//Ruta hacia el FCKEditor
$FCKEditorPath="/site/bvs-mod/FCKeditor/";

//USE THIS LOGIN AND PASSWORD IN CASE OF CORRUPTION OF THE OPERATORS DATABASE OR IF YOU DELETED, BY ERROR, THE SYSTEM ADMINISTRATOR
$adm_login="";
$adm_password="";

//Ruta hacia el archivo con la configuración del FCKeditor
$FCKConfigurationsPath="/$app_path/dataentry/fckconfig.js";

//USE THIS PARAMETER TO SHOW THE ICON THAT ALLOWS THE BASES FOLDER EXPLORATION   (0=don't show, 1=show)
$dirtree=0;


//USE THIS PARAMETER TO ENABLE/DISABLE THE MD5 PASSWORD ENCRIPTYON (0=OFF 1=ON)
$MD5=0;

$empwebservicequerylocation = "http://localhost:8086/ewengine/services/EmpwebQueryService";$empwebservicetranslocation = "http://localhost:8086/ewengine/services/EmpwebTransactionService";
$empwebserviceobjectsdb = "objetos";$empwebserviceusersdb = "*";
?>
