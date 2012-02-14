<<<<<<< .mine
1 0 "TM_"V1
=======
1 0 "TM_"V1
>>>>>>> .r346
1 0 if v1='P' or v1='X' then "TR_"v1,"_"v10/ fi   /*Libros prestados o devueltos por número de inventario */ 
2 0 if v1='P' or v1='X' then "TRU_"v1,"_"v20/ fi   /*Libros prestados o devueltos por usuario */ 
90 0 if v1='P' or v1='X' then "TC_"v1,"_"v90/ fi   /*Libros prestados o devueltos por No. de clasificación */ 
90 0 if v1='P' or v1='X' then "ON_"v1,"_"v95/ fi   /*Libros prestados o devueltos por No. del objeto */ 
10 0 "NI="v10/v10 
20 0 "CU_"v20/v20 
<<<<<<< .mine
30 0 "DA_"v30.4/"DA_"v30.6/"DA_"v30 
30 0 v30*6.2,'/',v30*4.2,'/',v30.4
30 0 'TIME_'v30
500 0 v500
500 0 v500*6.2,'/',v500*4.2,'/'v500*2.2
=======
30 0 "DA_"v30.4/"DA_"v30.6/"DA_"v30 
30 0 v30*6.2,'/',v30*4.2,'/',v30.4
30 0 v30*6.2,'/',v30*4.2,'/'v30*2.2
30 0 'TIME_'v30
500 0 v500>>>>>>> .r346
