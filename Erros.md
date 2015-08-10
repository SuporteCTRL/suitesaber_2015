Veja abaixo como solucionar alguns erros que podem ocorrer durante a operação da Suíte Saber e/ou do ABCD.

# ABCD #

## Eliminação do excesso de SPAN ##

O SPAN provoca mal funcionamento do CSS e pode ser encontrado em determinados arquivos do ABCD.

Exemplo de como a linha é apresentada:

```
<span><strong>".$msgstr["cancel"]."</strong></span>
```

## Solução ##

Acesse a pasta:

|  .../central/dbadmin/ |
|:----------------------|

remova o SPAN dos seguintes arquivos:

| **Arquivo** | **Linha** |
|:------------|:----------|
| fdt.php     | 1252      |
| fdt\_short\_a.php | 1388      |
| fixed\_marc.php | 67        |
| fst.php     | 195       |
| fmt.php     | 337       |
| iah\_edit\_db.php | 1488 - 1498 |
| pft.php     | 1190      |
| typeofrecs.php | 78        |
| advancedsearch.php | 195       |
| databases\_list.php | 104       |
| editpar.php | 74        |
| help\_ed.php | 221       |
| crearbd\_ex\_copy.php | 340       |
| menu\_creardb.php |175        |
| menu\_mantenimiento.php | 103       |
| typeofrecs\_marc\_edit.php | 219       |

Acesse também a pasta:

| .../central/statistics/ |
|:------------------------|

remova o SPAN dos seguintes arquivos:

| **Arquivo** | **Linha** |
|:------------|:----------|
| config\_vars.php | 424 - 430 |
| tables\_cfg.php | 451 - 460 |

## Logo da instituição ##

Até a versão 1.2b1 do ABCD, o logotipo possui chamadas diferentes. Caso você troque o logotipo no arquivo **config.php** e ele não seja alterado em todas as telas, faça o procedimento abaixo.

## Solução ##

Acesse o arquivo:

| ...\htdocs\central\config.php |
|:------------------------------|

adicione:

```
$institution_logo="/ABCD/www/htdocs/central/images/tools.png";
```

Acesse os arquivos:

| ...\htdocs\index.php |
|:---------------------|
| ...\htdocs\central\dataentry\menubases.php |
| ...\htdocs\central\common\institutional\_info.php |


altere a linha do logo da instituição para:

```
<img src="<?php $institution_logo?>" alt="Logo do <?php echo $institution_name?>" align="left" />
```

## Alterar título das janelas ##

É possível inserir o nome da instituição desejada como título de cada janela. Para definir o nome de cada tela, siga as instruções abaixo:

**Tela inicial (exibida antes do login)**

Acesse o arquivo:

| ...\htdocs\index.php |
|:---------------------|

insira a tag:

```
<title><?php echo $institution_name?></title>
```

**Tela inicial (exibida após o login)**

Acesse o arquivo:

| ...\htdocs\central\common\header.php |
|:-------------------------------------|

insira a tag:

```
<title><?php echo $institution_name?></title>			
```

**Catalogação**

Acesse o arquivo:

| ...\htdocs\central\dataentry\inicio\_main.php |
|:----------------------------------------------|

insira a tag:

```
echo "<HTML><title>$institution_name</title>
```

Para informar as definições da nova janela (quando escolhida esta opção no login) e alterar logo do cabeçalho, acesse o arquivo:

| ...\htdocs\index.php |
|:---------------------|

altere para:

```
<img src="<?php echo $institution_logo?>" alt="Logo do <?php echo $institution_name?>" align="left" />
```

Logo após, acesse o arquivo:

| ...\htdocs\central\common\institutional\_info.php |
|:--------------------------------------------------|

altere para:

```
<img src="<?php echo $institution_logo?>" alt="Logo do <?php echo $institution_name?>" align="left" />
```

## Favicon ##

Para adiconar um favicon, acesse o arquivo:

| ...\htdocs\index.php |
|:---------------------|

adicione:

```
<link rel="shortcut icon" href="central/images/favicon.ico" />
```

No arquivo:

| ...\htdocs\central\common\header.php |
|:-------------------------------------|

adicione:

```
<link rel="shortcut icon" href="../images/favicon.ico" />
```

## Organizar breadcrumb ##

Para realizar esta ação, é necessário acessar os arquivos abaixo:

| ...\htdocs\central\dbadmin\trad\_ayudas\_dataentry.php |
|:-------------------------------------------------------|
| ...\htdocs\central\dbadmin\translate.php               |
| ...\htdocs\central\dbadmin\translate\_update.php       |
| ...\htdocs\central\dbadmin\trad\_ayudas\_dataentry.php |
| ...\htdocs\central\dbadmin\trad\_ayudas\_statistics.php |
| ...\htdocs\central\dbadmin\trad\_ayudas\_adm.php       |
| ...\htdocs\central\dbadmin\advancedsearch\_update.php  |
| ...\htdocs\central\dbadmin\pft\_update.php             |
| ...\htdocs\central\dbadmin\actualizararchivotxt.php    |

alterar o seguinte trecho:

```
echo " <body>
				<div class=\"sectionInfo\">
						<div class=\"breadcrumb\">"."<h5>".
							$msgstr["tradyudas"]."</h5>
						</div>
						<div class=\"actions\">

				";
```

para:

```
				echo "
					<div class=\"sectionInfo\">
					<div class=\"breadcrumb\">".
					$msgstr["tradyudas"]."
					</div>
					<div class=\"actions\">\n";
```


## Mudar a cor da exibição "Script:" ##

A cor branca foi fixada em todas as páginas que exibem o script que está sendo usado. No caso de customizações do tema, é preciso remover a chamada **color=white** de todos os arquivos **.php**.

## Solução ##

Localize, em cada um dos arquivos listados abaixo, o comando:

```
<font color=white>
```

Exemplo: Script: databases\_list.php. Localizar: `<font color=white>`

```
echo "<font color=white>    Script: inicio_base.php" ?>
					</font>
```

remova a chamada <font> da linha:<br>
<br>
<pre><code>				    echo "    Script: inicio_base.php" ?&gt;<br>
			Original (com algumas variações de localização do &lt;/font&gt;:<br>
					echo "&lt;font color=white&gt;    Script: inicio_base.php" ?&gt;<br>
					&lt;/font&gt;<br>
</code></pre>

Lista de arquivos que possuem a tag:<br>
<br>
<ul><li>...\htdocs\central\config.php</li></ul>

<ul><li>...\htdocs\central\dataentry\inicio_base.php<br>
</li><li>...\htdocs\central\dataentry\alfa.php<br>
</li><li>...\htdocs\central\dataentry\administrar.php<br>
</li><li>...\htdocs\central\dataentry\administrar_ex.php</li></ul>

<ul><li>...\htdocs\central\statistics\tables_generate_ex.php<br>
</li><li>...\htdocs\central\statistics\config_vars.php<br>
</li><li>...\htdocs\central\statistics\config_vars_update.php<br>
</li><li>...\htdocs\central\statistics\tables_cfg.php<br>
</li><li>...\htdocs\central\statistics\tables_cfg_update.php</li></ul>

<ul><li>...\htdocs\central\dbadmin\copies_linkdb.php<br>
</li><li>...\htdocs\central\dbadmin\pft.php<br>
</li><li>...\htdocs\central\dbadmin\pft_delete.php<br>
</li><li>...\htdocs\central\dbadmin\assign_control_number.php<br>
</li><li>...\htdocs\central\dbadmin\advancedsearch.php<br>
</li><li>...\htdocs\central\dbadmin\advancedsearch_update.php<br>
</li><li>...\htdocs\central\dbadmin\fdt_short_a.php<br>
</li><li>...\htdocs\central\dbadmin\fdt.php<br>
</li><li>...\htdocs\central\dbadmin\editpar.php<br>
</li><li>...\htdocs\central\dbadmin\dirtree.php<br>
</li><li>...\htdocs\central\dbadmin\delete_file.php<br>
</li><li>...\htdocs\central\dbadmin\databases_list.php<br>
</li><li>...\htdocs\central\dbadmin\crearbd_new_create.php<br>
</li><li>...\htdocs\central\dbadmin\crearbd_ex_copy.php<br>
</li><li>...\htdocs\central\dbadmin\fst_update.php<br>
</li><li>...\htdocs\central\dbadmin\fst.php<br>
</li><li>...\htdocs\central\dbadmin\fmt_update.php<br>
</li><li>...\htdocs\central\dbadmin\delete_file.php<br>
</li><li>...\htdocs\central\dbadmin\fmt.php<br>
</li><li>...\htdocs\central\dbadmin\fixed_marc.php<br>
</li><li>...\htdocs\central\dbadmin\z3950_diacritics_update.php<br>
</li><li>...\htdocs\central\dbadmin\z3950_diacritics_edit.php<br>
</li><li>...\htdocs\central\dbadmin\z3950_conversion.php<br>
</li><li>...\htdocs\central\dbadmin\z3950_conf.php<br>
</li><li>...\htdocs\central\dbadmin\winisis_upload_pft.php<br>
</li><li>...\htdocs\central\dbadmin\winisis_upload_fst.php<br>
</li><li>...\htdocs\central\dbadmin\winisis_upload_fdt.php<br>
</li><li>...\htdocs\central\dbadmin\winisis.php<br>
</li><li>...\htdocs\central\dbadmin\users_adm.php<br>
</li><li>...\htdocs\central\dbadmin\typeofrecs_marc_edit.php<br>
</li><li>...\htdocs\central\dbadmin\typeofrecs_edit.php<br>
</li><li>...\htdocs\central\dbadmin\typeofrecs.php<br>
</li><li>...\htdocs\central\dbadmin\trad_ayudas_utils.php<br>
</li><li>...\htdocs\central\dbadmin\trad_ayudas_estadisticas.php<br>
</li><li>...\htdocs\central\dbadmin\trad_ayudas_adm.php<br>
</li><li>...\htdocs\central\dbadmin\trad_ayudas_dataentry.php<br>
</li><li>...\htdocs\central\dbadmin\trad_ayudas_adm.php<br>
</li><li>...\htdocs\central\dbadmin\sortkey_update.php<br>
</li><li>...\htdocs\central\dbadmin\sortkey_edit.php<br>
</li><li>...\htdocs\central\dbadmin\help_ed.php<br>
</li><li>...\htdocs\central\dbadmin\resetautoinc_update.php<br>
</li><li>...\htdocs\central\dbadmin\resetautoinc.php<br>
</li><li>...\htdocs\central\dbadmin\reset_control_number.php<br>
</li><li>...\htdocs\central\dbadmin\recval.php<br>
</li><li>...\htdocs\central\dbadmin\profile_edit.php<br>
</li><li>...\htdocs\central\dbadmin\picklist_save.php<br>
</li><li>...\htdocs\central\dbadmin\picklist_edit.php<br>
</li><li>...\htdocs\central\dbadmin\picklist.php<br>
</li><li>...\htdocs\central\dbadmin\menu_traducir.php<br>
</li><li>...\htdocs\central\dbadmin\menu_modificardb.php<br>
</li><li>...\htdocs\central\dbadmin\menu_traducir.php<br>
</li><li>...\htdocs\central\dbadmin\menu_mantenimiento.php<br>
</li><li>...\htdocs\central\dbadmin\iah_save.php<br>
</li><li>...\htdocs\central\dbadmin\profile_save.php</li></ul>

<ul><li>...\htdocs\central\common\homepage.php</li></ul>

<ul><li>...\htdocs\central\acquisitions\decision_ex.php<br>
</li><li>...\htdocs\central\acquisitions\decision.php<br>
</li><li>...\htdocs\central\acquisitions\copies_create<br>
</li><li>...\htdocs\central\acquisitions\close_order.php<br>
</li><li>...\htdocs\central\acquisitions\bidding_ex.php<br>
</li><li>...\htdocs\central\acquisitions\bidding.php<br>
</li><li>...\htdocs\central\acquisitions\suggestions_status_ex.php<br>
</li><li>...\htdocs\central\acquisitions\suggestions_status.php<br>
</li><li>...\htdocs\central\acquisitions\suggestions_search.php<br>
</li><li>...\htdocs\central\acquisitions\suggestions_new_update.php<br>
</li><li>...\htdocs\central\acquisitions\suggestions_new.php<br>
</li><li>...\htdocs\central\acquisitions\resetautoinc.php<br>
</li><li>...\htdocs\central\acquisitions\receive_order_update.php<br>
</li><li>...\htdocs\central\acquisitions\receive_order_ex.php<br>
</li><li>...\htdocs\central\acquisitions\receive_order.php<br>
</li><li>...\htdocs\central\acquisitions\pending_order_ex.php<br>
</li><li>...\htdocs\central\acquisitions\pending_order.php<br>
</li><li>...\htdocs\central\acquisitions\order_update.php<br>
</li><li>...\htdocs\central\acquisitions\order_new_update.php<br>
</li><li>...\htdocs\central\acquisitions\order_new.php<br>
</li><li>...\htdocs\central\acquisitions\order_ex.php<br>
</li><li>...\htdocs\central\acquisitions\order.php<br>
</li><li>...\htdocs\central\acquisitions\object_create.php</li></ul>

<ul><li>...\htdocs\central\circulation\typeofusers_update.php<br>
</li><li>...\htdocs\central\circulation\typeofusers.php<br>
</li><li>...\htdocs\central\circulation\typeofloans.php<br>
</li><li>...\htdocs\central\circulation\typeofitems_update.php<br>
</li><li>...\htdocs\central\circulation\typeofitems.php<br>
</li><li>...\htdocs\central\circulation\situacion_de_un_objeto_ex.php<br>
</li><li>...\htdocs\central\circulation\situacion_de_un_objeto.php<br>
</li><li>...\htdocs\central\circulation\sanctions_ex.php<br>
</li><li>...\htdocs\central\circulation\sanctions.php<br>
</li><li>...\htdocs\central\circulation\reservas_eliminar_ex.php<br>
</li><li>...\htdocs\central\circulation\reports_menu_recsel.php<br>
</li><li>...\htdocs\central\circulation\reports_menu.php<br>
</li><li>...\htdocs\central\circulation\renovar.php<br>
</li><li>...\htdocs\central\circulation\prestar_procesar.php<br>
</li><li>...\htdocs\central\circulation\prestar.php<br>
</li><li>...\htdocs\central\circulation\prestamo_disponibilidad.php<br>
</li><li>...\htdocs\central\circulation\menu_statistics.php<br>
</li><li>...\htdocs\central\circulation\locales.php<br>
</li><li>...\htdocs\central\circulation\loanobjects.php<br>
</li><li>...\htdocs\central\circulation\loan_return_reserve.php<br>
</li><li>...\htdocs\central\circulation\item_history_ex.php<br>
</li><li>...\htdocs\central\circulation\item_history.php<br>
</li><li>...\htdocs\central\circulation\estado_de_cuenta.php<br>
</li><li>...\htdocs\central\circulation\devolver.php<br>
</li><li>...\htdocs\central\circulation\databases_configure.php<br>
</li><li>...\htdocs\central\circulation\databases.php<br>
</li><li>...\htdocs\central\circulation\configure_menu.php<br>
</li><li>...\htdocs\central\circulation\calendario.php<br>
</li><li>...\htdocs\central\circulation\borrowers_configure.php<br>
</li><li>...\htdocs\central\circulation\borrower_history_ex.php<br>
</li><li>...\htdocs\central\circulation\borrower_history.php<br>
</li><li>...\htdocs\central\circulation\usuario_prestamos_reservar.php<br>
</li><li>...\htdocs\central\circulation\usuarios_prestamos_presentar.php<br>
</li><li>...\htdocs\central\circulation\usuario_prestamo_presentar.php<br>
</li><li>...\htdocs\central\circulation\usuario_prestamos_presentar.php</li></ul>

<h2>Erro de digitação</h2>

Um erro de digitação foi detectado no código e deve ser corrigido para não comprometer o funcionamento do software. Busque, nos arquivos listados, as respectivas linhas:<br>
<br>
<table><thead><th> ...\htdocs\central\dbadmin\fmt.php </th><th> linha 137 </th></thead><tbody>
<tr><td> ...\htdocs\central\common\homepage.php </td><td> Linha 62 (v 1.0.3) ou 48 (v 1.0.6) </td></tr>
<tr><td> ...\htdocs\central\dataentry\administrar.php </td><td> Linha 19  </td></tr>
<tr><td> ...\htdocs\central\dataentry\inicio_main.php </td><td> Linha 117 </td></tr></tbody></table>

substitua a tag:<br>
<br>
<pre><code>&lt;script languaje=javascript&gt;<br>
</code></pre>

por:<br>
<br>
<pre><code>&lt;script language=javascript&gt;<br>
</code></pre>



<h2>Índice do empréstimo</h2>

Ao clicar em uma das letras do índice utilizado para realizar a busca pelo número de registro do item e número do usuário, a janela de empréstimo (<b>prestar.php</b>) é fechada.<br>
<br>
<h2>Solução</h2>

Acesse o seguinte arquivo:<br>
<br>
<table><thead><th> ...\central\circulation\capturaclaves.php </th></thead><tbody></tbody></table>

Logo após, busque pela linha e delete o comando <b>;self.close()</b>.<br>
<br>
<pre><code>&lt;td  bgcolor=#cccccc align=center&gt;&lt;font size=1 face="arial"&gt;&lt;? for ($i=65;$i&lt;91;$i++ ) echo "&lt;a href=javascript:AbrirIndice('".chr($i)."');self.close()&gt;".chr($i)."&lt;/a&gt;  "?&gt;&lt;/td&gt;<br>
</code></pre>

<h2>Erro ao informar números de registros</h2>

Ao colocar um número de usuário inexistente, é possível que seja exibida uma mensagem contendo esta informação (borrower statement - estado_de_cuenta.php).<br>
<br>
Também ao colocar um número de registro de item que não está emprestado, uma tela em branco com a mensagem "unautorized user" surgirá.<br>
<br>
<h2>Solução</h2>

Busque as linhas 160-166 do arquivo:<br>
<br>
<table><thead><th> ...\central\circulation\loan_return_reserve.php </th></thead><tbody></tbody></table>

substitua o trecho <b>El número de inventario no está prestado</b> por <b>".$msgstr["inventory"]." ".$msgstr["noloan"]."</b>, conforme é mostrado abaixo:<br>
<br>
<pre><code> if (isset($arrHttp["error"]) and $arrHttp["inventory"]!=""){<br>
       echo "<br>
       &lt;script&gt;<br>
       alert('".$arrHttp["inventory"].": El número de inventario no está prestado')<br>
       &lt;/script&gt;<br>
       ";<br>
}<br>
</code></pre>

para:<br>
<br>
<pre><code>if (isset($arrHttp["error"]) and $arrHttp["inventory"]!=""){<br>
        echo "<br>
        &lt;script&gt;<br>
        alert('".$arrHttp["inventory"].": ".$msgstr["inventory"]." ".$msgstr["noloan"]."')<br>
        &lt;/script&gt;<br>
        ";<br>
}<br>
</code></pre>

<h2>Link para histórico do usuário</h2>

Dentro de cada submenu integrante da aba de Transações, é possível visualizar os links para alternar entre cada função de transação. Estes links não, porém, não estão disponíveis no submenu de Histórico do Leitor.<br>
<br>
<h2>Solução</h2>

Vá até o arquivo:<br>
<br>
<table><thead><th> .../central/circulation/borrower_history.php </th></thead><tbody></tbody></table>

busque as tags abaixo:<br>
<br>
<pre><code>&lt;div class="actions"&gt;&lt;/div&gt;<br>
</code></pre>

entre elas, acrescente o seguinte código:<br>
<br>
<pre><code>&lt;?php include("submenu_prestamo.php");?&gt;<br>
</code></pre>

<hr />

<h1>Bases de dados</h1>

<h2>Importação de arquivos</h2>

Ao tentar realizar o upload de um arquivo, é possível que a seguinte mensagem seja exibida:<br>
<br>
<table><thead><th> Warning: Invalid argument supplied for foreach() in C:\abcd\www\htdocs\central\dataentry\upload.php on line 16 </th></thead><tbody></tbody></table>

<h2>Soluções</h2>

<ol><li>Aumentar o Timeout;<br>
</li><li>Aumentar o tamanho permitido para o envio de arquivos.</li></ol>

Para aumentar o tamanho máximo permitido para o envio de arquivos, acesse o <b>php.ini</b> do servidor, conforme é mostrado abaixo.<br>
<br>
<pre><code>; Whether to allow HTTP file uploads.<br>
file_uploads = On<br>
<br>
; Temporary directory for HTTP uploaded files (will use system default if not<br>
; specified).<br>
;upload_tmp_dir =<br>
<br>
; Maximum allowed size for uploaded files.<br>
upload_max_filesize = 2M<br>
</code></pre>

O servidor, por padrão, é configurado para carregar arquivos inferiores ou iguais a 2MB. Portanto, para carregar um arquivo maior, altere este valor.<br>
<br>
<hr />

<h1>Empréstimo</h1>

<h2>Transações</h2>

No Módulo de Empréstimo, na opção Transações, que se encontra na aba Base de Dados, a seta do botão <b>« Last</b> está errada.<br>
<br>
<h2>Solução</h2>

Busque as linhas 365 [v. 1.0.3] ou 393 [v. 1.0.5] do arquivo:<br>
<br>
<table><thead><th> ...\central\dataentry\browse.php alterar: </th></thead><tbody></tbody></table>

Logo após, substitua a seta em:<br>
<br>
<pre><code>« &lt;?php echo $msgstr["last"]?&gt;<br>
</code></pre>

por:<br>
<br>
<pre><code>» &lt;?php echo $msgstr["last"]?&gt;<br>
</code></pre>

Caso não seja possível visualizar a seta, mas sim sua linguagem CSS, substitua:<br>
<br>
<pre><code>&amp;#171; &lt;?php echo $msgstr["last"]?&gt;<br>
</code></pre>

por:<br>
<br>
<pre><code>&amp;#187; &lt;?php echo $msgstr["last"]?&gt;<br>
</code></pre>

<hr />

<h1>OPAC</h1>

<h2>Formatação da referência (conforme ABNT)</h2>

Para realizar a formatação de referências conforme a ABNT, altere ou crie, caso não exista, o arquivo ...\www\bases\<a href='base.md'>base</a>\pfts\<a href='lang.md'>lang</a>\cite.pft e copie para o arquivo o código abaixo:<br>
<br>
<pre><code>'Referência conforme ABNT NBR 6023:2002.'<br>
'&lt;br /&gt;&lt;br /&gt;'<br>
mdl,v100^a,v110^a,v111^a,v130^a,<br>
if p(v222^b) then<br>
	mhl,v222^a," : "v222^b,<br>
else<br>
	mdl,v222^a,<br>
fi,<br>
if p(v245^b) then<br>
	mhl,'&lt;strong&gt;'v245^a'&lt;/strong&gt;',if p(v245^h) then mhl else mdl fi," : "v245^b,<br>
else<br>
	if p(v245^h) then mhl else mdl fi,'&lt;strong&gt;'v245^a'&lt;/strong&gt;',<br>
fi,<br>
" ["v245^h"]. ",<br>
mdl,v250^a, <br>
mhl,v260^a" : ",v260^b", ",mdl, v260^c,<br>
v300^a,<br>
mhl,if p(v440) then '(',(v440^a,|, n.|v440^n,|, |v440^v, if occ &lt; nocc(v440) then '; ' fi,) ')'/ fi,<br>
/#,<br>
</code></pre>

<h2>Definir a última base de dados como padrão</h2>

Para manter a última base de dados selecionada por padrão na lista suspensa do painel principal, vá até o arquivo:<br>
<br>
<table><thead><th> ...\www\htdocs\central\common\homepage.php </th></thead><tbody></tbody></table>

insira a expressão <b>selected</b> na linha 267:<br>
<br>
<pre><code>	    echo "&lt;option selected value=\"^a$key^badm|$value\" $xselected&gt;".$t[0]."\n";<br>
</code></pre>

<h2>Definir a primeira base de dados como padrão</h2>

Para manter a primeira base de dados selecionada por padrão na lista suspensa do painel principal, vá até o arquivo:<br>
<br>
<table><thead><th> ...\www\htdocs\central\common\homepage.php </th></thead><tbody></tbody></table>

O termo <b>selected</b>, mencionado anteriormente, não deverá ser utilizado. Ao invés disso, altere <b>ix<1</b> para <b>ix<-1</b> na linha 97, conforme é mostrado abaixo:<br>
<br>
<pre><code>    function CambiarBaseAdministrador(Modulo){<br>
		if (Modulo!="traducir"){<br>
			ix=document.admin.base.selectedIndex<br>
		    if (ix&lt;-1){<br>
				alert("&lt;?php echo $msgstr["seldb"]?&gt;")<br>
				return<br>
		    }<br>
		}<br>
</code></pre>

<h2>Melhorar a aparência da barra de ferramentas de catalogação</h2>

Para alterar as configurações relacionadas à aparência da barra de ferramentas do menu de catalogação, busque o arquivo:<br>
<br>
<table><thead><th> ...\www\htdocs\central\dataentry\js\dhtmlXToolbar.css </th></thead><tbody></tbody></table>

adicione:<br>
<br>
<pre><code>width:25px;<br>
</code></pre>

em:<br>
<br>
<pre><code>.defaultbutton<br>
.defaultbuttondown<br>
.defaultbuttonover<br>
</code></pre>