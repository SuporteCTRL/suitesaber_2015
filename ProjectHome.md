<h1>Visão Geral</h1>

> O software ABCD (Automação de Bibliotecas e Centros de Documentação) é uma aplicação Web, código aberto (software livre) e multilíngue de gestão de Bibliotecas e Arquivos, criado em 2008 e lançado em novembro de 2009 pela  <a href='http://.bireme.br'>BIREME</a> (Centro Latino-Americano e do Caribe de Informação em Ciência da Saúde). A BIREME, com o apoio da UNESCO, é a instituição responsável pela coordenação do desenvolvimento, manutenção e distribuição gratuita do sistema.

> Em 2010 a Control Informação e Documentação adotou o Sistema ABCD como uma alternativa de software viável para automação de acervos bibliográficos e arquivísticos. Desde então estamos oferecendo serviços de instalação, customização e treinamento, bem como realizando análises, testes e implementação de melhorias no ABCD.

> No primeiro semestre de 2012 lançaremos oficialmente uma variante do Sistema ABCD, que chamamos de [Suíte Saber](http://suitesaber.org). A Suíte Saber é um conjunto de soluções, composta pelos módulos de catalogação, pesquisa e circulação para o gerenciamento automatizado de Bibliotecas e Arquivos. Esta Suíte é desenvolvida em PHP utilizando HTML5, CSS3 JQuery e base CDS/Isis. Com o objetivo de oferecer praticidade na operação e uso, a [Suíte Saber](http://suitesaber.org) foi reprogramada com novas ferramentas, dentre as quais destacamos:

<ul>
<li>Layout novo e ergonômico;</li>
<li>Interface de pesquisa amigável;</li>
<li>Planilha de entrada de dados com formato MARC atualizado;</li>
<li>Emissão de etiquetas de códigos de barras;</li>
<li>Impressão de relatórios;</li>
<li>Impressão de recibos de empréstimo e devolução;</li>
<li>Acessível em multiplataforma (desktop, notebook, tablets e smartphones).</li>
<li>Foi substituído o BVS Site v.4.1 para versão BVS Site 5.3</li>
</ul>




&lt;hr&gt;


<h1>Módulos</h1>
A Suíte Saber possui um agrupamento de soluções que formam os seguintes módulos:
<ul>
<li>Controle de aquisição</li>
<li>Catalogação</li>
<li>Empréstimo</li>
<li>Site da instituição/pesquisa</li>
</ul>

<h1>Dados técnicos</h1>
O aplicativo utiliza a estrutura de banco de dados <a href='http://oraculo.inf.br/index.php?title=CDS/ISIS'>CDS/ISIS</a> desenvolvida pela UNESCO. O CDS/ISIS é um banco de dados textual que trabalha nativamente com formatos bibliográficos que fazem uso de campos e subcampos.

É possível fazer importação de registros com a utilização do protocolo Z3950 e do ISO2709.

O sistema exporta relatórios em Word, Excel, TXT e HTML.

<h2>Tecnologia</h2>

O Suíte saber necessita de um servidor Apache 2.x e PHP5.x

Extensões essenciais PHP:
<ul>
<li>php5-curl</li>
<li>php5-gd</li>
<li>php5-gmp</li>
<li>php5-mcrypt</li>
<li>php5-tidy</li>
<li>php5-xsl</li>
<li>yaz</li>
</ul>


<h1>Links</h1>
<li><a href='https://docs.google.com/document/pub?id=1QrRvqc8g6uE0NNVLv2xTAP4HWE7PojeXYSA12Xh9vmw'>Esqueleto básico em HTML do Suíte Saber</a></li>
<li><a href='https://docs.google.com/spreadsheet/pub?key=0AkPvjw8N5ATwdE5vZkxNVjJXODN0OGhtbG1yU2g3OXc&single=true&gid=0&output=html'>Relação de campos automáticos</a></li>
<li><a href='https://docs.google.com/document/pub?id=1FPdC-NHesRPfZm_7Z5G1ZFKuuzbRnVJ_LJxA0pEiNZ0'>Ligação entre registros da mesma base de dados (comando REF) </a>

<h1>Download a partir do SVN</h1>
Baixe o Suíte Saber para o seu host utilizando o seguinte comando:<br>
<br>
<blockquote><pre>$svn checkout http://suitesaber.googlecode.com/svn/trunk/suitesaber</pre></blockquote>

O login/senha padrão é: saber/adm<br>
