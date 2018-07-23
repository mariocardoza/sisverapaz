function SelectSubCat(main_select_obj, sec_select_obj){
// ON selection of category this function will work

removeAllOptions(sec_select_obj);
addOption(sec_select_obj, "", "Seleccione el municipio", "");
if(main_select_obj.value == "Ahuachapán"){
addOption(sec_select_obj,"Ahuachapán", "Ahuachapán");
addOption(sec_select_obj,"Jujutla", "Jujutla");
addOption(sec_select_obj,"Atiquizaya", "Atiquizaya");
addOption(sec_select_obj,"Concepción de Ataco", "Concepción de Ataco");
addOption(sec_select_obj,"El Refugio", "El Refugio");
addOption(sec_select_obj,"Guaymango", "Guaymango");
addOption(sec_select_obj,"Apaneca", "Apaneca");
addOption(sec_select_obj,"San Francisco Menéndez", "San Francisco Menéndez");
addOption(sec_select_obj,"San Lorenzo", "San Lorenzo");
addOption(sec_select_obj,"San Pedro Puxtla", "San Pedro Puxtla");
addOption(sec_select_obj,"Tacuba", "Tacuba");
addOption(sec_select_obj,"Turín", "Turín");
}
if(main_select_obj.value == "Cabañas"){
addOption(sec_select_obj,"Cinquera", "Cinquera");
addOption(sec_select_obj,"Villa Dolores", "Villa Dolores");
addOption(sec_select_obj,"Guacotecti", "Guacotecti");
addOption(sec_select_obj,"Ilobasco", "Ilobasco");
addOption(sec_select_obj,"Jutiapa", "Jutiapa");
addOption(sec_select_obj,"San Isidro", "San Isidro");
addOption(sec_select_obj,"Sensuntepeque", "Sensuntepeque");
addOption(sec_select_obj,"Ciudad de Tejutepeque", "Ciudad de Tejutepeque");
addOption(sec_select_obj,"Victoria", "Victoria");
}
if(main_select_obj.value == "Chalatenango"){
addOption(sec_select_obj,"Agua Caliente", "Agua Caliente");
addOption(sec_select_obj,"Arcatao", "Arcatao");
addOption(sec_select_obj,"Azacualpa", "Azacualpa");
addOption(sec_select_obj,"Chalatenango", "Chalatenango");
addOption(sec_select_obj,"Citalá", "Citalá");
addOption(sec_select_obj,"Comalapa", "Comalapa");
addOption(sec_select_obj,"Concepción Quezaltepeque", "Concepción Quezaltepeque");
addOption(sec_select_obj,"Dulce Nombre de María", "Dulce Nombre de María");
addOption(sec_select_obj,"El Carrizal", "El Carrizal");
addOption(sec_select_obj,"El Paraíso", "El Paraíso");
addOption(sec_select_obj,"La Laguna", "La Laguna");
addOption(sec_select_obj,"La Palma", "La Palma");
addOption(sec_select_obj,"La Reina", "La Reina");
addOption(sec_select_obj,"Las Vueltas", "Las Vueltas");
addOption(sec_select_obj,"Nombre de Jesús", "Nombre de Jesús");
addOption(sec_select_obj,"Nueva Concepción", "Nueva Concepción");
addOption(sec_select_obj,"Nueva Trinidad", "Nueva Trinidad");
addOption(sec_select_obj,"Ojos de Agua", "Ojos de Agua");
addOption(sec_select_obj,"Potonico", "Potonico");
addOption(sec_select_obj,"San Antonio de la Cruz", "San Antonio de la Cruz");
addOption(sec_select_obj,"San Antonio Los Ranchos", "San Antonio Los Ranchos");
addOption(sec_select_obj,"San Fernando", "San Fernando");
addOption(sec_select_obj,"San Francisco Lempa", "San Francisco Lempa");
addOption(sec_select_obj,"San Francisco Morazán", "San Francisco Morazán");
addOption(sec_select_obj,"San Ignacio", "San Ignacio");
addOption(sec_select_obj,"San Isidro Labrador", "San Isidro Labrador");
addOption(sec_select_obj,"San José Cancasque", "San José Cancasque");
addOption(sec_select_obj,"San José Las Flores", "San José Las Flores");
addOption(sec_select_obj,"San Luis del Carmen", "San Luis del Carmen");
addOption(sec_select_obj,"San Miguel de Mercedes", "San Miguel de Mercedes");
addOption(sec_select_obj,"San Rafael", "San Rafael");
addOption(sec_select_obj,"Santa Rita", "Santa Rita");
addOption(sec_select_obj,"Tejutla", "Tejutla");
}
if(main_select_obj.value == "Cuscatlán"){
addOption(sec_select_obj,"Candelaria", "Candelaria");
addOption(sec_select_obj,"Cojutepeque", "Cojutepeque");
addOption(sec_select_obj,"El Carmen", "El Carmen");
addOption(sec_select_obj,"El Rosario", "El Rosario");
addOption(sec_select_obj,"Monte San Juan", "Monte San Juan");
addOption(sec_select_obj,"Oratorio de Concepción", "Oratorio de Concepción");
addOption(sec_select_obj,"San Bartolomé Perulapía", "San Bartolomé Perulapía");
addOption(sec_select_obj,"San Cristóbal", "San Cristóbal");
addOption(sec_select_obj,"San José Guayabal", "San José Guayabal");
addOption(sec_select_obj,"San Pedro Perulapán", "San Pedro Perulapán");
addOption(sec_select_obj,"San Rafael Cedros", "San Rafael Cedros");
addOption(sec_select_obj,"San Ramón", "San Ramón");
addOption(sec_select_obj,"Santa Cruz Analquito", "Santa Cruz Analquito");
addOption(sec_select_obj,"Santa Cruz Michapa", "Santa Cruz Michapa");
addOption(sec_select_obj,"Suchitoto", "Suchitoto");
addOption(sec_select_obj,"Tenancingo", "Tenancingo");
}
if(main_select_obj.value == "La Libertad"){
addOption(sec_select_obj,"Antiguo Cuscatlán", "Antiguo Cuscatlán");
addOption(sec_select_obj,"Chiltiupán", "Chiltiupán");
addOption(sec_select_obj,"Ciudad Arce", "Ciudad Arce");
addOption(sec_select_obj,"Colón", "Colón");
addOption(sec_select_obj,"Comasagua", "Comasagua");
addOption(sec_select_obj,"Huizúcar", "Huizúcar");
addOption(sec_select_obj,"Jayaque", "Jayaque");
addOption(sec_select_obj,"Jicalapa", "Jicalapa");
addOption(sec_select_obj,"La Libertad", "La Libertad");
addOption(sec_select_obj,"Nueva San Salvador", "Nueva San Salvador");
addOption(sec_select_obj,"Nuevo Cuscatlán", "Nuevo Cuscatlán");
addOption(sec_select_obj,"Opico", "Opico");
addOption(sec_select_obj,"Quezaltepeque", "Quezaltepeque");
addOption(sec_select_obj,"Sacacoyo", "Sacacoyo");
addOption(sec_select_obj,"San José Villanueva", "San José Villanueva");
addOption(sec_select_obj,"San Matías", "San Matías");
addOption(sec_select_obj,"San Pablo Tacachico", "San Pablo Tacachico");
addOption(sec_select_obj,"Talnique", "Talnique");
addOption(sec_select_obj,"Tamanique", "Tamanique");
addOption(sec_select_obj,"Teotepeque", "Teotepeque");
addOption(sec_select_obj,"Tepecoyo", "Tepecoyo");
addOption(sec_select_obj,"Zaragoza", "Zaragoza");
}
if(main_select_obj.value == "La Paz"){
addOption(sec_select_obj,"Cuyultitán", "Cuyultitán");
addOption(sec_select_obj,"El Rosario", "El Rosario");
addOption(sec_select_obj,"Jerusalén", "Jerusalén");
addOption(sec_select_obj,"Mercedes La Ceiba", "Mercedes La Ceiba");
addOption(sec_select_obj,"Olocuilta", "Olocuilta");
addOption(sec_select_obj,"Paraíso de Osorio", "Paraíso de Osorio");
addOption(sec_select_obj,"San Antonio Masahuat", "San Antonio Masahuat");
addOption(sec_select_obj,"San Emigdio", "San Emigdio");
addOption(sec_select_obj,"San Francisco Chinameca", "San Francisco Chinameca");
addOption(sec_select_obj,"San Juan Nonualco", "San Juan Nonualco");
addOption(sec_select_obj,"San Juan Talpa", "San Juan Talpa");
addOption(sec_select_obj,"San Juan Tepezontes", "San Juan Tepezontes");
addOption(sec_select_obj,"San Luis La Herradura", "San Luis La Herradura");
addOption(sec_select_obj,"San Luis Talpa", "San Luis Talpa");
addOption(sec_select_obj,"San Miguel Tepezontes", "San Miguel Tepezontes");
addOption(sec_select_obj,"San Pedro Masahuat", "San Pedro Masahuat");
addOption(sec_select_obj,"San Pedro Nonualco", "San Pedro Nonualco");
addOption(sec_select_obj,"San Rafael Obrajuelo", "San Rafael Obrajuelo");
addOption(sec_select_obj,"Santa María Ostuma", "Santa María Ostuma");
addOption(sec_select_obj,"Santiago Nonualco", "Santiago Nonualco");
addOption(sec_select_obj,"Tapalhuaca", "Tapalhuaca");
addOption(sec_select_obj,"Zacatecoluca", "Zacatecoluca");
}
if(main_select_obj.value == "La Unión"){
addOption(sec_select_obj,"Anamorós", "Anamorós");
addOption(sec_select_obj,"Bolívar", "Bolívar");
addOption(sec_select_obj,"Concepción de Oriente", "Concepción de Oriente");
addOption(sec_select_obj,"Conchagua", "Conchagua");
addOption(sec_select_obj,"El Carmen", "El Carmen");
addOption(sec_select_obj,"El Sauce", "El Sauce");
addOption(sec_select_obj,"Intipucá", "Intipucá");
addOption(sec_select_obj,"La Unión", "La Unión");
addOption(sec_select_obj,"Lislique", "Lislique");
addOption(sec_select_obj,"Meanguera del Golfo", "Meanguera del Golfo");
addOption(sec_select_obj,"Nueva Esparta", "Nueva Esparta");
addOption(sec_select_obj,"Pasaquina", "Pasaquina");
addOption(sec_select_obj,"Polorós", "Polorós");
addOption(sec_select_obj,"San Alejo", "San Alejo");
addOption(sec_select_obj,"San José", "San José");
addOption(sec_select_obj,"Santa Rosa de Lima", "Santa Rosa de Lima");
addOption(sec_select_obj,"Yayantique", "Yayantique");
addOption(sec_select_obj,"Yucuayquín", "Yucuayquín");
}
if(main_select_obj.value == "Morazán"){
addOption(sec_select_obj,"Arambala", "Arambala");
addOption(sec_select_obj,"Cacaopera", "Cacaopera");
addOption(sec_select_obj,"Chilanga", "Chilanga");
addOption(sec_select_obj,"Corinto", "Corinto");
addOption(sec_select_obj,"Delicias de Concepción", "Delicias de Concepción");
addOption(sec_select_obj,"El Divisadero", "El Divisadero");
addOption(sec_select_obj,"El Rosario", "El Rosario");
addOption(sec_select_obj,"Gualococti", "Gualococti");
addOption(sec_select_obj,"Guatajiagua", "Guatajiagua");
addOption(sec_select_obj,"Joateca", "Joateca");
addOption(sec_select_obj,"Jocoaitique", "Jocoaitique");
addOption(sec_select_obj,"Jocoro", "Jocoro");
addOption(sec_select_obj,"Lolotiquillo", "Lolotiquillo");
addOption(sec_select_obj,"Meanguera", "Meanguera");
addOption(sec_select_obj,"Osicala", "Osicala");
addOption(sec_select_obj,"Perquín", "Perquín");
addOption(sec_select_obj,"San Carlos", "San Carlos");
addOption(sec_select_obj,"San Fernando", "San Fernando");
addOption(sec_select_obj,"San Francisco Gotera", "San Francisco Gotera");
addOption(sec_select_obj,"San Isidro", "San Isidro");
addOption(sec_select_obj,"San Simón", "San Simón");
addOption(sec_select_obj,"Sensembra", "Sensembra");
addOption(sec_select_obj,"Sociedad", "Sociedad");
addOption(sec_select_obj,"Torola", "Torola");
addOption(sec_select_obj,"Yamabal", "Yamabal");
addOption(sec_select_obj,"Yoloaiquín", "Yoloaiquín");
}
if(main_select_obj.value == "San Miguel"){
addOption(sec_select_obj,"Carolina", "Carolina");
addOption(sec_select_obj,"Chapeltique", "Chapeltique");
addOption(sec_select_obj,"Chinameca", "Chinameca");
addOption(sec_select_obj,"Chirilagua", "Chirilagua");
addOption(sec_select_obj,"Ciudad Barrios", "Ciudad Barrios");
addOption(sec_select_obj,"Comacarán", "Comacarán");
addOption(sec_select_obj,"El Tránsito", "El Tránsito");
addOption(sec_select_obj,"Lolotique", "Lolotique");
addOption(sec_select_obj,"Moncagua", "Moncagua");
addOption(sec_select_obj,"Nueva Guadalupe", "Nueva Guadalupe");
addOption(sec_select_obj,"Nuevo Edén de San Juan", "Nuevo Edén de San Juan");
addOption(sec_select_obj,"Quelepa", "Quelepa");
addOption(sec_select_obj,"San Antonio", "San Antonio");
addOption(sec_select_obj,"San Gerardo", "San Gerardo");
addOption(sec_select_obj,"San Jorge", "San Jorge");
addOption(sec_select_obj,"San Luis de la Reina", "San Luis de la Reina");
addOption(sec_select_obj,"San Miguel", "San Miguel");
addOption(sec_select_obj,"San Rafael", "San Rafael");
addOption(sec_select_obj,"Sesori", "Sesori");
addOption(sec_select_obj,"Uluazapa", "Uluazapa");
}
if(main_select_obj.value == "San Salvador"){
addOption(sec_select_obj,"Aguilares", "Aguilares");
addOption(sec_select_obj,"Apopa", "Apopa");
addOption(sec_select_obj,"Ayutuxtepeque", "Ayutuxtepeque");
addOption(sec_select_obj,"Cuscatancingo", "Cuscatancingo");
addOption(sec_select_obj,"Ciudad Delgado", "Ciudad Delgado");
addOption(sec_select_obj,"El Paisnal", "El Paisnal");
addOption(sec_select_obj,"Guazapa", "Guazapa");
addOption(sec_select_obj,"Ilopango", "Ilopango");
addOption(sec_select_obj,"Mejicanos", "Mejicanos");
addOption(sec_select_obj,"Nejapa", "Nejapa");
addOption(sec_select_obj,"Panchimalco", "Panchimalco");
addOption(sec_select_obj,"Rosario de Mora", "Rosario de Mora");
addOption(sec_select_obj,"San Marcos", "San Marcos");
addOption(sec_select_obj,"San Martín", "San Martín");
addOption(sec_select_obj,"San Salvador", "San Salvador");
addOption(sec_select_obj,"Santiago Texacuangos", "Santiago Texacuangos");
addOption(sec_select_obj,"Santo Tomás", "Santo Tomás");
addOption(sec_select_obj,"Soyapango", "Soyapango");
addOption(sec_select_obj,"Tonacatepeque", "Tonacatepeque");
}
if(main_select_obj.value == "San Vicente"){
addOption(sec_select_obj,"Apastepeque", "Apastepeque");
addOption(sec_select_obj,"Guadalupe", "Guadalupe");
addOption(sec_select_obj,"San Cayetano Istepeque", "San Cayetano Istepeque");
addOption(sec_select_obj,"San Esteban Catarina", "San Esteban Catarina");
addOption(sec_select_obj,"San Ildefonso", "San Ildefonso");
addOption(sec_select_obj,"San Lorenzo", "San Lorenzo");
addOption(sec_select_obj,"San Sebastián", "San Sebastián");
addOption(sec_select_obj,"Santa Clara", "Santa Clara");
addOption(sec_select_obj,"Santo Domingo", "Santo Domingo");
addOption(sec_select_obj,"San Vicente", "San Vicente");
addOption(sec_select_obj,"Tecoluca", "Tecoluca");
addOption(sec_select_obj,"Tepetitán", "Tepetitán");
addOption(sec_select_obj,"Verapaz", "Verapaz");
}
if(main_select_obj.value == "Santa Ana"){
addOption(sec_select_obj,"Candelaria de la Frontera", "Candelaria de la Frontera");
addOption(sec_select_obj,"Chalchuapa", "Chalchuapa");
addOption(sec_select_obj,"Coatepeque", "Coatepeque");
addOption(sec_select_obj,"El Congo", "El Congo");
addOption(sec_select_obj,"El Porvenir", "El Porvenir");
addOption(sec_select_obj,"Masahuat", "Masahuat");
addOption(sec_select_obj,"Metapán", "Metapán");
addOption(sec_select_obj,"San Antonio Pajonal", "San Antonio Pajonal");
addOption(sec_select_obj,"San Sebastián Salitrillo", "San Sebastián Salitrillo");
addOption(sec_select_obj,"Santa Ana", "Santa Ana");
addOption(sec_select_obj,"Santa Rosa Guachipilín", "Santa Rosa Guachipilín");
addOption(sec_select_obj,"Santiago de la Frontera", "Santiago de la Frontera");
addOption(sec_select_obj,"Texistepeque", "Texistepeque");
}
if(main_select_obj.value == "Sonsonate"){
addOption(sec_select_obj,"Acajutla", "Acajutla");
addOption(sec_select_obj,"Armenia", "Armenia");
addOption(sec_select_obj,"Caluco", "Caluco");
addOption(sec_select_obj,"Cuisnahuat", "Cuisnahuat");
addOption(sec_select_obj,"Izalco", "Izalco");
addOption(sec_select_obj,"Juayúa", "Juayúa");
addOption(sec_select_obj,"Nahuizalco", "Nahuizalco");
addOption(sec_select_obj,"Nahulingo", "Nahulingo");
addOption(sec_select_obj,"Salcoatitán", "Salcoatitán");
addOption(sec_select_obj,"San Antonio del Monte", "San Antonio del Monte");
addOption(sec_select_obj,"San Julián", "San Julián");
addOption(sec_select_obj,"Santa Catarina Masahuat", "Santa Catarina Masahuat");
addOption(sec_select_obj,"Santa Isabel Ishuatán", "Santa Isabel Ishuatán");
addOption(sec_select_obj,"Santo Domingo", "Santo Domingo");
addOption(sec_select_obj,"Sonsonate", "Sonsonate");
addOption(sec_select_obj,"Sonzacate", "Sonzacate");
}
if(main_select_obj.value == "Usulután"){
addOption(sec_select_obj,"Alegría", "Alegría");
addOption(sec_select_obj,"Berlín", "Berlín");
addOption(sec_select_obj,"California", "California");
addOption(sec_select_obj,"Concepción Batres", "Concepción Batres");
addOption(sec_select_obj,"El Triunfo", "El Triunfo");
addOption(sec_select_obj,"Ereguayquín", "Ereguayquín");
addOption(sec_select_obj,"Estanzuelas", "Estanzuelas");
addOption(sec_select_obj,"Jiquilisco", "Jiquilisco");
addOption(sec_select_obj,"Jucuapa", "Jucuapa");
addOption(sec_select_obj,"Jucuarán", "Jucuarán");
addOption(sec_select_obj,"Mercedes Umaña", "Mercedes Umaña");
addOption(sec_select_obj,"Nueva Granada", "Nueva Granada");
addOption(sec_select_obj,"Ozatlán", "Ozatlán");
addOption(sec_select_obj,"Puerto El Triunfo", "Puerto El Triunfo");
addOption(sec_select_obj,"San Agustín", "San Agustín");
addOption(sec_select_obj,"San Buenaventura", "San Buenaventura");
addOption(sec_select_obj,"San Dionisio", "San Dionisio");
addOption(sec_select_obj,"San Francisco Javier", "San Francisco Javier");
addOption(sec_select_obj,"Santa Elena", "Santa Elena");
addOption(sec_select_obj,"Santa María", "Santa María");
addOption(sec_select_obj,"Santiago de María", "Santiago de María");
addOption(sec_select_obj,"Tecapán", "Tecapán");
addOption(sec_select_obj,"Usulután", "Usulután");
}
// check if both select are valid
//copy_dom();
$("#municipio").trigger('chosen:updated');
}
//////////////////

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
	$("#municipio").trigger('chosen:updated');
}


function addOption(selectbox, value, text )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;

	selectbox.options.add(optn);
}

  function dispHandle(obj) {
	if (obj.style.display == "none")
		obj.style.display = "";
	else
		obj.style.display = "none";
  }

  function copy_dom(textf, maincat, subcat){
	  if(maincat.selectedIndex != 0 && subcat.selectedIndex != 0){
		  textf.value =
		  maincat.options[maincat.selectedIndex].value
		  + ", " +
		  subcat.options[subcat.selectedIndex].value
		  } else {
			textf.value = '';
		  }
	  }
