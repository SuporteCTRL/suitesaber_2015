<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      sendto.php
 * @desc:      Send to
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *  
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *  
 * == END LICENSE ==
*/
if (isset($index)){?>
<strong><?php echo $msgstr["sendto"]?>:&nbsp; 
		<a id="botoes_top" href='javascript:SendTo("D")'><?php echo $msgstr["doc"]?></a>
		<a id="botoes_top" href='javascript:SendTo("W")'><?php echo $msgstr["xls"]?></a></strong>  &nbsp; | &nbsp;

<script>

function SendTo(SendTo){
	index="<?php echo $index?>"
	tit="<?php echo $tit?>"
	Expresion="<?php echo $Expresion?>"	base="<?php echo $arrHttp["base"]?>"
	sort="<?php echo $arrHttp["sort"]?>"
	msgwin=window.open("sendto_ex.php?base="+base+"&sort="+sort+"&Opcion="+SendTo+"&index="+index+"&tit="+tit+"&Expresion="+Expresion,"sendto")
	msgwin.focus()}
</script>
<?}?>

