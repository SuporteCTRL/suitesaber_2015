1. Criar txt da base no linux:
```
i2id dbn >texto.txt
```

2. Alterar o txt [gedit](no.md) para:

> Codificação IBM850 e Fim de linha Windows


3. Criar base pelo txt no windows:

```
id2i texto.txt create=dbn
```

Dessa maneira os acentos não ficam quebrados.