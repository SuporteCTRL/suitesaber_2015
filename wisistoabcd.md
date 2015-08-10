**Bases genéricas**

1. No Sistema Operacional Windows: gerar arquivo formato ISO

```
mx dbn iso=dbnwinisis.iso -all now tell=1
```

2. Ainda no Windows: converter para ansi

```
mx iso=dbnwinisis.iso create=dbnabcd convert=ansi -all now tell=1
```

3. Windows: gerar ISO

```
mx dbnabcd iso=dbnabcd.iso -all now tell=1
```

4. Na Suíte Saber ABCD instalada em Linux: importar o ISO para a base de dados.


---


**Bases no Formato MARC (IsisMarc, por exemplo)**

1. No Winisis: alterar caractere | por - no 008:
Menu Utilitários->Substituir global no Winisis
  * MFN: de 1 até último
  * texto a encontrar: |
  * novo texto: -
  * tags: 8

2. Windows: converter 3xxx para 9xx

```
retag dbn conv1.tab
```

Sendo conv1.tab um arquivo de texto com os campos separados por espaço, na estrutura: _'tagatual' 'tagnova'_. Exemplo:
```
3004 904
3005 905
3006 906
3007 907
3008 908
3009 909
3017 917
3018 918
3019 919
```

3. Windows: gerar ISO
```
mx dbn iso=dbnwinisis.iso -all now tell=1
```

4. Windows: converter para ansi
```
mx iso=dbnwinisis.iso create=dbnabcd convert=ansi -all now tell=1
```

5. Windows: gerar ISO
```
mx dbnabcd iso=dbnabcd.iso -all now tell=1
```
6. Linux: importar o ISO na base

Colocar arquivo .iso na pasta /bases/wrk e importar pela interface.

7. Linux: converter 9xx para 3xxx
```
retag dbn conv2.tab
```

Sendo conv2.tab:
```
904 3004
905 3005
906 3006
907 3007
908 3008
909 3009
917 3017
918 3018
919 3019
```