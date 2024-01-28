/* FUNCIONES USADAS EN SOLICITUD.PHP */
function nomasig(codigo)
{
//alert(codigo.value);
while(isNaN(codigo.value))
	{
		codigo.value=codigo.value.substr(0,codigo.value.length-1);
	}
if(codigo.value.length==5)
{
var numcaso=document.getElementById('caso');
var exped=document.getElementById('exp_e');
var capa=codigo.nextSibling.id;
var numero=capa.substr(4);

///alert(numcaso.value);

fajax('nombasig.php',capa,'asig=3'+codigo.value+'&exp='+exped.value+'&caso='+numcaso.value+'&numero='+numero,'post','0');

	if (numcaso.value == '05'){
		var lap1=document.getElementById('lap1');
		capa1=lap1.id;
		fajax('busca_lap.php',capa1,'lap=1&asig=3'+codigo.value+'&exp='+exped.value,'post','0');

		var lap2=document.getElementById('lap2');
		capa2=lap2.id;
		//alert(capa2);
		fajax('busca_lap.php',capa2,'lap=2&asig=3'+codigo.value+'&exp='+exped.value,'post','0');
	}
}//fin codigo.length

}//fin funcion


function varias (numero)
{
var espacio=document.getElementById('campos');
var insertar=document.getElementById('agregar').cloneNode(true);
		var tabl=insertar.childNodes[1];
		for(i=0;i< numero;i++)
		{
			var fila=document.getElementById('materia').cloneNode(true);
			fila.childNodes[0].childNodes[0].name+=i;
			fila.childNodes[0].childNodes[1].id+=i;
			tabl.tBodies[0].appendChild(fila);
		}
		insertar.appendChild(tabl);
		espacio.appendChild(insertar);
}

function repitencia()
{
	var nota = document.getElementById('aviso');
	if(nota.value!="")
		{
			var aviso= document.getElementById('obser');
			aviso.style.visibility="visible";
			aviso.value=nota.value;
			aviso.rows=2;
		}		
}



function campos(){
var opcion=document.getElementById('caso');
var espacio=document.getElementById('campos');
var hab=document.getElementById('p'+opcion.value);
var enviar=document.getElementById('enviar');
var mnsj=document.getElementById('mensaje');

while(espacio.childNodes.length > 0)
{
espacio.removeChild(espacio.childNodes[espacio.childNodes.length-1]);
}
if(hab.value=="")		// verifica si esta habilitado el proceso
{
enviar.disabled=false;
mnsj.disabled=false;
var asignatura	=document.getElementById('td_asig').cloneNode(true);
var requisito	=document.getElementById('td_prela').cloneNode(true);
var lapsoact	=document.getElementById('td_lapso_act').cloneNode(true);
var lapsofin	=document.getElementById('td_lapso_fin').cloneNode(true);
var exceso		=document.getElementById('td_exceso').cloneNode(true);
var notaact		=document.getElementById('td_nota_act').cloneNode(true);
var notafin		=document.getElementById('td_nota_fin').cloneNode(true);
var especialidad=document.getElementById('td_nueva_esp').cloneNode(true);
var traslado	=document.getElementById('td_traslado').cloneNode(true);
var aviso		=document.getElementById('obser');
aviso.style.visibility="hidden";
aviso.value="";
aviso.rows=1;

switch(opcion.value)
	{
	
	case '01':
		var num_materias=1;
		var i;
		do{		
		num_materias=prompt('Numero de Asignaturas a Retirar (de 1 a 10): ',1);
		}while(isNaN(num_materias)==true || num_materias>10);
		if(num_materias==null) num_materias=1;
		if(num_materias==1)
		{
		espacio.appendChild(asignatura);
		}
		else
			{varias(num_materias);}	
		espacio.appendChild(lapsoact);
		var cantid=document.getElementById('cant');
		cantid.value=num_materias;
		
		break;
	case '15':
		var num_materias=1;
		var i;
		do{		
		num_materias=prompt('Numero de Asignaturas a Retirar: ',1);
		}while(isNaN(num_materias)==true || num_materias>10);
		if(num_materias==null) num_materias=1;
		if(num_materias==1)
		{
		espacio.appendChild(asignatura);
		}
		else
			{varias(num_materias);}	
		espacio.appendChild(lapsoact);
		var cantid=document.getElementById('cant');
		cantid.value=num_materias;

		lapso =document.getElementById('lap_proc').value.split('-');

		document.getElementById('lap1').value = lapso[0];
		document.getElementById('lap2').value = lapso[1];
		
		document.getElementById('lap1').readOnly = true;
		document.getElementById('lap2').readOnly = true;


		break;
	case '02':
		var num_materias=1;
		var i;
		do{		
		num_materias=prompt('Numero de Asignaturas a Agregar (de 1 a 10): ',1);
		}while(isNaN(num_materias)==true  || num_materias>10);
		if(num_materias==null) num_materias=1;
		if(num_materias==1)
		{
		espacio.appendChild(asignatura);
		}
		else
			{varias(num_materias);}
		var cantid=document.getElementById('cant');
		cantid.value=num_materias;
		espacio.appendChild(lapsoact);
		repitencia();
		break;
	case '03':
		var num_materias=1;
		do{		
		num_materias=prompt('Numero de Asignaturas a Inscribir (de 1 a 10): ',1);
		}while(isNaN(num_materias)==true || num_materias>10);
		if(num_materias==null) num_materias=1;
		if(num_materias==1)
		{
		espacio.appendChild(asignatura);
		}
		else
			{varias(num_materias);}
		var cantid=document.getElementById('cant');
		cantid.value=num_materias;
		espacio.appendChild(lapsoact);
		repitencia();
		break;
	case '04':
		espacio.appendChild(asignatura);
		espacio.appendChild(requisito);
		espacio.appendChild(lapsoact);
		var cantid=document.getElementById('cant');
		cantid.value=1;
		repitencia();
		break;
	case '05':
		espacio.appendChild(asignatura);
		//espacio.appendChild(traslado);		
		espacio.appendChild(lapsoact);
		espacio.appendChild(lapsofin);
		break;
	case '08':
		var espec=document.getElementById('c_uni_ca');
		var selec=especialidad.childNodes[1];
		var i=0,ok=0;
		/*	
			La siguiente rutina elimina de la lista la especialidad origen del estudiante
			para que no eligiera la misma como destino, a bien de aplicar la normativa de retiros se desahabilito
			y se reemplazo la rutina con php en el archivo solicitud.php a partir de la linea 181.
		*/
		
		/*do {
			alert(selec.childNodes[i].value.substr(0,1));
			if (selec.childNodes[i].value.substr(0,1) == espec.value) {
				selec.removeChild(selec.childNodes[i]);
				ok=1;
			}
			i++;
		}while (ok==0);*/

		var cumple=document.getElementById('cumple').value;

		if (!cumple) {
			enviar.disabled = true;
		}



		espacio.appendChild(especialidad);
		break;
	case '10':
		espacio.appendChild(lapsoact);
		break;
	case '11':
		var num_materias=1;
		var i;
		do{		
		num_materias=prompt('Numero de Asignaturas a Inscribir (de 1 a 10): ',1);
		}while(isNaN(num_materias)==true  || num_materias>10);
		if(num_materias==null) num_materias=1;
		varias(num_materias);
		espacio.appendChild(lapsoact);
		var cantid=document.getElementById('cant');
		cantid.value=num_materias;
		repitencia();
		break;
	case '12':
		var num_materias=1;
		var i;
		do{		
		num_materias=prompt('Numero de Asignaturas a Inscribir (de 1 a 10): ',1);
		}while(isNaN(num_materias)==true || num_materias>10);
		if(num_materias==null) num_materias=1;
		if(num_materias==1)
		{
		espacio.appendChild(asignatura);
		}
		else
			{varias(num_materias);}
		espacio.appendChild(lapsoact);
		espacio.appendChild(exceso);
		var cantid=document.getElementById('cant');
		cantid.value=num_materias;
		repitencia();
		break;
	case '13':
		espacio.appendChild(asignatura);
		espacio.appendChild(lapsoact);
		espacio.appendChild(notaact);	
		espacio.appendChild(notafin);
		var cantid=document.getElementById('cant');
		cantid.value=1;
		break;
	
	}
}//---cierra el if de habilitar procesos
else
	{
	
		var h = document.createElement("td");
		h.innerHTML="<p align='center'>"+hab.value+"</p>";
		espacio.appendChild(h);
		enviar.disabled=true;
		mnsj.disabled=true;
	}

}


function validar(boton){
	
var aviso=document.getElementById('obser');
var numcaso=document.getElementById('caso');
aviso.value="";
if(numcaso.value=="02" || numcaso.value=="03" || numcaso.value=="04" || numcaso.value=="11" || numcaso.value=="12") repitencia();
	
var espacios=document.getElementById('campos');
var i;
var error=0;

if(numcaso.value=="0")
{
alert("No ha seleccionado el Tipo de Caso");
error=1;
}

for(i=0;i< espacios.childNodes.length;i++)
{
var campo=espacios.childNodes[i].childNodes[1];

var etiq=espacios.childNodes[i].childNodes[0].nodeValue;

	if(campo.name=="c_asigna0" || campo.name=="prelacion")
	{	
		if(campo.value=="")
			{
				alert(etiq+" esta vacio");
				error=1;			
			} 
		if(campo.value.length<5)
			{
				alert("El campo Codigo debe constar de 5 Numeros");
						error=1;
			}
		if(isNaN(campo.value)==true)
			{	
				alert(etiq+' solo debe contener Numeros');
				error=1;
			}
		if(espacios.childNodes[i].childNodes[2].childNodes.length>0)
			{
				cap=campo.nextSibling.childNodes[0].nodeValue;
				
				if(cap=="No existe este Codigo para el pensum 5" || cap=="Codigo de pensum de otra Especialidad")
					{
						alert(cap+". Corrija el campo de Codigo");
						error=1;
					}
				
				if(numcaso.value=="01" || numcaso.value=="13")
					{
						if(cap=="Materia No Inscrita ni cursada")
							{		
								alert(cap+". Corrija el campo de Codigo");
								error=1;
							}
						
					}
				var recursar=campo.nextSibling.childNodes[0].firstChild.nodeValue;
				if(recursar.substr(0,8)=="RECURSAR")
					{
						var obser=document.getElementById('obser').value += "- "+recursar+", "+campo.value+".<br>\n";
						alert('Se ha añadido al comentario de Recursar una Asignatura');
					}
			}
		
	}
	
	if(campo.name=="ano_act" || campo.name=="ano_fin")
	{	
		var lapso_in=document.getElementById('lap_in').value;// Lapso Ingreso
		var lapso_act=document.getElementById('lap_proc').value;// Lapso Actual
		var lapso=espacios.childNodes[i].childNodes[3].value;
		if(campo.value=="" || lapso=="")
			{
				alert(etiq+" esta vacio");
				error=1;			
			}
		if(lapso!="1" && lapso!="2" && lapso!="1I" && lapso!="U")
			{	
				alert("Formato de "+etiq+" Invalido");
				error=1;
			}
		var lapso_comp=campo.value+'-'+lapso;
		if(((lapso_comp<lapso_in) || (lapso_comp>lapso_act)) && (numcaso.value != "10") && (numcaso.value != "05"))
			{	
				alert("El lapso introducido debe ser:\n\n- MAYOR o IGUAL a su lapso de Ingreso y\n- MENOR o IGUAL al lapso Actual.\n\nSu Lapso de Ingreso: "+lapso_in+"\nEl Lapso Actual es: "+lapso_act);
				error=1;
			}
		if ((numcaso.value == "10") && (lapso_comp<lapso_act)){ // para reingreso
			alert("El lapso introducido debe ser MAYOR o IGUAL al lapso Actual.\n\nEl Lapso Actual es: "+lapso_act);			
		}
		if ((numcaso.value == "05") && ((lapso_comp>lapso_act) || (lapso_comp<lapso_in))){ // para traslado de acta
			alert("El rango de lapsos introducidos deben ser:\n\n- MAYOR o IGUAL a su lapso de Ingreso y\n- MENOR o IGUAL al lapso Actual.\n\nSu Lapso de Ingreso: "+lapso_in+"\nEl Lapso Actual es: "+lapso_act);			
		}
	}
	
	if(campo.name=="nota_act" || campo.name=="nota_fin")
	{
		if(campo.value=="")
			{
				alert(etiq+" esta vacio");
				error=1;			
			}
		if(isNaN(campo.value)==true)
		{
			error=1;
			alert(etiq+" solo debe contener Numeros");
		}
	}
	
	if(campo.name=="exceso")
	{
		if(campo.value=="")
			{
				alert(etiq+" esta vacio");
				error=1;			
			}
		if(isNaN(campo.value)==true)
		{
			error=1;
			alert(etiq+" solo debe contener Numeros");
		}
	}
	
	if(campo.name=="nueva_esp" || campo.name=="traslado")
	{
		if(campo.value=="0")
			{
				alert("No ha seleccionado una opcion de"+etiq);
				error=1;			
			}
	}
	if(campo.id=="capa" || campo.id=="capa0")
		{ alert("capa");
		}
	
	if(campo.id=="tab_mat")
	{	
	
		var j=0;
		for(j=0;j< campo.tBodies[0].rows.length;j++)
			{
				var inputs=campo.tBodies[0].rows[j].cells[0].childNodes[0];
				if(campo.tBodies[0].rows[j].cells[0].childNodes[1].childNodes.length>0)
					{
							var capas=campo.tBodies[0].rows[j].cells[0].childNodes[1].childNodes[0].nodeValue;
							if(capas=="No existe este Codigo para el pensum 5" || capas=="Codigo de pensum de otra Especialidad")
								{
							alert(capas+". Corrija el campo de Codigo "+eval(j+1));
							error=1;
								}
							if(numcaso.value=="01" || numcaso.value=="13")
								{
									if(capas=="Materia No Inscrita ni cursada")
										{		
											alert(capas+". Corrija el campo de Codigo");
											error=1;
										}
						
								}
							var recursar=campo.tBodies[0].rows[j].cells[0].childNodes[1].childNodes[0].firstChild.nodeValue;
							if(recursar.substr(0,8)=="RECURSAR")
								{
									var obser=document.getElementById('obser').value += "- "+recursar+", "+inputs.value+".<br>\n";
									alert('Se ha añadido al comentario de Recursar una Asignatura');
								}
					}
				
				if(inputs.value=="")
					{
						alert("Debe completar todos los campos de Codigo");
						error=1;
					}
				if(isNaN(inputs.value)==true)
					{
						alert("El campo Codigo debe contener solo Numeros");
						error=1;
					}
				if(inputs.value.length<5)
					{
						alert("El campo Codigo debe constar de 5 Numeros");
						error=1;
					}
			}
		
	}
	
} 

	var desc=document.getElementById('mensaje');
	if(desc.value=="")
	{
		alert("Debe describir el caso");
		error=1;
	}

if(error==0){
	boton.disabled=true;
	msg = "Si tu Solicitud está relacionada con un AGREGADO o INSCRIPCIÓN de materias\n";
	msg+= "recuerda consignar en Control de Estudios la planilla de agregado una vez que\n";
	msg+= "tu caso sea aprobado.";
	alert (msg);
	document.formulario.submit();
	}
else{
	return (false);
	}

}

function restantes(area)
{
	var rest=document.getElementById('rest');
	rest.value=300-area.value.length;
	if(rest.value<0)
		{
			area.value=area.value.substr(0,300);
		}
	rest.value=300-area.value.length;
}

function mayus(campo)
{
campo.value=campo.value.toUpperCase();
}

function apuntar(lapso)
{
	
while(isNaN(lapso.value))
	{
		lapso.value=lapso.value.substr(0,lapso.value.length-1);
	}
if(lapso.value.length==4)
	{
		var lap_proc=document.getElementById('lap_proc');	
		var year_max=parseInt(lap_proc.value.substr(0,4))+2;
		if(parseInt(lapso.value)>year_max)
			{
				alert("El Lapso NO debe ser mayor al "+year_max);
				lapso.value="";
			}
		else
			{
				var sig=lapso.nextSibling;
				sig.nextSibling.focus();
			}
	}
}

function punto(nota)
{

if(nota.value.length==1) {
nota.value+=".";}
}

/* FUNCION PARA RELOJ*/

function actualizaReloj(){ 
	/* Capturamos la Hora, los minutos y los segundos */
	marcacion = new Date() 
	/* Capturamos la Hora */
	Hora = marcacion.getHours() 
	/* Capturamos los Minutos */
	Minutos = marcacion.getMinutes() 
	/* Capturamos los Segundos */
	Segundos = marcacion.getSeconds() 
	/* Si la Hora, los Minutos o los Segundos
	Son Menores o igual a 9, le añadimos un 0 */
	if (Hora<=9)
	Hora = "0" + Hora
	if (Minutos<=9)
	Minutos = "0" + Minutos
	if (Segundos<=9)
	Segundos = "0" + Segundos
	if (Hora > 12) { Hora -= 12; ampm = " PM" } else ampm = " AM"
	// Hora += ampm 

	/* Comienza el Script de la Fecha */

	var Dia = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
	var Mes = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var Hoy = new Date();
	var Anio = Hoy.getFullYear();
	var Fecha = " " + Dia[Hoy.getDay()] + ", " + Hoy.getDate() + " de " + Mes[Hoy.getMonth()] + " de " + Anio + " - ";

	/* Termina el script de la Fecha */

	/* Creamos 4 variables para darle formato a nuestro Script */
	var Inicio, Script, Final, Total
	/*En Inicio le indicamos un color de fuente  y un tamaño */
	Inicio = "<font size=1 color=blue family=arial>"
	/* En Reloj le indicamos la Hora, los Minutos y los Segundos */
	Script = Fecha + Hora + ":" + Minutos + ":" + Segundos + ampm
	/* En final cerramos el tag de la fuente */
	Final = "</font>"
	/* En total Finalizamos el Reloj uniendo las variables */
	Total = Inicio + Script + Final
	/* Capturamos una celda para mostrar el Reloj */
		document.getElementById('fecha').value = Script
	/* Indicamos que nos refresque el Reloj cada 1 segundo */
	setTimeout("actualizaReloj()",1000) 
}

/* FUNCIONES USADAS POR FAJAX */

function AJAXCrearObjeto(){ 
 var obj; 
 
 if(window.XMLHttpRequest) 
 	{ // no es IE 
 	obj = new XMLHttpRequest(); 
 	} 
	else 
	{ // Es IE o no tiene el objeto 
 		try { 
			 obj = new ActiveXObject("Microsoft.XMLHTTP"); 
		    } 
 		catch (e) { 
 					alert('El navegador utilizado no está soportado'); 
 				  } 
 	} 
 //alert ("objeto creado");
 return obj; 
} 


function fajax(url,capa,valores,metodo,xml) //xml=1 (SI) xml=0 (NO)
{
	
	var ajax=AJAXCrearObjeto();
	var capaContenedora= document.getElementById(capa);
	if (capaContenedora.type == "text"){
		texto = true;
	}else{
		texto = false;
	}
	//texto = true;
	var contXML;
	/* Creamos y ejecutamos la instancia si el metodo elegido es POST */
	if (metodo.toUpperCase()=='POST')
	{

		ajax.open ('POST', url, true);
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==1) 
			{
				capaContenedora.innerHTML="<img src='loader.gif'>";
			}
			else if (ajax.readyState==4)
			{
				if (ajax.status==200)
				{
					if (xml==0)
					{	
						if (texto){
							document.getElementById(capa).value=ajax.responseText;
						}
						document.getElementById(capa).innerHTML=ajax.responseText;
					}
					if (xml==1)
					{

     					var Contxml  = ajax.responseXML.documentElement;
	   					var items = Contxml.getElementsByTagName('nota')[0];
       					var txt = items.getElementsByTagName('destinatario')[0].firstChild.data; 
						document.getElementById(capa).innerHTML=txt;
						
						
					}
				}
				else if (ajax.readyState=404)
				{
					capaContenedora.innerHTML = "La direccion no existe";
				}
				else
				{
					capaContenedora.innerHTML="Error: "+ajax.status;
				}
			}
		}
	
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send(valores);
		return;
	}
	/* Creamos y ejecutamos la instancia si el metodo elegido es GET */
	if (metodo.toUpperCase()=='GET')
	{
		ajax.open ('GET', url, true);
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==1) 
			{
				capaContenedora.innerHTML="<img src='loading.gif'>";
			}
			else if (ajax.readyState==4)
			{
				if (ajax.status==200)
				{
					if (xml==0)
					{
						document.getElementById(capa).innerHTML=ajax.responseText;
					}
					if (xml==1)
					{
						alert(ajax.responseXML.getElementsByTagName("nota")[0].childNodes[1].nodeValue); 
					}
				}
				else if (ajax.readyState=404)
				{
					capaContenedora.innerHTML = "La direccion no existe";
				}
				else
				{
					capaContenedora.innerHTML="Error: "+ajax.status;
				}
			}
		}
	
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send(null);
		return;
	}
}

//----------------------------------------------------------------------------------------------------
//----------------------------------FUNCIONES USADAS EN DPTOS.PHP-------------------------------------
//----------------------------------------------------------------------------------------------------
function ajustar()
{
	var cuerpo= document.getElementById('cuerpo');
	var medio="";
	var i=0;
	do{
		medio+=".previousSibling";
		i++;
	}while(eval("cuerpo"+medio+".nodeName")!="TABLE" && i<7);
	
	var tabcas= document.getElementById('tab_casos');
	
	var tabla = eval("cuerpo"+medio);
	tabla.width=tabcas.offsetWidth;
}

function ajustar_ar()
{
	alert('Archivo Cargado!');
	var cuerpo= document.getElementById('cuerpo');
	var medio="";
	var i=0;
	do{
		medio+=".previousSibling";
		i++;
	}while(eval("cuerpo"+medio+".nodeName")!="TABLE" && i<7);
	var ancho=cuerpo.offsetWidth;
	var tabla = eval("cuerpo"+medio);
	tabla.width=ancho;
}

function selec(box)
{
cas=box.checked;
var tbod=box.parentNode.parentNode.parentNode.parentNode.tBodies[0];
var i;
for(i=0; i< tbod.rows.length ; i++)
	{
		if(tbod.rows[i].cells[0].childNodes[0].disabled==false)
			{
				tbod.rows[i].cells[0].childNodes[0].checked=cas;
			}
	}	
}

//------------- ABRIR Y GUARDAR CAMBIOS PARA ELABORAR INFORME---------------------

function informe(boton)
{
	div_name=boton.name;
	var plant=document.getElementById('planteamiento');
	var res=document.getElementById('resultados');
	var ana=document.getElementById('analisis');
	var rec=document.getElementById('recomendacion');
	plant.parentNode.childNodes[0].childNodes[0].nodeValue = 'Solicitud '+boton.parentNode.parentNode.cells[1].childNodes[0].nodeValue;	//escribe el numero de solicitud
	rec.nextSibling.value=boton.nextSibling.id;			// guarda el ID del campo oculto
	plant.value=boton.nextSibling.value;
	res.value=boton.nextSibling.nextSibling.value;
	ana.value=boton.nextSibling.nextSibling.nextSibling.value;
	rec.value=boton.nextSibling.nextSibling.nextSibling.nextSibling.value;	
}

function aplicar_inf()
{
	var plant=document.getElementById('planteamiento');
	var res=document.getElementById('resultados');
	var ana=document.getElementById('analisis');
	var rec=document.getElementById('recomendacion');
	var plante=document.getElementById(rec.nextSibling.value);
	plante.value=plant.value;
	plante.nextSibling.value=res.value;
	plante.nextSibling.nextSibling.value=ana.value;
	plante.nextSibling.nextSibling.nextSibling.value=rec.value;
	hideMe();
}

//---------------ABRIR Y GUARDAR PLANILLA DE RESULTADOS DE LA PRUEBA APTITUDINAL--------------
function result(boton)
{
	div_name=boton.name;
	var tab_raz=document.getElementById('razon');
	var tab_inter=document.getElementById('inter');
	tab_raz.parentNode.childNodes[0].childNodes[0].nodeValue = 'Solicitud '+boton.parentNode.parentNode.cells[1].childNodes[0].nodeValue;//escribe numero de solicitud
	arreg= new Array();
	var i;
	var j;
//----------------Carga los valores de los campos ocultos a la planilla de Tablas inter y razon--------------
for(j=1; j <= 5 ;j++)
{
arreg=boton.parentNode.childNodes[j].value.split('-');
	for(i=1; i<=3; i++)
		{
			tab_raz.tBodies[0].rows[j-1].cells[i].childNodes[0].value=arreg[i-1];
		}
}

for(j=6; j <= 15 ;j++)
{
arreg=boton.parentNode.childNodes[j].value.split('-');
	for(i=1; i<=3; i++)
		{
			tab_inter.tBodies[0].rows[j-6].cells[i].childNodes[0].value=arreg[i-1];
		}
}
	
	tab_inter.nextSibling.value=boton.id;
}

function aplicar_prueba()
{
	var tab_raz=document.getElementById('razon');
	var tab_inter=document.getElementById('inter');
	var boton=document.getElementById(tab_inter.nextSibling.value);
	var i;
	var j;
	arreg= new Array();
	//-----------------------------------carga los valores de la planilla a los campos ocultos de cada caso--------------------
	for(j=1; j<=5 ; j++)
	{
		for(i=1; i<=3; i++)
			{
				arreg[i-1]=tab_raz.tBodies[0].rows[j-1].cells[i].childNodes[0].value;
			}
		boton.parentNode.childNodes[j].value=arreg.join('-');
	}
	
	for(j=6; j<=15 ; j++)
	{
		for(i=1; i<=3; i++)
			{
				arreg[i-1]=tab_inter.tBodies[0].rows[j-6].cells[i].childNodes[0].value;
			}
		boton.parentNode.childNodes[j].value=arreg.join('-');
	}
	boton.parentNode.childNodes[16].value=document.getElementById('con_recom').value;
	
	alert('Esta opcion aplicara los cambios al resultado de la prueba.\n');
	guardar_prueba();
	hideMe();
}

//------------- ABRIR Y GUARDAR CAMBIOS PARA COMENTAR---------------------
function editar(areatabla)
{	
	div_name=areatabla.name;
	var areaedit=document.getElementById('comentario');
	areaedit.parentNode.childNodes[0].childNodes[0].nodeValue = 'Solicitud '+areatabla.parentNode.parentNode.cells[1].childNodes[0].nodeValue;	// numero de solicitud
	areaedit.value=areatabla.value;
	areaedit.nextSibling.value=areatabla.id;
}
function aplicar()
{
	var areaedit=document.getElementById('comentario');
	document.getElementById(areaedit.nextSibling.value).value=areaedit.value;
	hideMe();
}



function planilla(boton)
{
var fila=boton.parentNode.parentNode.parentNode;
var formu=boton.parentNode;
var campo=boton.nextSibling;

if(fila.cells[0].childNodes[0].nodeName=="INPUT")
	{
		campo.value=fila.cells[1].childNodes[0].nodeValue;
	}
else
	{
		campo.value=fila.cells[0].childNodes[0].nodeValue;
	}
//alert(campo.value);
formu.submit();
}

function solicitar(boton)
{
var fila=boton.parentNode.parentNode.parentNode;
var solicitud=fila.cells[1].childNodes[0].nodeValue;

fajax('solicitar.php','capa','solicitud='+solicitud+'&depart='+depart.value,'post','0');

boton.disabled=true;

}

function env_inf()
{
	var tbod=document.getElementById('tbod');
	var solicitud="";
	var prueba="";
	var con_recom="";
	var plant="";
	var resultados="";
	var analisis="";
	var recomen="";
	var i,j;
	for(i=0; i<tbod.rows.length; i++)
		{
			if(tbod.rows[i].cells[0].childNodes[0].checked==true)
				{
					var sol=tbod.rows[i].cells[1].childNodes[0];
					var sol_btn=tbod.rows[i].cells[2].childNodes[0];
					var elab=tbod.rows[i].cells[3].childNodes[0];
					solicitud+= sol.nodeValue+'/';
						if(elab.value=="Resultados Prueba Aptitudinal")
							{
								for(j=1; j<=15 ; j++)
									{
										prueba+=elab.parentNode.childNodes[j].value+'.';
									}
								con_recom+=elab.parentNode.childNodes[16].value+'/';
								plant+='/';
								resultados+='/';
								analisis+='/';
								recomen+='/';
								prueba+='/';
							}
						else
							{
								plant+=elab.parentNode.childNodes[1].value.replace('/','-')+'/';
								resultados+=elab.parentNode.childNodes[2].value.replace('/','-')+'/';
								analisis+=elab.parentNode.childNodes[3].value.replace('/','-')+'/';
								recomen+=elab.parentNode.childNodes[4].value.replace('/','-')+'/';
								prueba+='/';
								con_recom+='/';
							}
														
					//sol_btn.disabled=true;
					//elab.disabled=true;
					//tbod.rows[i].cells[0].childNodes[0].checked=false;
					//tbod.rows[i].cells[0].childNodes[0].disabled=true;
				}
		}
	fajax('urdbe.php','capa','tipo=0&solicitud='+solicitud+'&plant='+plant+'&resultados='+resultados+'&analisis='+analisis+'&recomen='+recomen+'&prueba='+prueba+'&con_recom='+con_recom,'post','0');
}

function guardar(boton)
{
if(confirm("Confirma Guardar los Datos de las Solicitudes Seleccionadas"))
{	
	
	var tbod=document.getElementById('tbod');
	var depart=document.getElementById('depart');
	var i;
	var solicitud='';
	var resolucion='';
	var sesion='';
	var coment='';
	var estado='';
	
if(depart.value=='7')
	{
		for(i=0; i<tbod.rows.length; i++)
		{
			if(tbod.rows[i].cells[0].childNodes[0].checked==true)
				{
					var sol=tbod.rows[i].cells[1].childNodes[0];
			
					solicitud+= sol.nodeValue+'/';
					if(boton.value=="Procesado"){
						estado+= "4) Procesado"+'/';
					}else if (boton.value=="Rechazado"){
						 estado+= "5) Rechazado por Urace"+'/';
					}else{
						estado+= "x) ERROR en envío de datos"+'/';
					}
					
					tbod.rows[i].cells[0].childNodes[0].checked=false;
					tbod.rows[i].cells[0].childNodes[0].disabled=true;
				}
		}
		if(solicitud!='')
			{
				fajax('guardar.php','capa','solicitud='+solicitud+'&estado='+estado+'&depart='+depart.value,'post','0');
			}
	}
if(depart.value=='0')
	{
		for(i=0; i<tbod.rows.length; i++)
		{
			if(tbod.rows[i].cells[0].childNodes[0].checked==true)
				{
					var sol=tbod.rows[i].cells[1].childNodes[0];
					var est=tbod.rows[i].cells[5].childNodes[0];
					
					if(boton.value=="Guardar Cambios")
						{
							if(est.nodeName=="SELECT")
								{
									solicitud+= sol.nodeValue+'/';
									estado+= est.value+'/';
											
									est.disabled=true;
								}
							
						}
					else
						{
							solicitud+= sol.nodeValue+'/';
							tbod.rows[i].cells[0].childNodes[0].disabled=true;
							tbod.rows[i].cells[3].childNodes[0].childNodes[0].disabled=true;
							tbod.rows[i].cells[4].childNodes[0].childNodes[0].disabled=true;
							if(est.nodeName=="SELECT")
								{
									est.disabled=true;
								}
							
						}
					tbod.rows[i].cells[0].childNodes[0].checked==false;
				}
		}
		if(boton.value=="Eliminar Solicitud" && solicitud!='')
			{	
				fajax('eliminar.php','capa','solicitud='+solicitud,'post','0');
			}
		if(boton.value=="Guardar Cambios" && solicitud!='')
			{
				fajax('guardar.php','capa','solicitud='+solicitud+'&estado='+estado+'&depart='+depart.value,'post','0');
			}
	}

if(depart.value!='0' && depart.value!='7')
	{
	for(i=0; i<tbod.rows.length; i++)
		{
			if(tbod.rows[i].cells[0].childNodes[0].checked==true)
				{
					var sol=tbod.rows[i].cells[1].childNodes[0];
					var res=tbod.rows[i].cells[6].childNodes[0];
					var ses=tbod.rows[i].cells[7].childNodes[0];
					var com=tbod.rows[i].cells[8].childNodes[0];
					var est=tbod.rows[i].cells[9].childNodes[0];
					if(boton.value=="Guardar Cambios")
						{
							solicitud+= sol.nodeValue+'/';
							resolucion+= res.value.replace('/','-')+'/';
							sesion+= ses.value.replace('/','-')+'/';
							coment+= com.value.replace('/','-')+'/';
							estado+= est.value+'/';

							res.disabled=true;
							ses.disabled=true;
							com.disabled=true;
							est.disabled=true;
							
						}
					else
						{
							res.disabled=false;
							ses.disabled=false;
							com.disabled=false;
							est.disabled=false;
						}
					tbod.rows[i].cells[0].childNodes[0].disabled=true;
					tbod.rows[i].cells[0].childNodes[0].checked=false;
				}
		}
		if(boton.value=="Guardar Cambios" && solicitud!='')
			{	
				//alert(coment);
				fajax('guardar.php','capa','solicitud='+solicitud+'&resolucion='+resolucion+'&sesion='+sesion+'&coment='+coment+'&estado='+estado+'&depart='+depart.value,'post','0');
			}
	}
}// Fin confirma
}// Fin funcion



/* ///////////////FUNCIONES PARA EL LAYER FLOTANTE /////////////////*/

// Script Source: CodeLifter.com
// Copyright 2003
// Do not remove this header


isIE=document.all;
isNN=!document.all&&document.getElementById;
isN4=document.layers;
isHot=false;

function ddInit(e){
if(document.getElementById('error').value!="NO")
{
  topDog=isIE ? "BODY" : "HTML";
  whichDog=isIE ? document.getElementById(div_name) : document.getElementById(div_name);  
  hotDog=isIE ? event.srcElement : e.target;  
  while (hotDog.id!="titleBar"&&hotDog.tagName!=topDog){
    hotDog=isIE ? hotDog.parentElement : hotDog.parentNode;
  }  
  if (hotDog.id=="titleBar"){
    offsetx=isIE ? event.clientX : e.clientX;
    offsety=isIE ? event.clientY : e.clientY;
    nowX=parseInt(whichDog.style.left);
    nowY=parseInt(whichDog.style.top);
    ddEnabled=true;
    document.onmousemove=dd;
  }
}
}

function dd(e){
  if (!ddEnabled) return;
  whichDog.style.left=isIE ? nowX+event.clientX-offsetx : nowX+e.clientX-offsetx+"px"; 
  whichDog.style.top=isIE ? nowY+event.clientY-offsety : nowY+e.clientY-offsety+"px";
  return false;  
}

function ddN4(whatDog){
  if (!isN4) return;
  N4=eval(whatDog);
  N4.captureEvents(Event.MOUSEDOWN|Event.MOUSEUP);
  N4.onmousedown=function(e){
    N4.captureEvents(Event.MOUSEMOVE);
    N4x=e.x;
    N4y=e.y;
  }
  N4.onmousemove=function(e){
    if (isHot){
      N4.moveBy(e.x-N4x,e.y-N4y);
      return false;
    }
  }
  N4.onmouseup=function(){
    N4.releaseEvents(Event.MOUSEMOVE);
  }
}

function hideMe(){
  if (isIE||isNN) whichDog.style.visibility="hidden";
  else if (isN4) eval('document.'+div_name+'.visibility="hide"');
}

function showMe(obj){
  if (isIE||isNN) whichDog.style.visibility="visible";
  else if (isN4) eval('document.'+div_name+'.visibility="show"');
  if(obj.nodeName=="TEXTAREA") {document.getElementById('comentario').focus();}
}

document.onmousedown=ddInit;
document.onmouseup=Function("ddEnabled=false");
var div_name;

//-------------------------------------------------------------------------------------------------------------------
//------------------------------------Funciones usadas por ARCHIVO.PHP-----------------------------------------------
//-------------------------------------------------------------------------------------------------------------------

function param_bus(selec)
	{
		var celda=document.getElementById('campos');
		var i=0;
		while(celda.hasChildNodes())
			{
				celda.removeChild(celda.lastChild);
			}
		if(selec.value=="todos")
			{
				celda.innerHTML="Consulta <b>TODOS</b> los Casos del Archivo<br><span style='color: #8F8F8F; font-size: 11px'>Puede tardar un poco mas</span>";	
			}
		if(selec.value=="aprob")
			{
				celda.innerHTML="Consulta todos los Casos <b>Aprobados</b> del Archivo<br><span style='color: #8F8F8F; font-size: 11px'>Puede tardar un poco mas</span>";	
			}
		if(selec.value=="rechaz")
			{
				celda.innerHTML="Consulta todos los Casos <b>Rechazados</b> del Archivo<br><span style='color: #8F8F8F; font-size: 11px'>Puede tardar un poco mas</span>";	
			}
		if(selec.value=="proces")
			{
				celda.innerHTML="Consulta todos los Casos ya <b>Procesados</b> del Archivo<br><span style='color: #8F8F8F; font-size: 11px'>Puede tardar un poco mas</span>";	
			}
		if(selec.value=="fecha")
			{
				celda.innerHTML="Todos los Casos desde el <input type='text' id='fecha_1' name='fecha_1' size='10' maxlength='10' class='datospf' onkeyup='fecha(this)'> hasta el <input type'text' id='fecha_2' name='fecha_2' size='10' maxlength='10' class='datospf' onkeyup='fecha(this)'><br><span style='color: #8F8F8F; font-size: 11px'>Formato fecha DD-MM-AAAA, ejemplo: 01-12-2009</span>";	
			}
		if(selec.value=="lapso")
			{
				celda.innerHTML="Todos los Casos desde el lapso <input type='text' id='lapso_1' name='lapso_1' size='7' maxlength='7' class='datospf'> hasta el lapso <input type'text' id='lapso_2' name='lapso_2' size='7' maxlength='7' class='datospf'><br><span style='color: #8F8F8F; font-size: 11px'>Formato lapso AAAA-L, ejemplo: 2009-1, para Intensivo: 2009-1I</span>";	
			}
		if(selec.value=="caso")
			{
				celda.innerHTML="Todos los Casos de <select id='caso' name='caso' class='datospf'><option value='01'>Retiro Extempor&aacute;neo</option> <option value='02'>Agregado Extempor&aacute;neo</option><option value='03'>Exoneraci&oacute;n de 3 Semestres</option><option value='04'>Prelacion de Asignatura</option><option value='05'>Traslado de Lapso (Tesis/Entrenamiento)</option><option value='06'>Solicitud de Carga de Notas (Tesis)</option> <option value='07'>Correcci&oacute;n de Datos Personales</option> <option value='08'>Cambio de Especialidad</option><option value='09'>Carga de Materias por Equivalencia (Interna)</option><option value='10'>Reingreso</option><option value='11'>Inscripci&oacute;n Tard&iacute;a</option><option value='12'>Exceso de 22 Unidades de Cr&eacute;dito</option><option value='13'>Correcci&oacute;n de Nota</option><option value='14'>Reclamo de Operaciones Web</option></select>";	
			}
		if(selec.value=="depar")
			{
				celda.innerHTML="Todos los Casos del <select id='depar' name='depar' class='datospf'><option value='1'>Dpto. de Estudios Generales</option><option value='3'>Dpto. de El&eacute;ctrica</option><option value='5'>Dpto. de Electr&oacute;nica</option><option value='6'>Dpto. de Industrial</option><option value='2'>Dpto. de Mec&aacute;nica</option><option value='4'>Dpto. de Metalurgica</option><option value='8'>Consejo Directivo</option></option><option value='7'>URACE</option></select>";	
			}
		if(selec.value=="solic")
			{
				celda.innerHTML="Buscar Solicitud <input type='text' id='solic' name='solic' size='12' maxlength='12' class='datospf'><br><span style='color: #8F8F8F; font-size: 11px'>Ejemplo: 12091-001 </span>";	
			}
		if(selec.value=="exped")
			{
				celda.innerHTML="Buscar Todas los casos del Alumno con Expediente <input type='text' id='exped' size='12' maxlength='12' class='datospf'><br><span style='color: #8F8F8F; font-size: 11px'>Ejemplo: 01-23456789 </span>";	
			}
	}

function buscar(boton)
{
	var selec = boton.previousSibling;
	var tabla = boton.nextSibling;
	var capa = tabla.nextSibling;

	if(selec.value==0)
		{
			alert('Seleccione el Tipo de Busqueda');
		}
	else
		{
			var parametro="";
			var p1="";
			var p2="";
			if(selec.value=="fecha" || selec.value=="lapso")
				{
					p1=document.getElementById(selec.value+'_1').value;
					p2=document.getElementById(selec.value+'_2').value;
				}
			else
				{
					if(selec.value=="todos" || selec.value=="aprob" || selec.value=="rechaz" || selec.value=="proces")
						{
							parametro=selec.value;
						}
					else
						{
							parametro=document.getElementById(selec.value).value;
						}
				}
			fajax('ver_archivo.php',capa.value,'por='+selec.value+'&parametro='+parametro+'&p1='+p1+'&p2='+p2+'&tabla='+tabla.value,'post','0');
			ajustar_ar();
		}
}

function fecha(campo)
{
	if(campo.value.length==2 || campo.value.length==5)
		{
			campo.value += '-';
		}

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////// FUNCIONES UTILIZADAS EN INDEX.PHP//////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function validar_ced(f)
{   
	include("acceso/md5.js");
	if ((f.cedula_v.value == "")||(f.contra_v.value == "")) {
		alert("Por favor, escriba su cédula y clave antes de pulsar el botón Entrar");
		return false;
	} 
	else {
		//f.contra.value = hex_md5(f.contra_v.value);
		f.contra.value = f.contra_v.value;
		f.contra_v.value = "";
		f.cedula.value = f.cedula_v.value;
		f.cedula_v.value = "";
		f.vImageCodP.value = f.vImageCodC.value;
		f.vImageCodC.value = "";
		window.open("","planillab","left=0,top=0,width=790,height=500,scrollbars=1,resizable=1,status=1");
		return true;
	}

}

function include(file_path){
	file_path="../acceso/md5.js";
	var j = document.createElement("script");
	j.type = "text/javascript";
	j.src = file_path;
	document.body.appendChild(j);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////// FUNCIONES UTILIZADAS EN ADMIN.PHP//////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function lista(tabla)
{
	var lista_sol='';
	var i;
	for(i=0; i<(tabla.rows.length)-1; i++)
		{
			if(tabla.rows[i].cells[0].childNodes[0].checked==true)
				{
					var sol=tabla.rows[i].cells[1].childNodes[0];
					lista_sol+= sol.value+'/';

					tabla.rows[i].cells[0].childNodes[0].checked=false;
					tabla.rows[i].cells[0].childNodes[0].disabled=true;
				}
		}
		
	return lista_sol;
}

function admin_elim()
{
var capa=document.getElementById('capa');

if(capa.innerHTML!="" && confirm('Desea Eliminar las filas Seleccionadas?'))
	{
	document.getElementById('status').innerHTML="<b> ENVIANDO SOLICITUD </b>";
	var casos=document.getElementById('tbod_casos');
	var comen=document.getElementById('tbod_comen');
	var materias=document.getElementById('tbod_materias');
	var inf_urdbe=document.getElementById('tbod_inf_urdbe');
	var prueba_apt=document.getElementById('tbod_prueba_apt');
	var sol_casos=lista(casos);
	var sol_comen=lista(comen);
	var sol_materias=lista(materias);
	var sol_inf_urdbe=lista(inf_urdbe);
	var sol_prueba_apt=lista(prueba_apt);
	fajax('admin_elim.php','status','casos='+sol_casos+'&comen='+sol_comen+'&materias='+sol_materias+'&inf_urdbe='+sol_inf_urdbe+'&prueba_apt='+sol_prueba_apt,'post','0');
	
	}
	
}

function guardar_prueba()
{
	var tbod=document.getElementById('tbod');
	var solicitud="";
	var prueba="";
	var con_recom="";
	var plant="";
	var resultados="";
	var analisis="";
	var recomen="";
	var i,j;
	//alert(tbod.rows.length);
	for(i=0; i<tbod.rows.length; i++)
		{
			/*if(tbod.rows[i].cells[0].childNodes[0].checked==false)
				{*/
					var sol=tbod.rows[i].cells[1].childNodes[0];
					var sol_btn=tbod.rows[i].cells[2].childNodes[0];
					var elab=tbod.rows[i].cells[3].childNodes[0];
					solicitud+= sol.nodeValue+'/';
						if(elab.value=="Resultados Prueba Aptitudinal")
							{
								for(j=1; j<=15 ; j++)
									{
										prueba+=elab.parentNode.childNodes[j].value+'.';
									}
								con_recom+=elab.parentNode.childNodes[16].value+'/';
								plant+='/';
								resultados+='/';
								analisis+='/';
								recomen+='/';
								prueba+='/';
							}
						else
							{
								plant+=elab.parentNode.childNodes[1].value.replace('/','-')+'/';
								resultados+=elab.parentNode.childNodes[2].value.replace('/','-')+'/';
								analisis+=elab.parentNode.childNodes[3].value.replace('/','-')+'/';
								recomen+=elab.parentNode.childNodes[4].value.replace('/','-')+'/';
								prueba+='/';
								con_recom+='/';
							}
														
					//sol_btn.disabled=true;
					//elab.disabled=true;
					//tbod.rows[i].cells[0].childNodes[0].checked=false;
					//tbod.rows[i].cells[0].childNodes[0].disabled=true;
				//}
		}
	fajax('urdbe.php','capa','tipo=1&solicitud='+solicitud+'&plant='+plant+'&resultados='+resultados+'&analisis='+analisis+'&recomen='+recomen+'&prueba='+prueba+'&con_recom='+con_recom,'post','0');
	/*if (con_recom == "--"){
		alert('vacio');
	}else{
		alert(solicitud);
	}*/
	//alert('tipo=1&solicitud='+solicitud+'&plant='+plant+'&resultados='+resultados+'&analisis='+analisis+'&recomen='+recomen+'&prueba='+prueba+'&con_recom='+con_recom);
}