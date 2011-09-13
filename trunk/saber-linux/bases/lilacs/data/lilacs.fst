2 5 (|ID_|v2/)
3 0 ,mpu,(|LO_|,v03^*)
3 0 mpu(v3^a/,v3^b/,v3^c/,v3^*/)
3 0 mpu(v5001/)
4 0 mpu('LILACS',/,v5001/)
7 0 (|TO_|v7/)
8 0 ,mpu,(|EA_|v08^q/)
8 0 ,mpu,(|AR_|v08^y/)
8 0 ,mpu,(|IE_|v08^i/)
8 0 ,mpu,(|FT_|v08^g/)
8 0 if p(v08) then, if s(mpu,v08^*,mpu):'INTERNET' or p(v08^u) then 'IN_INTERNET' fi,fi,
9 0 ,mpu,(|TR_|v9/)
10 0 mpu,(|IA_|,v10|%|/)
10 0 mpu,(|AU_|,v10^*|%|/)
10 0 mpu,(|AU_|,v10^p|%|/)
10 0 mpu,(|AU_|,v10^c|%|/)
10 0 mpu,(|AU_|,v10^r|%|/)
10 0 mpu,(|AU_|,v10^1|%|/)
10 0 mpu,(|AU_|,v10^2|%|/)
10 8 mpu,'|AU_|'(v10|%|/)
10 8 mpu,'|TW_|'(v10|%|/)
10 8 mpu(v10|%|/)
11 8 mpu,'|TW_|'(v11|%|/)
11 8 mpu,'|AI_|'(v11|%|/)
11 0 mpu(|AI_|,v11|%|/)
11 0 mpu,(|AU_|,v11^*|%|/)
11 0 mpu,(|AU_|,v11^p|%|/)
11 0 mpu,(|AU_|,v11^c|%|/)
11 0 mpu,(|AU_|,v11^r|%|/)
11 0 mpu,(|AU_|,v11^1|%|/)
11 0 mpu,(|AU_|,v11^2|%|/)
11 8 mpu(v17|%|/)
12 8 mpu,'|TW_|'(v12|%|/)
12 8 mpu,'|TI_|'(v12|%|/)
12 0 mpu(|TI_|,v12|%|/)
12 0 mpu(|TI_|,v12^*|%|/)
12 8 mpu(v12|%|/)
12 8 mpu,'|TW_|'(v13|%|/)
12 8 mpu,'|TI_|'(v13|%|/)
12 0 mpu(|TI_|,v13|%|/)
12 0 mpu(|TI_|,v13^*|%|/)
12 8 mpu(v13|%|/)
16 0 mpu,(|IM_|,v16|%|/)
16 0 mpu,(|AU_|,v16^c|%|/)
16 0 mpu,(|AU_|,v16^p|%|/)
16 0 mpu,(|AU_|,v16^r|%|/)
16 0 mpu,(|AU_|,v16^*|%|/)
16 0 mpu,(|AU_|,v16^1|%|/)
16 0 mpu,(|AU_|,v16^2|%|/)
16 8 mpu,'|AU_|'(v16|%|/)
16 8 mpu,'|TW_|'(v16|%|/)
16 8 mpu(v16|%|/)
17 8 mpu,'|TW_|'(v17|%|/)
17 8 mpu,'|AI_|'(v17|%|/)
17 0 mpu(|AI_|,v17|%|/)
17 0 mpu(|AI_|,v17^*|%|/)
17 0 mpu(|AI_|,v17^p|%|/)
17 0 mpu(|AI_|,v17^c|%|/)
17 0 mpu(|AI_|,v17^r|%|/)
17 0 mpu(|AI_|,v17^1|%|/)
17 0 mpu(|AI_|,v17^2|%|/)
17 8 mpu(v17|%|/)
18 0 mpu,(|IT_|,v18|%|/)
18 8 mpu,'|TW_|'(v18|%|/)
18 0 mpu(|TI_|,v18^*|%|/)
18 0 mpu(|TI_|,v18|%|/)
18 8 mpu,'|TI_|'(v18|%|/)
18 8 mpu(v18|%|/)
23 0 mpu,(|IAC_|,v23|%|/)
23 8 mpu,'|AU_|'(v23|%|/)
23 8 mpu,'|TW_|'(v23|%|/)
23 0 mpu(|AU_|,v23|%|/)
23 0 mpu(|AU_|,v23^*|%|/)
23 0 mpu(|AU_|,v23^p|%|/)
23 0 mpu(|AU_|,v23^c|%|/)
23 0 mpu(|AU_|,v23^r|%|/)
23 0 mpu(|AU_|,v23^1|%|/)
23 0 mpu(|AU_|,v23^2|%|/)
23 8 mpu(v23|%|/)
24 8 mpu,'|TW_|'(v24|%|/)
24 8 mpu(|AU_|,v24|%|/)
24 0 mpu(|AU_|,v24^*|%|/)
24 0 mpu(|AU_|,v24^p|%|/)
24 0 mpu(|AU_|,v24^c|%|/)
24 0 mpu(|AU_|,v24^r|%|/)
24 0 mpu(|AU_|,v24^1|%|/)
24 0 mpu(|AU_|,v24^2|%|/)
24 8 mpu(v24|%|/)
25 0 mpu,(|ITC_|,v25|%|/)
25 8 mpu,'|TW_|'(v25|%|/)
25 8 mpu,'|TW_|'(v25^*|%|/)
25 8 mpu,'TI_',(v25|%|/)
25 8 mpu(v25|%|/)
30 0 ,if v5.1='S' and v6='as' and not s(v113):'u' then mpu,(|TA_|v30"/"v65.4,","v31,"("v32")"/) ,fi,
30 0 ,if v5.1='S' and v6='as' and v113='u' then mpu,('TA_'v30^*,"/"v65.4,","v31,"("v32") (Separata)"/) ,fi,
30 0 ,if v5.2='MS' then mpu,(|MS_|v30"/"v65.4,","v31,"("v32")"/) ,fi,
38 0 if s(mpu,v38^a,mpu):'CD' then 'SP_CD-ROM' fi,
38 0 if s(mpu,v08^*,mpu):'CD' then 'SP_CD-ROM' fi,
38 0 if s(mpu,v38^a,mpu):'DISQUE' or  s(mpu,v08^*,mpu):'DISK' then 'SP_DISQUETTE' fi,
38 0 if s(mpu,v08^*,mpu):'DISQUE' or  s(mpu,v08^*,mpu):'DISK' then 'SP_DISQUETTE' fi,
30 0 mpu,(|IS_|,v30|%|/)
31 8 mpu,'|TW_|'(v30|%|/)
31 8 mpu,'|TW_|'(v30^*|%|/)
31 8 mpu,'TS_'(v30|%|/)
31 8 mpu(v30|%|/)
40 0 ,mpu,(|LA_|v40^*|%|/),
49 0 mpu,(|OR_|,v49|%|/)
49 8 mpu,'|OR_|'(v49|%|/)
49 8 mpu,'|TW_|'(v49|%|/)
49 8 mpu(v49|%|/)
51 8 mpu,'|TW_|'(v51|%|/)
56 0 mpu,(|ICP_|,v56|%|/)
66 0 mpu,(|ICP_|,v66|%|/)
59 8 mpu,'|TW_|'(v59|%|/)
62 0 mpu(|ED_|,v62|%|/)
62 0 mpu('TW_',v62|%|/)
62 0 mpu(v62|%|/)
64 0 mpu('PD_',v64|%|/)
65 0 mpu('PD_',v65*0.4|%|/)
35 0 (|SN_|v35/)
67 0 mpu(v67|%|/)
69 0 (|KW_|v69/)

76 8 mpu,'|TW_|'(v76|%|/)
76 8 mpu,'|MH_|'(v76|%|/)

78 0 (|MH_|v78|%|/)
78 0 (|MH_|v78^*|%|/)
78 8 ,mpu,'|MH_|'(v78|%|/)
78 8 ,mpu,'|MH_|'(v78^*|%|/)
78 8 ,mpu,'|TW_|'(v78|%|/)
78 8 ,mpu,'|TW_|'(v78^*|%|/)

82 8 mpu,'|TW_|'(v82|%|/)

83 8 mpu,'|AB_|'(v83|%|/)
83 8 mpu,'|AB_|'(v83|%|/)
83 8 mpu,'|TW_|'(v83|%|/)
83 8 mpu,'|TW_|'(v83^*|%|/)
83 8 mpu(v83|%|/)

85 8 mpu,'|TW_|'(v85|%|/)

87 0 mpu,(|IDP_|,v87|%|/)
88 0 mpu,(|IDS_|,v88|%|/)

87 0 (|MH_|v87|%|/)
87 0 (|MH_|v87^*|%|/)
87 8 ,mpu,'|MH_|'(v87|%|/)
87 8 ,mpu,'|MH_|'(v87^*|%|/)
87 8 ,mpu,'|TW_|'(v87^*|%|/)


87 0 (|MH_|v87^d|%|/)
87 8 ,mpu,'|MH_|'(v87^d|%|/)
87 8 ,mpu,'|TW_|'(v87^d|%|/)


88 0 (|MH_|v88^*|%|/)
88 0 (|MH_|v88|%|/)
88 8 ,mpu,'|MH_|'(v88|%|/)
88 8 ,mpu,'|MH_|'(v88^*|%|/)
88 8 ,mpu,'|TW_|'(v88^*|%|/)

88 0 (|MH_|v88^d|%|/)
88 8 ,mpu,'|MH_|'(v88^d|%|/)
88 8 ,mpu,'|TW_|'(v88^d|%|/)

500 8 mpu,'|TW_|'(v500|%|/)
500 8 mpu,'|TW_|'(v500^*|%|/)

500 8 mpu,'|TW_|'(v505|%|/)
500 8 mpu,'|TW_|'(v505^*|%|/)

500 8 mpu,'|TW_|'(v530|%|/)

500 8 mpu,'|TW_|'(v533|%|/)
500 8 mpu,'|TW_|'(v534|%|/)

653 8 mpu,'|MH_|'(v653|%|/)
653 8 mpu,'|MH_|'(v653^*|%|/)
653 8 mpu,'|TW_|'(v653|%|/)
653 8 mpu(v653^*|%|/)


5 0 mpu,(if v5 = 's' THEN 'TL_Série' fi),
5 0 mpu,(if v5 = 'S' THEN 'TL_Série' fi),
5 0 mpu,(if v5 = 'sc' THEN 'TL_Série Periódica' fi),
5 0 mpu,(if v5 = 'SC' THEN 'TL_Série Periódica' fi),
5 0 mpu,(if v5 = 'scp' THEN 'TL_Documento de projeto e conferência em uma série periódica' fi),
5 0 mpu,(if v5 = 'SCP' THEN 'TL_Documento de projeto e conferência em uma série periódica' fi),
5 0 mpu,(if v5 = 'sp' THEN 'TL_Documento de projeto em uma série periódica' fi),
5 0 mpu,(if v5 = 'SP' THEN 'TL_Documento de projeto em uma série periódica' fi),
5 0 mpu,(if v5 = 'm' THEN 'TL_Monografia' fi),
5 0 mpu,(if v5 = 'mc' THEN 'TL_Documento de conferência em uma monografia' fi),
5 0 mpu,(if v5 = 'mcp' THEN 'TL_Documento de projeto e conferência em uma monografia' fi),
5 0 mpu,(if v5 = 'mp' THEN 'TL_Projeto em uma monografia' fi),
5 0 mpu,(if v5 = 'ms' THEN 'TL_Série Monográfica' fi),
5 0 mpu,(if v5 = 'msc' THEN 'TL_Conferência em uma Série Monográfica' fi),
5 0 mpu,(if v5 = 'msp' THEN 'TL_Documento de projeto em uma série monográfica' fi),
5 0 mpu,(if v5 = 'M' THEN 'TL_Monografia' fi),
5 0 mpu,(if v5 = 'MC' THEN 'TL_Documento de conferência em uma monografia' fi),
5 0 mpu,(if v5 = 'MCP' THEN 'TL_Documento de projeto e conferência em uma monografia' fi),
5 0 mpu,(if v5 = 'MP' THEN 'TL_Projeto em uma monografia' fi),
5 0 mpu,(if v5 = 'MS' THEN 'TL_Série Monográfica' fi),
5 0 mpu,(if v5 = 'MSC' THEN 'TL_Conferência em uma Série Monográfica' fi),
5 0 mpu,(if v5 = 'MSP' THEN 'TL_Documento de projeto em uma série monográfica' fi),
5 0 mpu,(if v5 = 't' THEN 'TL_Tese, Dissertação' fi),
5 0 mpu,(if v5 = 'T' THEN 'TL_Tese, Dissertação' fi),
5 0 mpu,(if v5 = 'ts' THEN 'TL_Tese, Dissertação pertencente a uma série monográfica' fi),
5 0 mpu,(if v5 = 'TS' THEN 'TL_Tese, Dissertação pertencente a uma série monográfica' fi),
5 0 mpu,(if v5 = 'n' THEN 'TL_Não Convencional' fi),
5 0 mpu,(if v5 = 'N' THEN 'TL_Não Convencional' fi),
5 0 mpu,(if v5 = 'nc' THEN 'TL_Documento de conferência em forma não convencional' fi),
5 0 mpu,(if v5 = 'NC' THEN 'TL_Documento de projeto em forma não convencional' fi),
5 0 mpu,(if v5 = 'p' THEN 'TL_Projeto' fi),
5 0 mpu,(if v5 = 'P' THEN 'TL_Projeto' fi),
5 0 mpu,(if v5 = 'c' THEN 'TL_Conferência' fi),
5 0 mpu,(if v5 = 'C' THEN 'TL_Conferência' fi),
5 0 mpu,(if v5 = 'nc' THEN 'TL_Material de COnferência Não Convencional' fi),
5 0 mpu,(if v5 = 'NC' THEN 'TL_Material de COnferência Não Convencional' fi),

93 0 mpu('PT_',v93^d*0.8|%|/)
94 0 mpu('PT_',v93^o|%|/)