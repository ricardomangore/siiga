var x;
x=$(document);
x.ready(inicializarEventos);

function inicializarEventos()
{
  var x;
  $.ajax({cache: false});

   if($("#Vista").attr("value")=='Lista')
   	  DisplayBotones(3);
  else
  	  DisplayBotones(1);

  $("#Calcular1").live('click',calculaEsquema1);
  $("#Calcular2").live('click',calculaEsquema2);
  $("#Calcular3").live('click',calculaEsquema3);
  $("#Calcular4").live('click',calculaEsquema4);
  $("#Calcular5").live('click',calculaComparativo);
  $("#Calcular6").live('click',calculoEsquemaTp1);
  $("#Calcular7").live('click',calculoEsquemaTp2);
  $("#Calcular8").live('click',calculaEsquema5);


  if (typeof $("#b1") != "undefined")
  {
  	$("#a1").focus();
  	$("#b1").focus();
  }
  if (typeof $("#a1") != "undefined")
 {
  	$("#a1").focus();
  	$("#a1").focus();
  }

  $(".venta").keydown(function(e){

  	if(e.which==13)
	{

  	switch($(this).attr("id"))
  		{
  			case 'a1':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '50':
  							calculaEsquema2();
  						break;
  						case '51':
  							calculaEsquema3();
  						break;
  						case '52':
  							calculaEsquema4();
  						break;
              case '57':
                calculaEsquema5();
              break;
  					}
  					if($("#a2").attr("value")=='0')
  					$("#a2").val("");
  					$("#a2").focus();

  			break;
  			case 'a2':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '50':
  							calculaEsquema2();
  						break;
  						case '51':
  							calculaEsquema3();
  						break;
  						case '52':
  							calculaEsquema4();
  						break;
              case '57':
                calculaEsquema5();
              break;

  					}
  					if($("#a3").attr("value")=='0')
  					$("#a3").val("");
  					$("#a3").focus();
  			break;
  			case 'a3':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '50':
  							calculaEsquema2();
  						break;
  						case '51':
  							calculaEsquema3();
  						break;
  						case '52':
  							calculaEsquema4();
  						break;
              case '57':
                calculaEsquema5();
              break;

  					}
  					if($("#a4").attr("value")=='0')
  					$("#a4").val("");
  					$("#a4").focus();
  			break;
  			case 'a4':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '50':
  							calculaEsquema2();
  						break;
  						case '51':
  							calculaEsquema3();
  						break;
  						case '52':
  							calculaEsquema4();
  						break;
              case '57':
                calculaEsquema5();
                if($("#b1").attr("value")=='0')
                $("#b1").val("");
                $("#b1").focus();
              break;

  					}
  			break;
  			case 'b1':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '49':
  							calculaEsquema1();
  						break;
  						case '53':
  							calculaComparativo();
  						break;
              case '54':
                calculoEsquemaTp1();
              break;
              case '55':
                calculoEsquemaTp2();
              break;
              case '57':
                calculaEsquema5();
                if($("#b2").attr("value")=='0')
                $("#b2").val("");
                $("#b2").focus();
              break;
  					}
  					if($("#c1").attr("value")=='0')
  					$("#c1").val("");
  					$("#c1").focus();

  			break;
  			case 'b2':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '49':
  							calculaEsquema1();
  						break;
  						case '53':
  							calculaComparativo();
  						break;
              case '54':
                calculoEsquemaTp1();
              break;
              case '55':
                calculoEsquemaTp2();
              break;
              case '57':
                calculaEsquema5();
                if($("#b3").attr("value")=='0')
                $("#b3").val("");
                $("#b3").focus();

  					}
  					if($("#c2").attr("value")=='0')
  					$("#c2").val("");
	  				$("#c2").focus();
  			break
  			case 'b3':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '49':
  							calculaEsquema1();
  						break;
  						case '53':
  							calculaComparativo();
  						break;
              case '54':
                calculoEsquemaTp1();
              break;
              case '55':
                calculoEsquemaTp2();
              break;
              case '57':
                calculaEsquema5();
                if($("#b4").attr("value")=='0')
                $("#b4").val("");
                $("#b4").focus();

  					}
  					if($("#c3").attr("value")=='0')
  					$("#c3").val("");
	  				$("#c3").focus();
  			break;
  			case 'b4':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '49':
  							calculaEsquema1();
  						break;
  						case '53':
  							calculaComparativo();
  						break;
              case '54':
                calculoEsquemaTp1();
              break;
              case '55':
                calculoEsquemaTp2();
              break;

  					}
  					if($("#c4").attr("value")=='0')
  					$("#c4").val("");
				 	$("#c4").focus();
  			break;
  			case 'c1':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '49':
  							calculaEsquema1();
  						break;
  						case '53':
  							calculaComparativo();
  						break;
              case '54':
                calculoEsquemaTp1();
              break;
              case '55':
                calculoEsquemaTp2();
              break;

  					}
  					if($("#b2").attr("value")=='0')
  					$("#b2").val("");
  					$("#b2").focus();
  			break;
  			case 'c2':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '49':
  							calculaEsquema1();
  						break;
  						case '53':
  							calculaComparativo();
  						break;
              case '54':
                calculoEsquemaTp1();
              break;
              case '55':
                calculoEsquemaTp2();
              break;

  					}
  					if($("#b3").attr("value")=='0')
  					$("#b3").val("");
  					$("#b3").focus();
  			break;
  			case 'c3':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '49':
  							calculaEsquema1();
  						break;
  						case '53':
  							calculaComparativo();
  						break;
              case '54':
                calculoEsquemaTp1();
              break;
              case '55':
                calculoEsquemaTp2();
              break;

  					}
  					if($("#b4").attr("value")=='0')
  					$("#b4").val("");
  					$("#b4").focus();

  			break;
  			case 'c4':
  					switch($("#ModuloId").attr("value"))
  					{
  						case '49':
  							calculaEsquema1();
  						break;
  						case '53':
  							calculaComparativo();
  						break;
              case '54':
                calculoEsquemaTp1();
              break;
              case '55':
                calculoEsquemaTp2();
              break;

  					}
  			break;


  		}
  	}
  });

  $("#lista").click(BtLista);
  $("#formulario").click(BtFormulario);
  $("#guardar").click(BtGuardar);
  $("#actualizar").click(BtActualizar);
  $("#LiberaSerie").click(LiberaSerie);
  $("#FechaRecepcion").click(CambiaFechaRecepcion);
  $("#Desbloquear").click(DesbloquearSerieTraspaso);
  $("#DesbloquearCancelados").click(DesbloquearCancelados);
  $("#LiberaRecepcion").click(DesbloquearLecturaRecepcion);
  $("#nuevo").click(BtNuevo);
  $("#cancelar").click(BtCancelar);
  $("#borrar").click(BtBorrar);
  $("#ConceptoTr").click(BtConceptoTR);
  $("#activar").click(BtActivar);
  $("#editar").click(BtEditar);
  $("#seleccionar").click(BtSeleccionar);
  $("#photo").live('click',CargaPhoto);
  $("#PuntoVenta").live('click',ventana);
  $("#PuntoVentaB").live('click',ventana);
  $("#PuntoVentaEdit").live('click',ventana);
  $("#PuntoVentaO").click(ventana);
  $("#PuntoVentaOrigen").click(ventana);
  $("#PuntoVentaD").click(ventana);
  $("#Vendedor").live('click',ventana);
  $("#Empleado").live('click',ventana);
  $("#MiPlaza").live('click',ventana);
  $("#validar").live('click',BtValidar);
  $("#Coordinador").live('click',ventana);
  $("#Crear").click(BtCrearReferencia);
  $("#CrearCl").click(BtCrearCliente);
  $("#Nombre").live('click',ventana);
  $("#AddReferencia").click(ventana);
  $("#Equipo").click(ventana);
  $("#Plan").click(ventana);
  $("#AddAddon").click(ventana);
  $("#AddServ").click(ventana);
  $("#AddCliente").live('click',ventana);
  $("#ODC").live('click',ventana);
  $("#AddUniforme").live('click',agregaUniforme);
  $("#BCliente").live('click',ventana);
  $("#AddLinea").click(AgregaLinea);
  $("#AddLineaOr").click(AgregaLineaOr);
  $("#Lectura").keydown(ProcesaLectura);
  $("#codigo_sim").keydown(ProcesaLecturaSIM);
  
  $("#Lectura2").keydown(AgregaLectura);
  $("#Lectura3").keydown(LecturaTraspaso);
  $("#Lectura4").keydown(BuscarDisponible);
  $("#Lectura5").keydown(InventarioFisico);
  $("#BuscarObj").keydown(getListaClientesbase);
  $("#LecturaOdc").keydown(AgregaLecturaOdc);
  $("#Lectura6").keydown(LecturaTraspasoEntrada);
  $("#siguiente").live('click',pasoNext);
  $("#anterior").live('click',pasoLast);
  $("#CreaUsuario").click(CrearUsuario);
  $("#Reingresar").click(ReingresarPersonal);
  $("#Edit").live('click',editaColonia);

  $("#ActualizaFolio").live('click',ActualizaHFolios);

  if($("#ModuloId").attr("value")==41)
  $("#EstatusId").change(
  						function()
  						{
  						if($("#EstatusId").attr("value")=="1")
  						$("#FechaInstalacion").val("");
  						else
  						$("#FechaInstalacion").val("00-00-0000");
						});


  $("#CodAcc").keydown(ProcesaLecturaAcc);
  $("#Efectivo").blur(calculaMontosAcc);

  $("#CodTP").click(ventana);
  $("#Usuario").click(ventana);

  $("#SavePhoto").click(GuardarFoto);

  if (typeof $("#Lectura5") != "undefined")
  	$("#Lectura5").focus();

  if (typeof $("#Lectura4") != "undefined")
  	$("#Lectura4").focus();

  if (typeof $("#Lectura3") != "undefined")
  	$("#Lectura3").focus();

  if (typeof $("#Lectura2") != "undefined")
  	$("#Lectura2").focus();

  if (typeof $("#Lectura") != "undefined")
  	$("#Lectura").focus();

}

function getListaClientesbase(e)
{
$("#Customer").html("<br><br>Obteniendo Informacion...");
	if(e.which==13)
	{
		if($("#BuscarObj").attr("value")=="")
		{
		alert("Debes ingresar el nombre del Cliente");
		return false
		}
		var v1=$("#BuscarObj").attr("value");
		var res=$.post("Acciones.php",{NombreCliente:v1, modulo:24, opc:8},
						function( data ) {
  											$("#Customer").html(data);
					  					 }
					  );
		$("#Lectura5").val('');
	}
}

function InventarioFisico(e)
{
$("#resultados").html("");
	if(e.which==13)
	{
		if($("#Lectura5").attr("value")=="")
		{
		alert("Debes ingresar el numero de Serie");
		return false
		}

		var v1=$("#Lectura5").attr("value");
		var v2=$("#PuntoVentaId").attr("value");
		var res=$.post("Acciones.php",{Lectura5:v1, PuntoVentaId:v2, modulo:33, opc:1}, getLineasVU);
		$("#Lectura5").val('');
	}
}

function GuardarFoto()
{
	var v1=$("#EmpleadoId").attr("value");
	var res=$.post("Acciones.php",{EmpleadoId:v1, modulo:10, opc:5}, getRespuesta);
}

function BuscarDisponible(e)
{
$("#resultados").html("");
	if(e.which==13)
	{
		if($("#Lectura4").attr("value")=="")
		{
		alert("Debes ingresar el numero de Serie");
		return false
		}

		$("#foo").submit();
	}
}


function AgregaLectura(e)
{
$("#resultados").html("");
	if(e.which==13)
	{
		if($("#EquipoId").attr("value")=="0")
		{
		alert("Debes ingresar el Equipo");
		return false
		}

		if($("#Lectura2").attr("value")=="")
		{
		alert("Debes ingresar el numero de Serie");
		return false
		}

		existeCodigo();
	}
}

function LecturaTraspaso(e)
{
	$("#resultados").html("");
	if(e.which==13)
	{
		if($("#Lectura3").attr("value")=="")
		{
		alert("Debes ingresar el numero de Serie");
		return false
		}

		if($("#PuntoVentaIdO").attr("value")==0)
		{
		alert("Debes elegir el punto de venta Origen");
		return false;
		}

		if($("#PuntoVentaD").attr("value")==0)
		{
		alert("Debes elegir el punto de venta Destino");
		return false;
		}
		existeSerieTraspaso();
	}
}

function LecturaTraspasoEntrada(e)
{
	$("#resultados").html("");
	if(e.which==13)
	{
		if($("#Lectura6").attr("value")=="")
		{
		alert("Debes ingresar el numero de Serie");
		return false
		}

		if($("#Odt").attr("value")=="")
		{
		alert("Debes elegir el punto de venta Origen");
		return false;
		}
		var v1=$("#Lectura6").attr("value");
		var v2=$("#Odt").attr("value");
		var v3=$("#Clave").attr("value");
		var res=$.post("Acciones.php",{Lectura6:v1, Odt:v2, clave:v3, modulo:29, opc:1},
						function (datos)
							{
								if(datos=='FAIL')
									$("#resultados").html(utf8_decode('<span class="alerta">¡Esta serie No existe en la orden de traspaso!</span>'));
								else
									$.post("Acciones.php",{Clave:v3, Lectura3:v1, Cantidad:1, modulo:30, opc:3},getLineasVU);

								$("#Lectura6").val("");

							});
	}
}



function existeSerieTraspaso()
{
	var v1=$("#Lectura3").attr("value");
	var v2=$("#PuntoVentaIdO").attr("value");
	var res=$.post("Acciones.php",{Lectura3:v1, PuntoVentaIdO:v2, modulo:30, opc:2}, validaLectura);
}

function existeCodigo()
{
	var v1=$("#Lectura2").attr("value");
	var res=$.post("Acciones.php",{Lectura2:v1, modulo:23, opc:2}, validaLectura);
}

function AgregaLecturaOdc(e)
{
$("#resultados").html("");
	if(e.which==13)
	{
		if($("#ODC").attr("value")=="")
		{
		alert("Debes elegir la Factura");
		return false
		}

		var v1=$("#LecturaOdc").attr("value");
		var v2=$("#ODC").attr("value");
		var v3=$("#Clave").attr("value");
		var res=$.post("Acciones.php",{LecturaOdc:v1, Factura:v2, Clave:v3, modulo:46, opc:1}, validaLecturaOdc);
	}
}

function validaLecturaOdc(datos)
{
	if(datos=='Existe')
	{
		$("#resultados").html(utf8_decode('<span class="alerta">¡Este numero de serie ya fue leido!</span>'));
		$("#LecturaOdc").val("");
	}
	else
	if(datos=='Invalido')
	{
		$("#resultados").html(utf8_decode('<span class="alerta">¡Este numero de serie no se encuentra en la Factura!</span>'));
		$("#LecturaOdc").val("");
	}
	else
	{
		$("#displayLineas").html(datos);
		if (typeof $("#Cantidad") != "undefined" & typeof $("#NoLineas") != "undefined")
			$("#Cantidad").val($("#NoLineas").attr("value"));
		$("#LecturaOdc").val("");
	}
}

function validaLectura(datos)
{
	if(datos=='Existe')
	{
		$("#resultados").html(utf8_decode('<span class="alerta">¡Este numero de serie ya existe!</span>'));
		$("#Lectura2").val("");
	}

	if(datos=='Disponible')
	{
		$("#resultados").html(utf8_decode('<span class="alerta">¡Este numero de serie no esta disponible!</span>'));
		$("#Lectura3").val("");
	}

	if(datos=='NoExiste')
	{
		$("#resultados").html(utf8_decode('<span class="alerta">¡Este numero de serie no se encuentra en el almacen!</span>'));
		$("#Lectura3").val("");
	}

	if(datos=='Recibe')
	{
		var v1=$("#Clave").attr("value");
		var v2=$("#EquipoId").attr("value");
		var v3=$("#Lectura2").attr("value");
		$.post("Acciones.php",{Clave:v1, EquipoId:v2, Lectura2:v3, modulo:23, opc:3},getLineasVU);
		$("#Lectura2").val("");
	}

	if(datos=='TExpress')
	{
		var v1=$("#Clave").attr("value");
		var v2=$("#Lectura3").attr("value");
		var v3=$("#CantidadUnidad").attr("value");
		var v4=$("#ModuloId").attr("value");

		$.post("Acciones.php",{Clave:v1, Lectura3:v2, Cantidad:0, modulo:30, opc:3},getLineasVU);
		$("#Lectura3").val("");
	}
}

function AgregaLinea()
{

	if($("#EquipoId").attr("value")=="0")
	{
	alert("Debes ingresar el Equipo");
	return false
	}

	if($("#PlanId").attr("value")=="0")
	{
	alert("Debes ingresar el Plan");
	return false
	}

  if($("#AddOnes").attr("value")=="")
  {
    alert("Debes elegir al menos un AddOn")
    return false
  }

	if($("#PlazoId").attr("value")=="0")
	{
	alert("Debes elegir el Plazo");
	return false
	}

 	if($("#ModuloId").attr("value")=="26")
	if($("#Contrato").attr("value")=="")
	{
	alert("Debes ingresar el numero de contrato");
	return false
	}

var v1=$("#Clave").attr("value");
var v2=$("#EquipoId").attr("value");
var v3=$("#PlanId").attr("value");
var v4=$("#TipoPlanId").attr("value");
var v5=$("#AddOnes").attr("value")+'0';
var v6=$("#OtrosServ").attr("value")+'0';
var v7=$("#PlazoId").attr("value");
var v8=$("#Contrato").attr("value");
var v9=$("#ComentarioL").attr("value");


	$.post("Acciones.php",{Clave:v1, EquipoId:v2, PlanId:v3, TipoPlanId:v4, AddOnes:v5, OtrosServ:v6, PlazoId:v7, Contrato:v8, ComentarioL:v9, modulo:22, opc:3},getLineasVU);

	$("#EquipoId").val("0");
	$("#PlanId").val("0");
	$("#TipoPlanId").val("0");
	$("#AddOnes").val("");
	$("#OtrosServ").val("");
	$("#PlazoId").val("0");
	$("#Equipo").val("");
	$("#Plan").val("");
	if($("#ModuloId").attr("value")=="26")
	$("#Contrato").val("");
    $(".Pt").closest('#checks').find('input[type=checkbox]').attr('checked', false);
}


function ventana()
{

	var obj
	var w=500;
	var h=300;

	switch ($(this).attr("id"))
	{
		case 'Empleado':
       	     obj=$("#Empleados")
       	      w=800;
			  h=600;
		break;

		case 'PuntoVenta':
       	     obj=$("#PuntosVenta")
       	      w=800;
			  h=600;
		break;
    case 'PuntoVentaB':
             obj=$("#PuntosVentaB")
              w=800;
        h=600;
    break;

		case 'PuntoVentaEdit':
       	     obj=$("#PuntosVenta")
       	      w=800;
			  h=600;
		break;


		case 'BCliente':
       	     obj=$("#MisClientes")
       	      w=800;
			  h=650;
		break;

		case 'CodTP':
       	     obj=$("#Productos")
       	      w=800;
			  h=650;
		break;

		case 'PuntoVentaO':

		if($("#Cantidad").attr("value")!='0')
		{
			alert ("No es posible cambiar esta campo despues de iniciar la lectura");
			return false;
		}
		$(".Pt").attr('checked', false);
			$("#Campo").val(1);
       	     obj=$("#PuntosVenta")
       	      w=800;
			  h=600;

		break;

		case 'PuntoVentaD':

		if($("#Cantidad").attr("value")!='0')
		{
			alert ("No es posible cambiar esta campo despues de iniciar la lectura");
			return false;
		}
		$(".Pt").attr('checked', false);

			$("#Campo").val(2);
       	     obj=$("#PuntosVenta")
       	      w=800;
			  h=600;
		break;

		case 'PuntoVentaOrigen':
			if($("#Cantidad").attr("value")!='0')
			{
				alert ("No es posible cambiar esta campo despues de iniciar la lectura");
				return false;
			}
       	     obj=$("#OrdenTraspaso")
       	      w=600;
			  h=400;
		break;

		case 'Vendedor':
       	     obj=$("#Vendedores")
       	      w=800;
			  h=600;
		break;
    case 'Usuario':
             obj=$("#Usuarios")
              w=800;
        h=600;
    break;

		case 'AddReferencia':
       	     obj=$("#NReferencia")
		break;

		case 'AddServ':
       	     obj=$("#SAdicional")
		break;

		case 'AddAddon':
       	     obj=$("#AddOn")
		break;

		case 'Equipo':
       	     obj=$("#Equipos")
		break;

		case 'ODC':
			if($(this).attr("value")!="")
			{
				alert("No puedes cambiar de Factura. Si deseas elegir otra, presiona Nuevo")
				return false;
			}
       	     obj=$("#Ordenes")
		break;

		case 'Plan':
       	    	        obj=$("#Planes")
		        w=800;
		        h=500;
		break;

		case 'Nombre':
       	     obj=$("#Clientes")
		break;

		case 'AddCliente':
			  obj=$("#ClientesNuevos")
			  w=800;
			  h=600;
		break;

		case 'Coordinador':
       	     obj=$("#Coordinaciones")
       	      w=800;
			  h=600;
		break;
	}

	obj.dialog({width: w,
				height: h,
				show: "scale",
				hide: "scale",
				resizable: "false",
				position: "center",
				modal: "true"
	});
}

function VentanaBaja()
{

	var w=500;
	var h=300;

	$("#Baja").dialog({
						width: w,
						height: h,
						show: "scale",
						hide: "scale",
						resizable: "false",
						position: "center",
						modal: "true"
					});
}

function VentanaReingreso()
{

  var w=700;
  var h=500;

  $("#Activa").dialog({
            width: w,
            height: h,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
}


function VentanaConceptoTR()
{

  var w=500;
  var h=300;

  $("#ConceptoTR").dialog({
            width: w,
            height: h,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
}

function DisplayBotones(v1)
{

	switch(v1)
	{
		case 1:
				$("#formulario").hide();
				$("#editar").hide();
				$("#borrar").hide();
				$("#activar").hide();
				$("#lista").show();
				$("#nuevo").show();
				$("#guardar").show();
				$("#actualizar").hide();
				$("#cancelar").show();
				$("#validar").hide();
        $("#ConceptoTr").hide();
		break;
		case 2:

				$("#formulario").hide();
				$("#editar").hide();
				$("#borrar").hide();
				$("#activar").hide();
				$("#lista").show();
				$("#nuevo").show();
				$("#guardar").hide();
				$("#actualizar").show();
				$("#cancelar").show();
				$("#validar").show();
        $("#ConceptoTr").hide();
		break;
		case 3:
				$("#lista").hide();
				$("#formulario").show();
				$("#nuevo").show();
				$("#guardar").hide();
				$("#actualizar").hide();
				$("#editar").show();
				$("#borrar").show();
				$("#activar").show();
				$("#cancelar").show();
				$("#validar").hide();
        $("#ConceptoTr").show();

		break;
	}

}
function BtCrearCliente()
{
	if($("#TipoPersonaId").attr("value")=="0")
	{
	alert("Debes elegir el tipo de persona");
	return false
	}

	if($("#NombreC").attr("value")=="")
	{
	alert("Debes ingresar el nombre del cliente");
	return false
	}

	if($("#PaternoC").attr("value")=="")
	{
	alert("Debes ingresar el apellido paterno del cliente");
	return false
	}

	if($("#MaternoC").attr("value")=="0")
	{
	alert("Debes ingresar el apellido materno del cliente");
	return false
	}

	if($("#RFCC").attr("value")=="")
	{
	alert("Debes ingresar el RFC del cliente");
	return false
	}

	if($("#Calle").attr("value")=="")
	{
	alert("Debes ingresar la Calle");
	return false
	}

	if($("#NExterior").attr("value")=="")
	{
	alert("Debes ingresar el numero exterior");
	return false
	}

	if($("#NInterior").attr("value")=="")
	{
	alert("Debes ingresar el numero interior");
	return false
	}

	if($("#Cp").attr("value")=="")
	{
	alert("Debes ingresar el codigo postal");
	return false
	}

	if($("#ColoniaId").attr("value")=="0")
	{
	alert("Debes elegir la colonia");
	return false
	}

	if($("#TLocal").attr("value")=="")
	{
	alert("Debes ingresar el telefono local");
	return false
	}

	if($("#TMovil").attr("value")=="")
	{
	alert("Debes ingresar el telefono movil");
	return false
	}



var v1=$("#TipoPersonaId").attr("value");
var v2=$("#NombreC").attr("value");
var v3=$("#PaternoC").attr("value");
var v4=$("#MaternoC").attr("value");
var v5=$("#RFCC").attr("value");
var v15=$("#Calle").attr("value");
var v16=$("#NExterior").attr("value");
var v17=$("#NInterior").attr("value");
var v18=$("#ColoniaId").attr("value");
var v19=$("#TLocal").attr("value");
var v20=$("#TMovil").attr("value");

if($("#NombreCT").attr("value")=="")
	var v21=" ";
else
	var v21=$("#NombreCT").attr("value");

if($("#PaternoCT").attr("value")=="")
	var v22=" ";
else
	var v22=$("#PaternoCT").attr("value");

if($("#MaternoCT").attr("value")=="")
	var v23=" ";
else
	var v23=$("#MaternoCT").attr("value");



$.post("Acciones.php",{TipoPersonaId:v1, NombreC:v2, PaternoC:v3, MaternoC:v4, RFCC:v5, Calle:v15, NExterior:v16, NInterior:v17,
	ColoniaId:v18, TLocal:v19, TMovil:v20, NombreCT:v21, PaternoCT:v22, MaternoCT:v23, modulo:22, opc:2},getClienteId);

}

function BtCrearReferencia()
{

	if($("#ParentescoReferenciaId").attr("value")=="0")
	{
	alert("Debes elegir el parentesco de la referencia");
	return false
	}

	if($("#NombreR").attr("value")=="")
	{
	alert("Debes ingresar el nombre de la referencia");
	return false
	}

	if($("#PaternoR").attr("value")=="")
	{
	alert("Debes ingresar el apellido paterno de la referencia");
	return false
	}

	if($("#MaternoR").attr("value")=="")
	{
	alert("Debes ingresar el apellido materno de la referencia");
	return false
	}

	if($("#TelefonoR").attr("value")=="")
	{
	alert("Debes ingresar el telefono de la referencia");
	return false
	}

var v1=$("#Clave").attr("value");
var v2=$("#ParentescoReferenciaId").attr("value");
var v3=$("#NombreR").attr("value");
var v4=$("#PaternoR").attr("value");
var v5=$("#MaternoR").attr("value");
var v6=$("#TelefonoR").attr("value");
var v7=$("#MailR").attr("value");

	$.post("Acciones.php",{Clave:v1, ParentescoId:v2, NombreR:v3, PaternoR:v4, MaternoR:v5, TelefonoR:v6, MailR:v7, modulo:22, opc:1},getRespuestaVU);

	$("#ParentescoReferenciaId").val("0");
	$("#NombreR").val("");
	$("#PaternoR").val("");
	$("#MaternoR").val("");
	$("#TelefonoR").val("");
	$("#MailR").val("");
	$("#NReferencia").dialog("close");



}

function BtSeleccionar()
{
  $(".dialogo").dialog( "close" );
}

function ValidaDatos()
{
	var modulo=$("#ModuloId").attr("value");

	switch(modulo)
	{
		case '0':
				return true;
				break;
		case '64':
				return true;
				break;
    case '1':
        if($("#TituloAviso").attr("value")=="")
        {
        alert("Debes ingresar el titulo del aviso");
        return false
        }

        if($("#Aviso").attr("value")=="")
        {
        alert("Debes ingresar la descripcion del aviso");
        return false
        }

        if($("#ClasificacioAvisoId").attr("value")=="0")
        {
        alert("Debes elegir la calsificacion del aviso");
        return false
        }

        if($("#FileImport").attr("value")=="")
        {
        alert("Debes adjuntar el documento Aviso");
        return false
        }

        if($("#FechaInicio").attr("value")=="")
        {
        alert("Debes elegir la fecha de inicio de Publicacion");
        return false
        }

        if($("#FechaFin").attr("value")=="")
        {
        alert("Debes ingresar la Fecha de Vigencia");
        return false
        }

        return true;
        break;
		case '10':
				if($("#Nombre").attr("value")=="")
				{
				alert("Debes ingresar el nombre del Empleado");
				return false
				}

				if($("#Paterno").attr("value")=="")
				{
				alert("Debes ingresar el apellido paterno del Empleado");
				return false
				}

				if($("#Materno").attr("value")=="")
				{
				alert("Debes ingresar el apellido materno del Empleado");
				return false
				}

				if($("#FechaNacimiento").attr("value")=="")
				{
				alert("Debes ingresar la fecha de nacimiento del Empleado");
				return false
				}

				if($("#Curp").attr("value")=="")
				{
				alert("Debes ingresar el CURP del Empleado");
				return false
				}

				if($("#Rfc").attr("value")=="")
				{
				alert("Debes ingresar el RFC del Empleado");
				return false
				}

				if($("#Ife").attr("value")=="")
				{
				alert("Debes ingresar el numero de IFE del Empleado");
				return false
				}

				if($("#Genero").attr("value")=="0")
				{
				alert("Debes elegir el genero del Empleado");
				return false
				}

				if($("#NacionalidadId").attr("value")=="0")
				{
				alert("Debes elegir la Nacionalidad del Empleado");
				return false
				}

				if($("#EscolaridadId").attr("value")=="0")
				{
				alert("Debes elegir la Escolaridad del Empleado");
				return false
				}

				if($("#ProfesionId").attr("value")=="0")
				{
				alert("Debes elegir la Profesion del Empleado");
				return false
				}

				if($("#EstadoCivilId").attr("value")=="")
				{
				alert("Debes elegir el estado civil del Empleado");
				return false
				}

				if($("#Calle").attr("value")=="")
				{
				alert("Debes ingresar la calle del domicilio del Empleado");
				return false
				}

				if($("#NExterior").attr("value")=="")
				{
				alert("Debes ingresar el numero exterior");
				return false
				}

				if($("#NInterior").attr("value")=="")
				{
				alert("Debes ingresar el numero interior");
				return false
				}

				if($("#Cp").attr("value")=="")
				{
				alert("Debes ingresar el codigo postal");
				return false
				}

				if($("#ColoniaId").attr("value")=="0")
				{
				alert("Debes elegir la colonia");
				return false
				}

				if($("#Telefono").attr("value")=="")
				{
				alert("Debes ingresar el telefono de casa del Empleado");
				return false
				}

				if($("#Movil").attr("value")=="")
				{
				alert("Debes ingresar telefono movil del Empleado");
				return false
				}

				if($("#Nss").attr("value")=="")
				{
				alert("Debes ingresar el numero del seguro social del Empleado");
				return false
				}

				if($("#Sangre").attr("value")=="")
				{
				alert("Debes ingresar el tipo sanguineo del Empleado");
				return false
				}

				if($("#DepartamentoId").attr("value")=="0")
				{
				alert("Debes elegir el departamento del Empleado");
				return false
				}

				if($("#ClasificacionPersonalVentaId").attr("value")=="0")
				{
				alert("Debes elegir la clasificacion de venta");
				return false
				}

				if($("#PuestoId").attr("value")=="0")
				{
				alert("Debes elegir el puesto del Empleado");
				return false
				}

				if($("#FechaSolicitudImss").attr("value")=='')
					$("#FechaSolicitudImss").val("0000-00-00");

				if($("#PuestoId").attr("value")==39)
					$("#SueldoF").val("0");

				if($("#PuestoId").attr("value")=="1")
				{
					if($("#SubCategoriaId").attr("value")=="0")
					{
						alert("Debes elegir la Sub Categoria Empleado");
						return false
					}
				}

				if($("#Operador").attr("value")=="")
				{
				alert("Debes ingresar al operador");
				return false
				}

				if($("#Porcentaje").attr("value")=="")
				{
				alert("Debes ingresar el porcentaje");
				return false
				}

				if($("#FechaIngreso").attr("value")=="")
				{
				alert("Debes ingresar la fecha de ingreso");
				return false
				}

				if($("#BancoId").attr("value")=="0")
				{
				alert("Debes elegir el Banco");
				return false
				}

				if($("#Cuenta").attr("value")=="")
				{
				alert("Debes ingresar la cuenta ancaria");
				return false
				}

				if($("#Clabe").attr("value")=="")
				{
				alert("Debes ingresar la clabe interbancaria");
				return false
				}

        if($("#Mail").attr("value")=="")
        {
        alert("Debes ingresar el correo electronico");
        return false
        }

				if($("#CoordinadorId").attr("value")=="0")
				{
				alert("Debes elegir al Jefe Inmediato");
				return false
				}

				if($("#FechaIngresoPunto").attr("value")=="")
				{
				alert("Debes ingresar la fecha de ingreso al punto de venta");
				return false
				}

				if($("#Puntos").attr("value")=="")
				{
				alert("Debes seleccionar al menos un Punto de Venta");
				return false
				}

				if($("#Fisico").attr("value")=="")
				{
				alert("Debes elegir un Punto de Venta como fisico");
				return false
				}


				if($("#SueldoF").attr("value")=="")
				{
				alert("Debes ingresar el S. Fijo");
				return false
				}

        if($("#ReclutadorId").attr("value")=="0")
        {
        alert("Debes elegir el Reclutador");
        return false
        }

				if($("#ParentescoId").attr("value")=="0")
				{
				$("#ParentescoId").val("6");
				}

				if($("#NombreContacto").attr("value")=="")
				{
					$("#NombreContacto").val(" ");
				}

				if($("#CalleContacto").attr("value")=="")
				{
				alert("Debes ingresar la calle del contacto");
				return false
				}

				if($("#NExteriorContacto").attr("value")=="")
				{
				alert("Debes ingresar el numero exterior del contacto");
				return false
				}

				if($("#NInteriorContacto").attr("value")=="")
				{
				alert("Debes ingresar el numero interior del contacto");
				return false
				}

				if($("#CpContacto").attr("value")=="")
				{
				alert("Debes ingresar el codigo postal del empleado");
				return false
				}

				if($("#ColoniaIdContacto").attr("value")==0)
				{
				alert("Debes elegir la colonia");
				return false
				}

				if($("#TelefonoContacto").attr("value")=="")
				{
					$("#TelefonoContacto").val("0");
				}

				if($("#MovilContacto").attr("value")=="")
				{
					$("#MovilContacto").val("0");
				}

				if($("#CorreoElectronico").attr("value")=="")
				{
				alert("Debes ingresar el correoekectronico");
				return false
				}

				return true;

				break;
		case '22':



				if($("#TipoContratacionId").attr("value")=="0")
				{
				alert("Debes elegir el tipo de conrtratacion");
				return false
				}

				if($("#Folio").attr("value")=="")
				{
				alert("Debes Ingresar el Folio");
				return false
				}

        if($("#ClasificacionPersonalVenta").attr("value")==4 || $("#ClasificacionPersonalVenta").attr("value")==6)
        {
          var RegExPattern = /^([a-zA-Z]{3}([0-9]{9})(FP|fp|LIT|lit|NOR|nor|PPL|ppl|PT|pt|AVS|avs))|([a-zA-Z]{3}([0-9]{10})(REN|ren|EXP|exp))|([a-zA-Z]{3}([0-9]{9})(REN|ren|EXP|exp))|([0-9]{4}(F|f))$/;
          if (!$("#Folio").attr("value").match(RegExPattern))
          {
            alert("Folio no Valido.");
            return false;
          }

        }

				if($("#FechaContrato").attr("value")=="")
				{
				alert("Debes Ingresar la fecha de contrato");
				return false
				}


				if($("#TipoPagoId").attr("value")=="0")
				{
				alert("Debes elegir el tipo de pago");
				return false
				}

				if($("#PuntoVentaId").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta");
				return false
				}

				if($("#VendedorId").attr("value")=="0")
				{
				alert("Debes elegir al Ejecutivo de ventas");
				return false
				}

				if($("#CoordinadorId").attr("value")=="0")
				{
				alert("Debes elegir al Coordinado de ventas");
				return false
				}

				if($("#ClienteId").attr("value")=="0")
				{
				alert("Debes elegir el Cliente");
				return false
				}

				if($("#RFC").attr("value")=="")
				{
				alert("Debes ingresar el RFC");
				return false
				}

				if(typeof($('#NoLineas').attr("value")) == "undefined" && $('#NoLineas').attr("value") == null || $('#NoLineas').attr("value")=="0")
				{
				alert("Debes ingresar al menos una linea");
				return false
				}

				 return true;

				break;

		case '23':

				if($("#Factura").attr("value")=="")
				{
				alert("Debes Ingresar el numero de Factura");
				return false
				}


				if($("#PuntoVentaId").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta");
				return false
				}

				if(typeof($('#NoLineas').attr("value")) == "undefined" && $('#NoLineas').attr("value") == null || $('#NoLineas').attr("value")=="0")
				{
				alert("Debes ingresar al menos un articulo");
				return false
				}

				 return true;

				break;


		case '24':

        if($("#PlataformaId").attr("value")=="0")
        {
        alert("Debes elegir la plataforma");
        return false
        }


        if($("#TipoVentaId").attr("value")=="0")
        {
        alert("Debes elegir el tipo de venta");
        return false
        }


				if($("#TipoContratacionId").attr("value")=="0")
				{
				alert("Debes elegir el tipo de conrtratacion");
				return false
				}

				if($("#Folio").attr("value")=="")
				{
				alert("Debes Ingresar el Folio");
				return false
				}

        if($("#PlataformaId").attr("value")=="2")
        {
          var RegExPattern = /^([a-zA-Z]{3}([0-9]{9})(FP|fp|LIT|lit|NOR|nor|PPL|ppl|PT|pt|AVS|avs))|([a-zA-Z]{3}([0-9]{10})(REN|ren|EXP|exp))|([a-zA-Z]{3}([0-9]{9})(REN|ren|EXP|exp))|([0-9]{4}(F|f))$/;
          if (!$("#Folio").attr("value").match(RegExPattern))
          {
            alert("Folio no Valido.");
            return false;
          }

        }

				if($("#FechaContrato").attr("value")=="")
				{
				alert("Debes Ingresar la fecha de contrato");
				return false
				}


				if($("#TipoPagoId").attr("value")=="0")
				{
				alert("Debes elegir el tipo de pago");
				return false
				}

				if($("#PuntoVentaId").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta");
				return false
				}

				if($("#VendedorId").attr("value")=="0")
				{
				alert("Debes elegir al Ejecutivo de ventas");
				return false
				}

				if($("#CoordinadorId").attr("value")=="0")
				{
				alert("Debes elegir al Coordinado de ventas");
				return false
				}

				if($("#ClienteId").attr("value")=="0")
				{
				alert("Debes elegir el Cliente");
				return false
				}

				if($("#RFC").attr("value")=="")
				{
				alert("Debes ingresar el RFC");
				return false
				}

				return true;

				break;

		case '26':

				if($("#TipoContratacionId").attr("value")=="0")
				{
				alert("Debes elegir el tipo de conrtratacion");
				return false;
				}

				if($("#Folio").attr("value")=="")
				{
				alert("Debes Ingresar el Folio");
				return false;
				}

				if($("#TipoPagoId").attr("value")=="0")
				{
				alert("Debes elegir el tipo de pago");
				return false;
				}

				if($("#PuntoVentaId").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta");
				return false;
				}

				if($("#VendedorId").attr("value")=="0")
				{
				alert("Debes elegir al Ejecutivo de ventas");
				return false;
				}

				if($("#CoordinadorId").attr("value")=="0")
				{
				alert("Debes elegir al Coordinado de ventas");
				return false;
				}

				if($("#ClienteId").attr("value")=="0")
				{
				alert("Debes elegir el Cliente");
				return false;
				}

				if($("#RFC").attr("value")=="")
				{
				alert("Debes ingresar el RFC");
				return false;
				}

				if(typeof($('#NoLineas').attr("value")) == "undefined" && $('#NoLineas').attr("value") == null || $('#NoLineas').attr("value")=="0")
				{
				alert("Debes ingresar al menos una linea");
				return false;
				}


				 return true;

				break;

		case '28':
				if($("#PuntoVentaIdO").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta Origen");
				return false;
				}

				if($("#PuntoVentaIdD").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta Destino");
				return false;
				}

				if($("#PuntoVentaIdO").attr("value")==$("#PuntoVentaIdD").attr("value"))
				{
				alert('El punto de venta origen y destino deben de ser diferentes');
				return false;
				}

				if(typeof($('#NoLineas').attr("value")) == "undefined" && $('#NoLineas').attr("value") == null || $('#NoLineas').attr("value")=="0")
				{
				alert("Debes ingresar al menos un articulo");
				return false;
				}

				 return true;

				break;
    case '29':


        if($("#PuntoVentaIdD").attr("value")=="0")
        {
        alert("Debes elegir el Punto de Venta Destino");
        return false;
        }

        if($("#Odt").attr("value")=="0")
        {
        alert("Debes elegir la orden de traspaso");
        return false;
        }

        if(typeof($('#NoLineas').attr("value")) == "undefined" && $('#NoLineas').attr("value") == null || $('#NoLineas').attr("value")=="0")
        {
        alert("Debes ingresar al menos un articulo");
        return false;
        }

         return true;

        break;


		case '30':
				if($("#PuntoVentaIdO").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta Origen");
				return false;
				}

				if($("#PuntoVentaIdD").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta Destino");
				return false;
				}

				if($("#PuntoVentaIdO").attr("value")==$("#PuntoVentaIdD").attr("value"))
				{
				alert('El punto de venta origen y destino deben de ser diferentes');
				return false;
				}

				if(typeof($('#NoLineas').attr("value")) == "undefined" && $('#NoLineas').attr("value") == null || $('#NoLineas').attr("value")=="0")
				{
				alert("Debes ingresar al menos un articulo");
				return false;
				}

				 return true;

				break;

		case '35':

				if($("#Coordinador").attr("value")=="")
				{
				alert("Debes elegir al Coordinador");
				return false
				}
				if($("#Llaves").attr("value")=="")
				{
				alert("Debes elegir al menos un ejecutivo de ventas");
				return false
				}
				return true;
				break;

    case '36':

        if($("#EstatusId").attr("value")=="0")
        {
        alert("Debes elegir el Estatus");
        return false
        }

      if($("#EstatusId").attr("value")=="6" & $("#dateTimeField").attr("value")=="")
        {
        alert("Debes elegir la fecha y hora de la cita");
        return false
        }

        if($("#Comentarios").attr("value")=="")
        {
        alert("Debes ingresar un comentario de estatus");
        return false
        }
        return true;
        break;

		case '38':

				if($("#VendedorId").attr("value")=="0")
				{
				alert("Debes elegir al Vendedor");
				return false
				}
				if($("#Llaves").attr("value")=="")
				{
				alert("Debes elegir al menos un ejecutivo de ventas");
				return false
				}

   			    if($("#CoordinadorId").attr("value")=="0")
				{
				alert("Debes elegir al Coordinado de ventas");
				return false
				}

				if($("#ClienteId").attr("value")=="0")
				{
				alert("Debes elegir el Cliente");
				return false
				}

				if($("#RFC").attr("value")=="")
				{
				alert("Debes ingresar el RFC");
				return false
				}
				if(typeof($('#NoLineas').attr("value")) == "undefined" && $('#NoLineas').attr("value") == null || $('#NoLineas').attr("value")=="0")
				{
				alert("Debes ingresar al menos una linea");
				return false
				}

				if($("#Restante").html()!='$ 0.00')
				{
				alert("Debes ingresar el monto por pagar");
				return false
				}
				 return true;
				break;
		case '40':
				return true;
				break;
		case '41':

				if($("#PuntoVentaId").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta");
				return false
				}
				if($("#Folio").attr("value")=="")
				{
				alert("Debes ingresar el Folio de venta");
				return false
				}
				if($("#PlazoId").attr("value")=="0")
				{
				alert("Debes elegir plazo de contrato");
				return false
				}

				if($("#EstatusId").attr("value")=="0")
				{
				alert("Debes elegir estatus del contrato");
				return false
				}

				if($("#FechaContrato").attr("value")=="")
				{
				alert("Debes elegir la fecha de contratacion");
				return false
				}

				if($("#FechaInstalacion").attr("value")=="")
				{
				alert("Debes elegir la fecha de instalacion");
				return false
				}

				if($("#Pvs").attr("value")=="")
				{
				alert("Debes elegir el numero de PVS");
				return false
				}

				if($("#ClienteId").attr("value")=="0")
				{
				alert("Debes ingresar al Cliente");
				return false
				}

				if($("#VendedorId").attr("value")=="0")
				{
				alert("Debes ingresar al Ejecutivo de Ventas");
				return false
				}

				if($("#CoordinadorId").attr("value")=="0")
				{
				alert("El Vendedor debe estar asignado a un Coordinador");
				return false
				}

				if(typeof($('#NoLineas').attr("value")) == "undefined")
				{
				alert("Debes ingresar al menos un producto");
				return false;
				}

				if($("#NoLineas").attr("value")=="0")
				{
				alert("Debes ingresar al menos un producto");
				return false
				}

				return true;
				break;

		case '43':

				if($("#FechaContrato").attr("value")=="")
				{
				alert("Debes ingresar la fecha de entrega");
				return false
				}

				if($("#EmpleadoId").attr("value")=="0")
				{
				alert("Debes elegir la persona que recibe");
				return false
				}

				if(typeof($('#NoLineas').attr("value")) == "undefined")
				{
				alert("Debes ingresar al menos un producto");
				return false;
				}

				if($("#NoLineas").attr("value")=="0")
				{
				alert("Debes ingresar al menos un uniforme");
				return false
				}

				return true;
				break;
		case '46':

				if($("#Factura").attr("value")=="")
				{
				alert("Debes elegir la Factura");
				return false
				}

				if($("#PuntoVentaId").attr("value")=="0")
				{
				alert("Debes elegir el Punto de Venta");
				return false
				}

				if($("#FileImport").attr("value")=="")
				{
				alert("Debes adjuntar el documento Factura");
				return false
				}


				if(typeof($('#NoLineas').attr("value")) == "undefined" && $('#NoLineas').attr("value") == null || $('#NoLineas').attr("value")=="0")
				{
				alert("Debes ingresar al menos un articulo");
				return false
				}

				 return true;

				break;

    case '59':
        if($("#EstatusId").attr("value")=="0")
        {
        alert("Debes elegir el Estatus");
        return false
        }
      if($("#EstatusId").attr("value")=="6" & $("#dateTimeField").attr("value")=="")
        {
        alert("Debes elegir la fecha y hora de la cita");
        return false
        }
        if($("#Comentarios").attr("value")=="")
        {
        alert("Debes ingresar un comentario de estatus");
        return false
        }
        return true;
        break;
    case '60':
           if($("#TipoPersonaId").attr("value")=="0")
          {
          alert("Debes elegir el tipo de persona");
          return false
          }

          if($("#NombreC").attr("value")=="")
          {
          alert("Debes ingresar el nombre del cliente");
          return false
          }

          if($("#PaternoC").attr("value")=="")
          {
          alert("Debes ingresar el apellido paterno del cliente");
          return false
          }

          if($("#MaternoC").attr("value")=="0")
          {
          alert("Debes ingresar el apellido materno del cliente");
          return false
          }

          if($("#RFCC").attr("value")=="")
          {
          alert("Debes ingresar el RFC del cliente");
          return false
          }

          if($("#Calle").attr("value")=="")
          {
          alert("Debes ingresar la Calle");
          return false
          }

          if($("#NExterior").attr("value")=="")
          {
          alert("Debes ingresar el numero exterior");
          return false
          }

          if($("#NInterior").attr("value")=="")
          {
          alert("Debes ingresar el numero interior");
          return false
          }

          if($("#Cp").attr("value")=="")
          {
          alert("Debes ingresar el codigo postal");
          return false
          }

          if($("#ColoniaId").attr("value")=="0")
          {
          alert("Debes elegir la colonia");
          return false
          }

          if($("#TLocal").attr("value")=="")
          {
          alert("Debes ingresar el telefono local");
          return false
          }

          if($("#TMovil").attr("value")=="")
          {
          alert("Debes ingresar el telefono movil");
          return false
          }

          if($("#FileImportIdentificacion").attr("value")=="")
          {
          alert("Debes adjuntar el documento de Identificacion");
          return false
          }

          if($("#FileImportBuro").attr("value")=="")
          {
          alert("Debes adjuntar el documento de Buro de Credito");
          return false
          }
          return true;
          break;
    case '65':

        if($("#CompaniaId").attr("value")=="0")
        {
        alert("Debes elegir la Compañia");
        return false
        }

        if($("#Folio").attr("value")=="")
        {
        alert("Debes Ingresar el Folio");
        return false
        }

        if($("#NTel").attr("value")=="")
        {
        alert("Debes Ingresar el numero telefonico");
        return false
        }

        if($("#MontoRecargaId").attr("value")=="0")
        {
        alert("Debes elegir el monto de la recarga");
        return false
        }

	if($("#PortabilidadId").attr("value")!=0)
	{
	if($("#NTelP").attr("value")=="")
		{
		alert("Debes ingresar el numero para la portabilidad")
		return false
		}
  if($("#Nip").attr("value")=="")
    {
    alert("Debes ingresar el Nip para la portabilidad")
    return false
    }

  if($("#Nombre").attr("value")=="")
    {
    alert("Debes ingresar el Nombre para la portabilidad")
    return false
    }
  if($("#Paterno").attr("value")=="")
    {
    alert("Debes ingresar el apellido paterno para la portabilidad")
    return false
    }
  if($("#Materno").attr("value")=="")
    {
    alert("Debes ingresar el apellido materno para la portabilidad")
    return false
    }

  if($("#TelContacto").attr("value")=="")
    {
    alert("Debes ingresar el telefono de contacto para la portabilidad")
    return false
    }

  if($("#MailContacto").attr("value")=="")
    {
    alert("Debes ingresar el RFC del cliente para la portabilidad")
    return false
    }

  if($("#FileIfe").attr("value")=="")
    {
    alert("Debes adjuntar identificacion para la portabilidad")
    return false
    }

	}


        if($("#PuntoVentaId").attr("value")=="0")
        {
        alert("Debes elegir el Punto de Venta");
        return false
        }

        if($("#VendedorId").attr("value")=="0")
        {
        alert("Debes elegir al Ejecutivo de ventas");
        return false
        }

        if($("#CoordinadorId").attr("value")=="0")
        {
        alert("Debes elegir al Coordinado de ventas");
        return false
        }

        return true;

        break;

    case '66':

        if($("#TipoDepositoId").attr("value")=="0")
        {
        alert("Debes elegir el tipo de Deposito");
        return false
        }

        if($("#dateTimeField").attr("value")=="")
        {
        alert("Debes Ingresar la fecha y hora del Deposito");
        return false
        }

        if($("#NFicha").attr("value")=="")
        {
        alert("Debes Ingresar el numero de la Ficha");
        return false
        }

        if($("#Monto").attr("value")=="")
        {
        alert("Debes elegir el monto del Deposito");
        return false
        }

        if($("#PuntoVentaId").attr("value")=="0")
        {
        alert("Debes elegir el Punto de Venta");
        return false
        }

        if($("#FileImportFicha").attr("value")=="")
        {
        alert("Debes adjuntar la ficha de deposito");
        return false
        }

        return true;

        break;
      case '68':
                if($("#SeguimientoId").attr("value")=="0")
                {
                alert("Debes elegir al Cliente");
                return false
                }
                if($("#PuntoVentaId").attr("value")=="0")
                {
                alert("Debes elegir el punto de venta");
                return false
                }
          return true;
        break;
      case '70':
                if($("#Folio").attr("value")=="")
                {
                alert("Debes ingresar el folio");
                return false
                }

                if(isNaN($("#Folio").attr("value")))
                {
                alert("Folio no numerico");
                return false

                }

                if($("#Nombre").attr("value")=="")
                {
                alert("Debes ingresar el nombre del Cliente");
                return false
                }

                if($("#Paterno").attr("value")=="")
                {
                alert("Debes ingresar el apellido paterno del Cliente");
                return false
                }

                if($("#Materno").attr("value")=="")
                {
                alert("Debes ingresar el apellido materno del Cliente");
                return false
                }

                if($("#Telefono").attr("value")=="")
                {
                alert("Debes ingresar el telefono del Cliente");
                return false
                }

                if($("#Calle").attr("value")=="")
                {
                alert("Debes ingresar la calle");
                return false
                }

                if($("#NExterior").attr("value")=="")
                {
                alert("Debes ingresar el Numero Exterior");
                return false
                }

                if($("#NInterior").attr("value")=="")
                {
                alert("Debes ingresar el Numero Interior");
                return false
                }

                if($("#ColoniaId").attr("value")=="0" & $("#MiColonia").attr("value")=="")
                {
                alert("Debes ingresar la colonia");
                return false
                }

                if($("#PuntoVentaId").attr("value")=="0")
                {
                alert("Debes elegir el punto de venta");
                return false
                }

                if($("#DescEquipos").attr("value")=="")
                {
                alert("Debes ingresar la descripcion de los equipos");
                return false
                }

                if($("#DescPlanes").attr("value")=="")
                {
                alert("Debes ingresar la descripcion de los planes");
                return false
                }

                if($('#FoEdicion').attr("value")=="0")
                {

                    if($("#FileImportIdentificacion").attr("value")=="")
                    {
                    alert("Debes adjuntar la Identificacion");
                    return false
                    }

                    if($("#FileImportDomicilio").attr("value")=="")
                    {
                    alert("Debes adjuntar el comprobante de domicilio");
                    return false
                    }

                    if($("#FileImportWord").attr("value")=="")
                    {
                    alert("Debes adjuntar el documento de validacion");
                    return false
                    }

                    if($("#FileImportIfe").attr("value")=="")
                    {
                    alert("Debes adjuntar el ife en el punto de venta");
                    return false
                    }

                    if($("#FileImportBuro").attr("value")=="")
                    {
                    alert("Debes adjuntar el documento del Buro de credito");
                    return false
                    }
              }
          return true;
        break;

    	}


  }

function BtEditar()
{
	$("#resultados").html('');
	var claves=$("#Llaves").attr("value");
	var modulo=$("#ModuloId").attr("value");
	var elementos=claves.split(",");
	if (elementos.length>2)
		alert('Debes elegir solo un registro de la tabla');
	else
		if(elementos.length<2)
			alert("Deber elegir un registro de la tabla");
		else
			{
				$("#resultados").html('');
				$("#display").html('<div align="center"><img src="img/loading.gif"/></div>');
				DisplayBotones(2);
				$("#display").load("Display.php?modulo="+modulo+"&opc=2&ObjetoId="+claves);
			}
}

function BtLista()
{
	$("#resultados").html('');
    var v1=$("#ModuloId").attr("value");
	$("#display").html('<div align="center"><img src="img/loading.gif"/></div>');
	DisplayBotones(3);
	$("#display").load("Display.php?modulo="+v1+"&opc=1");
}

function BtFormulario()
{
	$("#resultados").html('');
	var v1=$("#ModuloId").attr("value");
	$("#display").html('<div align="center"><img src="img/loading.gif"/></div>');
	DisplayBotones(1);
	$("#display").load("Display.php?modulo="+v1+"&opc=0");

}

function BtCancelar()
{

	var modulo=$("#ModuloId").attr("value");

	switch(modulo)
	{
		case '0':
				$("#resultados").html("");
				break;
		default:
	  pagina=jQuery(location).attr('href')
    location.href=pagina

				break;
	}

}

function BtNuevo()
{
 if($("#Vista").attr("value")=='Lista')
	BtFormulario();
 	else{
    pagina=jQuery(location).attr('href')
  	location.href=pagina

  }

}

function BtBorrar()
{

	$("#resultados").html('');
	var claves=$("#Llaves").attr("value");
	var modulo=$("#ModuloId").attr("value");
	var elementos=claves.split(",");
	if (elementos.length>2)
		alert('Debes elegir solo un registro de la tabla');
	else
		if(elementos.length<2)
			alert("Deber elegir un registro de la tabla");
		else
			{
				getcampoTabla(6);
				VentanaBaja();

			}
}

function BtConceptoTR()
{

  $("#resultados").html('');
  var claves=$("#Llaves").attr("value");
  var modulo=$("#ModuloId").attr("value");
  var elementos=claves.split(",");
  /*
  if (elementos.length>2)
    alert('Debes elegir solo un registro de la tabla');
  else
  */
    if(elementos.length<2)
      alert("Deber elegir un registro de la tabla");
    else
      {
        VentanaConceptoTR();
      }
}


function BtActivar()
{
  $("#resultados").html('');
  var claves=$("#Llaves").attr("value");
  var modulo=$("#ModuloId").attr("value");

  var elementos=claves.split(",");
  if (elementos.length>2)
    alert('Debes elegir solo un registro de la tabla');
  else
    if(elementos.length<2)
      alert("Deber elegir un registro de la tabla");
    else
	{
    switch(modulo)
    {
      case '40':
          VentanaReingreso();
          break;
      default:

          break;
    }

/*	$.post("Acciones.php",{Llaves:claves, modulo:modulo, opc:3},getRespuesta);
	 BtLista();
   */
	}
}


function BtGuardar()
{
	if(ValidaDatos())
	{
		var modulo=$("#ModuloId").attr("value");

		switch(modulo)
		{
			case '0':
						guardaMisitio();
			break;
      case '1':
            guardaAviso();
      break;
			case '10':
					return guardarPersonal();
			break;
			case '22':
					return guardarVu();
			break;
			case '23':
					return guardarLectura();
			break;
			case '24':
					return guardarOr();
			break;
			case '26':
					return guardarOrsInv();
			break;
			case '28':
					return guardarTSalidas();
			break;
      case '29':
          return guardarTEntradas();
      break;
			case '30':
					return guardarTExpress();
			break;
			case '35':
					return guardarAsignacionCoordinadores();
			break;
      case '36':
          return GuardaSeguimiento();
      break;
			case '38':
					return guardarVentaAccesorios();
			break;
			case '41':
					return guardarVentaTP();
			break;

			case '43':
					return guardarEntregaUniforme();
			break;
			case '46':
					return guardarLecturaOdc();
			break;
      case '59':
          return GuardaReactivacion();
      break;
      case '60':
          return guardaRevisionBuro();
      break;
	case '64':
          return guardarChecador();
      break;
  case '65':
          return guardaRecarga();
      break;
      case '66':
          return guardaDeposito();
      break;
      case '68':
          return asignaClientePuntoVenta();
      break;
      case '70':
          return addValidacionVenta();
      break;

		}
		$("#guardar").attr("disabled", true);
	}
}

function guardarEntregaUniforme()
{
	v1=$("#FechaContrato").attr("value");
	v2=$("#EmpleadoId").attr("value");
	v3=$("#Comentarios").attr("value");
	v4=$("#Clave").attr("value");

	$.post("Acciones.php",{modulo:43, FechaContrato:v1, EmpleadoId:v2, Comentarios:v3, Clave:v4, opc:3},getRespuesta);

	BtLista
}

function guardarVentaTP()
{
	v1=$("#PuntoVentaId").attr("value");
	v2=$("#VendedorId").attr("value");
	v3=$("#CoordinadorId").attr("value");
	v4=$("#ClienteId").attr("value");
	v5=$("#Comentarios").attr("value");
	v6=$("#Clave").attr("value");

	v7=$("#Folio").attr("value");
	v8=$("#PlazoId").attr("value");
	v9=$("#EstatusId").attr("value");
	v10=$("#FechaContrato").attr("value");
	v11=$("#FechaInstalacion").attr("value");
	v12=$("#Pvs").attr("value");

	$.post("Acciones.php",{modulo:41, PuntoVentaId:v1, VendedorId:v2, CoordinadorId:v3, ClienteId:v4, Comentarios:v5, Clave:v6, Folio:v7, PlazoId:v8, EstatusId:v9, FechaContrato:v10, FechaInstalacion:v11, Pvs:v12, opc:3},getRespuesta);

	$("#VendedorId").val("");
	$("#CoordinadorId").val("");
	$("#ClienteId").val("");
	$("#Comentarios").val("");
	$("#Folio").val("");
	$("#PlazoId").val("0");
	$("#EstatusId").val("0");
	$("#FechaContrato").val("");
	$("#FechaInstalacion").val("");
	$("#displayLineas").html("");
}

function guardarVentaAccesorios()
{

	v1=$("#PuntoVentaId").attr("value");
	v2=$("#VendedorId").attr("value");
	v3=$("#CoordinadorId").attr("value");
	v4=$("#ClienteId").attr("value");
	v5=$("#Comentarios").attr("value");
	v6=$("#Clave").attr("value");

	$.post("Factura.php",{modulo:35, PuntoVentaId:v1, VendedorId:v2, CoordinadorId:v3, ClienteId:v4, Comentario:v5, Clave:v6},getRespuestaFactura);

	$("#display").html('<div align="center"><img src="img/loading.gif"/></div>');
	$("#VendedorId").val("");
	$("#CoordinadorId").val("");
	$("#ClienteId").val("");
	$("#Comentarios").val("");
}

function getRespuestaFactura(datos)
{
//formulario
if (datos=='FAIL')
	$("#display").html('<span class="alerta">¡No fue posible realizar la venta, favor de realizar nuevamente el proceso!</span>');
else
	$("#display").html(datos);

}

function guardarAsignacionCoordinadores()
{
	v1=$("#CoordinadorId").attr("value");
	v2=$("#Llaves").attr("value");
	$.post("Acciones.php",{modulo:35, CoordinadorId:v1, Llaves:v2},getRespuesta);
	$("#CoordinadorId").val("");
	$("#Llaves").attr("");


}

function actualizarTP()
{
	v1=$("#PuntoVentaId").attr("value");
	v2=$("#VendedorId").attr("value");
	v3=$("#CoordinadorId").attr("value");
	v4=$("#ClienteId").attr("value");
	v5=$("#Comentarios").attr("value");


	v7=$("#Folio").attr("value");
	v8=$("#PlazoId").attr("value");
	v9=$("#EstatusId").attr("value");
	v10=$("#FechaContrato").attr("value");
	v11=$("#FechaInstalacion").attr("value");
	v12=$("#Pvs").attr("value");

	$.post("Acciones.php",{modulo:41, PuntoVentaId:v1, VendedorId:v2, CoordinadorId:v3, ClienteId:v4, Comentarios:v5, Folio:v7, PlazoId:v8, EstatusId:v9, FechaContrato:v10, FechaInstalacion:v11, Pvs:v12, opc:4},getRespuesta);

}

function BtActualizar()
{
	if(ValidaDatos())
	{
		var modulo=$("#ModuloId").attr("value");
		switch(modulo)
		{
			case '10':
						actualizarPersonal();
					return true;
			break;
			case '40':
						actualizarPersonalInactivo();
					return true;
			break;
			case '41':
						actualizarTP();
					return true;
			break;
      case '70':
            actualizaValidacionVenta();
      break;
		}
	}
  return true;
}



function guardarPersonal()
{

	v1=$("#Nombre").attr("value");
	v2=$("#Paterno").attr("value");
	v3=$("#Materno").attr("value");
	v4=$("#FechaNacimiento").attr("value");
	v5=$("#Curp").attr("value");
	v6=$("#Rfc").attr("value");
	v7=$("#Ife").attr("value");
	v8=$("#Genero").attr("value");
	v9=$("#NacionalidadId").attr("value");
	v10=$("#EscolaridadId").attr("value");
	v11=$("#ProfesionId").attr("value");
	v12=$("#EstadoCivilId").attr("value");
	v13=$("#Calle").attr("value");
	v14=$("#NExterior").attr("value");
	v15=$("#NInterior").attr("value");
	v16=$("#Cp").attr("value");
	v17=$("#ColoniaId").attr("value");
	v18=$("#Telefono").attr("value");
	v19=$("#Movil").attr("value");
	v20=$("#Nss").attr("value");
	v21=$("#Sangre").attr("value");
	v23=$("#PuestoId").attr("value");
	v24=$("#FechaIngreso").attr("value");
	v25=$("#BancoId").attr("value");
	v26=$("#Cuenta").attr("value");
	v27=$("#Clabe").attr("value");
	v28=$("#FechaIngresoPunto").attr("value");
	v29=$("#Puntos").attr("value");
	v30=$("#ParentescoId").attr("value");
	v31=$("#CalleContacto").attr("value");
	v32=$("#NExteriorContacto").attr("value");
	v33=$("#NInteriorContacto").attr("value");
	v34=$("#CpContacto").attr("value");
	v35=$("#ColoniaIdContacto").attr("value");
	v36=$("#TelefonoContacto").attr("value");
	v37=$("#MovilContacto").attr("value");
	v38=$("#CorreoElectronico").attr("value");
	v39=$("#Fisico").attr("value");
	v40=$("#SubCategoriaId").attr("value");
	v41=$("#NombreContacto").attr("value");
	v42=$("#CoordinadorId").attr("value");
	v43=$("#Operador").attr("value");
	v44=$("#Porcentaje").attr("value");
	v45=$("#ClasificacionPersonalVentaId").attr("value");
	v46=$("#FechaSolicitudImss").attr("value");
  v47=$("#SueldoF").attr("value");
  v48=$("#ReclutadorId").attr("value");
  v49=$("#Mail").attr("value");
  v50=$("#clave_att").attr("value");
 	$.post("Acciones.php",{modulo:10, opc:1, Nombre:v1, Paterno:v2, Materno:v3, FechaNacimiento:v4, Curp:v5, Rfc:v6, Ife:v7, Nss:v20, Genero:v8, NacionalidadId:v9, PuestoId:v23, FechaAltaPuesto:v24, PuntoVentaId:v29, FechaAltaPunto:v28, Fisico:v39, EscolaridadId:v10, ProfesionId:v11, EstadoCivilId:v12, BancoId:v25, NoCuenta:v26, Clabe:v27, ColoniaId:v17, Calle:v13, NExterior:v14, NInterior:v15, Telefono:v18, Movil:v19, TipoSangre:v21, ParentescoId:v30, ColoniaIdContacto:v35, CalleContacto:v31, NExteriorContacto:v32, NInteriorContacto:v33, TelefonoContacto:v36, MovilContacto:v37, CorreoElectronicoContacto:v38, SubCategoriaId:v40, NombreContacto:v41, CoordinadorId:v42, Operador:v43, Porcentaje:v44, ClasificacionPersonalVentaId:v45, FechaSolicitudImss:v46, SueldoF:v47, ReclutadorId:v48, Mail:v49, claveAtt:v50},getRespuesta);

	$("#Nombre").val("");
	$("#Paterno").val("");
	$("#Materno").val("");
	$("#FechaNacimiento").val("");
	$("#Curp").val("");
	$("#Rfc").val("");
	$("#Ife").val("");
	$("#Genero").val("0");
	$("#NacionalidadId").val("0");
	$("#EscolaridadId").val("0");
	$("#ProfesionId").val("0");
	$("#EstadoCivilId").val("0");
	$("#Calle").val("");
	$("#NExterior").val("");
	$("#NInterior").val("");
	$("#Cp").val("");
	$("#ColoniaId").val("0");
	$("#SubCategoriaId").val("0");
	$("#Telefono").val("");
	$("#Movil").val("");
	$("#Nss").val("");
	$("#Sangre").val("");

	$("#PuestoId").val("0");
	$("#FechaIngreso").val("");
	$("#BancoId").val("0");
	$("#Cuenta").val("");
	$("#Clabe").val("");
	$("#FechaIngresoPunto").val("");
	$("#Puntos").val("");
	$("#ParentescoId").val("0");
	$("#NombreContacto").val("");
	$("#CalleContacto").val("");
	$("#NExteriorContacto").val("");
	$("#NInteriorContacto").val("");
	$("#CpContacto").val("");
	$("#ColoniaIdContacto").val("0");
	$("#TelefonoContacto").val("");
	$("#MovilContacto").val("");
	$("#CorreoElectronico").val("");
	$("#Fisico").val("");
 	$("#CoordinadorId").val("0");
 	$("#Operador").val("");
 	$("#Porcentaje").val("");
 	$("#ClasificacionPersonalVentaId").val("0");
	$("#FechaSolicitudImss").val("");
 	$(".pv:checkbox:checked").removeAttr("checked");
  $("#ReclutadorId").val("0");
  $("#Mail").val("");
  $("#clave_att").val("");

 	return false;
}

function actualizarPersonal()
{

	v0=$("#EmpleadoId").attr("value");
	v1=$("#Nombre").attr("value");
	v2=$("#Paterno").attr("value");
	v3=$("#Materno").attr("value");
	v4=$("#FechaNacimiento").attr("value");
	v5=$("#Curp").attr("value");
	v6=$("#Rfc").attr("value");
	v7=$("#Ife").attr("value");
	v8=$("#Genero").attr("value");
	v9=$("#NacionalidadId").attr("value");
	v10=$("#EscolaridadId").attr("value");
	v11=$("#ProfesionId").attr("value");
	v12=$("#EstadoCivilId").attr("value");
	v13=$("#Calle").attr("value");
	v14=$("#NExterior").attr("value");
	v15=$("#NInterior").attr("value");
	v16=$("#Cp").attr("value");
	v17=$("#ColoniaId").attr("value");
	v18=$("#Telefono").attr("value");
	v19=$("#Movil").attr("value");
	v20=$("#Nss").attr("value");
	v21=$("#Sangre").attr("value");
	v23=$("#PuestoId").attr("value");
	v24=$("#FechaIngreso").attr("value");
	v25=$("#BancoId").attr("value");
	v26=$("#Cuenta").attr("value");
	v27=$("#Clabe").attr("value");
	v28=$("#FechaIngresoPunto").attr("value");
	v29=$("#Puntos").attr("value");
	v30=$("#ParentescoId").attr("value");
	v31=$("#CalleContacto").attr("value");
	v32=$("#NExteriorContacto").attr("value");
	v33=$("#NInteriorContacto").attr("value");
	v34=$("#CpContacto").attr("value");
	v35=$("#ColoniaIdContacto").attr("value");
	v36=$("#TelefonoContacto").attr("value");
	v37=$("#MovilContacto").attr("value");
	v38=$("#CorreoElectronico").attr("value");
	v39=$("#Fisico").attr("value");
	v40=$("#SubCategoriaId").attr("value");
	v41=$("#NombreContacto").attr("value");
	v42=$("#CoordinadorId").attr("value");
	v43=$("#ObservacionTh").attr("value");
	v44=$("#Operador").attr("value");
	v45=$("#Porcentaje").attr("value");
	v46=$("#ClasificacionPersonalVentaId").attr("value");

	matriz='';
	if($("#indices").attr("value")!='')
	{
		v47=$("#indices").attr("value").split(",");
		for (x=0;x<v47.length;x++)
		matriz += v47[x]+'|'+$("#FechaSImss"+v47[x]).attr("value")+'|'+$("#FechaMImss"+v47[x]).attr("value")+'|'+$("#SD"+v47[x]).attr("value")+'*';
		matriz=matriz.substring(0, matriz.length-1);
	}

	v48=$("#FechaSolImss").attr("value");
	v49=$("#FechaMovImss").attr("value");
	v50=$("#SDI").attr("value");
	v51=$("#TipoMovimiento").attr("value");

	v52=$("#FechaSFijo").attr("value");
	v53=$("#SueldoF").attr("value");
  v54=$("#Mail").attr("value");
  v55=$("#clave_att").attr("value");
 	$.post("Acciones.php",{modulo:10, opc:2, EmpleadoId:v0, Nombre:v1, Paterno:v2, Materno:v3, FechaNacimiento:v4, Curp:v5, Rfc:v6, Ife:v7, Nss:v20, Genero:v8, NacionalidadId:v9, PuestoId:v23, FechaAltaPuesto:v24, PuntoVentaId:v29, FechaAltaPunto:v28, Fisico:v39, EscolaridadId:v10, ProfesionId:v11, EstadoCivilId:v12, BancoId:v25, NoCuenta:v26, Clabe:v27, ColoniaId:v17, Calle:v13, NExterior:v14, NInterior:v15, Telefono:v18, Movil:v19, TipoSangre:v21, ParentescoId:v30, ColoniaIdContacto:v35, CalleContacto:v31, NExteriorContacto:v32, NInteriorContacto:v33, TelefonoContacto:v36, MovilContacto:v37, CorreoElectronicoContacto:v38, SubCategoriaId:v40, NombreContacto:v41, CoordinadorId:v42, ObservacionTh:v43, Operador:v44, Porcentaje:v45, ClasificacionPersonalVentaId:v46, DatosImss:matriz, FechaSImss:v48, FechaMImss:v49, SD:v50, TipoMovimiento:v51, FechaSFijo:v52, SFijo:v53, Mail:v54, claveAtt:v55},getRespuesta);

	$("#Nombre").val("");
	$("#Paterno").val("");
	$("#Materno").val("");
	$("#FechaNacimiento").val("");
	$("#Curp").val("");
	$("#Rfc").val("");
	$("#Ife").val("");
	$("#Genero").val("0");
	$("#NacionalidadId").val("0");
	$("#EscolaridadId").val("0");
	$("#ProfesionId").val("0");
	$("#EstadoCivilId").val("0");
	$("#SubCategoriaId").val("0");
	$("#Calle").val("");
	$("#NExterior").val("");
	$("#NInterior").val("");
	$("#Cp").val("");
	$("#ColoniaId").val("0");
	$("#Telefono").val("");
	$("#Movil").val("");
	$("#Nss").val("");
	$("#Sangre").val("");

	$("#PuestoId").val("0");
	$("#FechaIngreso").val("");
	$("#BancoId").val("0");
	$("#Cuenta").val("");
	$("#Clabe").val("");
	$("#FechaIngresoPunto").val("");
	$("#Puntos").val("");
	$("#ParentescoId").val("0");
	$("#NombreContacto").val("");
	$("#CalleContacto").val("");
	$("#NExteriorContacto").val("");
	$("#NInteriorContacto").val("");
	$("#CpContacto").val("");
	$("#ColoniaIdContacto").val("0");
	$("#TelefonoContacto").val("");
	$("#MovilContacto").val("");
	$("#CorreoElectronico").val("");
	$("#Fisico").val("");
	$("#Operador").val("");
	$("#Porcentaje").val("");
	$("#CoordinadorId").val("0");
 	$("#nc").html("");
 	$("#ObservacionTh").html("");
 	$("#Foto").attr("src", "");
 	$(".pv:checkbox:checked").removeAttr("checked");
	$.ajax({cache: false});
	$("#Fisico").val("");
 	$("#ClasificacionPersonalVentaId").val("0");
 	$("#indices").val("");

 	$("#FechaSolImss").val("");
 	$("#FechaMovImss").val("");
 	$("#SDI").val("");
 	$("#TipoMovimiento").val("");

 	$("#FechaSFijo").val("00-00-0000");
 	$("#SueldoF").val("0");
  $("#Mail").val("");
  $("#clave_att").val("");

 	return false;

}

function actualizarPersonalInactivo()
{
	v0=$("#HistorialPuestoEmpleadoId").attr("value");
	v1=$("#HistorialEmpleadoImss").attr("value");
	v2=$("#FechaSolicitudImss").attr("value");
	v3=$("#FechaAltaImss").attr("value");
	v4=$("#Finiquito").attr("value");
	v5=$("#ObservacionesTH").attr("value");
	v6=$("#EmpleadoId").attr("value");

 	$.post("Acciones.php",{modulo:40, opc:1, HistorialPuestoEmpleadoId:v0, HistorialEmpleadoImss:v1,
 							FechaSolicitudImss:v2, FechaAltaImss:v3, Finiquito:v4, ObservacionesTH:v5, EmpleadoId:v6},getRespuesta);

	$("#FechaSolicitudImss").val("");
	$("#FechaAltaImss").val("");
	$("#Finiquito").val("");
	$("#ObservacionesTH").val("");

 	return false;
}


function guardaMisitio()
{

	/*Valida datos de Formulario */
	if($("#actual").attr("value")=="" || $("#password1").attr("value")=="" || $("#password2").attr("value")=="")
	{
		$("#resultados").html('<span class="alerta">¡Debes ingresar los datos marcados como obligatorios (*)!</span>');
		return false;
	}

	if($("#password1").attr("value")!=$("#password2").attr("value"))
	{
		$("#resultados").html('<span class="alerta">¡La nueva contraseña no coincide!</span>');
		return false;
	}

	/*Envia Datos al server*/
 	var v1=$("#actual").attr("value");
 	var v2=$("#password1").attr("value");
 	$.post("Acciones.php",{actual:v1, nuevo:v2, modulo:0, opc:1},getRespuesta);
 	return false;

}

function getRespuestaVU(datos)
{
	$("#displayRef").html(datos);
}

function getLineasVU(datos)
{
	$("#displayLineas").html(datos);

 if (typeof $("#Cantidad") != "undefined" & typeof $("#NoLineas") != "undefined")
	$("#Cantidad").val($("#NoLineas").attr("value"));
}

function getLineasVUCta(datos)
{
	$("#NoLineas").val(datos);
}

function getRespuesta(datos)
{
	$("#resultados").html(datos);
}

function getClienteId(datos)
{

	$("#ClienteId").val(datos);
	if(datos=="0")
		alert("No se realizo el registro");
	else
	{
		var v1='<input type="radio" name="ClienteId" id="ClienteId" class="Pt" value="'+datos+'" onclick="setEleccion(this,4)"/>';
		$("#MiTabla5").append('<tr><td>'+datos+'</td><td>'+$("#NombreC").attr("value")+' '+$("#PaternoC").attr("value")+' '+$("#MaternoC").attr("value")+'</td><td>'+$("#RFCC").attr("value")+'</td><td align="center">'+v1+'</td></tr>');

		$("#ClienteId").val(datos);
		$("#Nombre").val($("#NombreC").attr("value")+' '+$("#PaternoC").attr("value")+' '+$("#MaternoC").attr("value"));
		$("#RFC").val($("#RFCC").attr("value"));

		$("#TipoPersonaId").val("0");
		$("#NombreC").val("");
		$("#PaternoC").val("");
		$("#MaternoC").val("");
		$("#RFCC").val("");
		$("#NacionalidadId").val("0");
		$("#TipoIdentificacionId").val("0");
		$("#NoId").val("");
		$("#EstadoCivilId").val("0");
		$("#EscolaridadId").val("0");
		$("#OcupacionId").val("0");
		$("#TEmpleo").val("");
		$("#TEmpleo").val("");
		$("#TVivienda").val("");
		$("#Calle").val("");
		$("#NExterior").val("");
		$("#NInterior").val("");
		$("#ColoniaId").val("0");
		$("#TLocal").val("");
		$("#TMovil").val("");
		$("#NombreCT").val("");
		$("#PaternoCT").val("");
		$("#MaternoCT").val("");
		$("#TipoViviendaId").val("0");
		$("#Cp").val("");
		$("#ClientesNuevos").dialog( "close" );
	}
}

function setSeleccion(obj, Clave)
{
var valor=obj.value;

switch(Clave)
	{
		case 1:
				if(obj.checked)
					$("#Puntos").val($("#Puntos").attr("value")+valor+",");
				else
					$("#Puntos").val($("#Puntos").attr("value").replace(valor+",",""));
		break;
		case 2:
				if(obj.checked)
					$("#AddOnes").val($("#AddOnes").attr("value")+valor+",");
				else
					$("#AddOnes").val($("#AddOnes").attr("value").replace(valor+",",""));
		break;
		case 3:
				if(obj.checked)
					$("#OtrosServ").val($("#OtrosServ").attr("value")+valor+",");
				else
					$("#OtrosServ").val($("#OtrosServ").attr("value").replace(valor+",",""));
		break;
	}

}

function setEleccion(obj, Clave)
{
var valor=obj.value;

switch(Clave)
	{
		case 1:
				$("#Fisico").val(valor);
		break;
		case 2:
				$("#PuntoVentaId").val(valor);

				$('#MiTabla tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
	                $("#PuntoVenta").val(this.cells[4].innerHTML);
	                $("#PuntosVenta").dialog( "close" );
            	}
                 });
		break;
		case 3:
				$("#VendedorId").val(valor);

				$('#MiTabla2 tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
	                $("#Vendedor").val(this.cells[4].innerHTML);
	                $("#CoordinadorId").val(this.cells[2].innerHTML);
	                $("#Coordinador").val(this.cells[3].innerHTML);
	                $("#Categoria").val(this.cells[5].innerHTML);
	                $("#Vendedores").dialog( "close" );
            	}
                 });
		break;
		case 4:
				$("#ClienteId").val(valor);

				$('#MiTabla5 tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
	                $("#Nombre").val(this.cells[1].innerHTML);
	                $("#RFC").val(this.cells[2].innerHTML);
	                $("#Clientes").dialog( "close" );
            	}
                 });
		break;

		case 5:
				$("#EquipoId").val(valor);

				$('#MiTabla6 tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
	                $("#Equipo").val(this.cells[1].innerHTML);
	                $("#Equipos").dialog( "close" );
            	}
                 });
		break;
		case 6:
				var myArray = valor.split(',');
				$("#PlanId").val(myArray[0]);
				$("#TipoPlanId").val(myArray[1]);
				$('#MiTabla7 tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==myArray[0] & this.cells[1].innerHTML==myArray[1])
                {
	                $("#Plan").val(this.cells[2].innerHTML);
	                //$("#TipoPlanId").val(this.cells[1].innerHTML);
	                $("#Planes").dialog( "close" );
            	}
                 });
		break;
		case 7:
			if($("#Campo").attr("value")=="1")
			{
			$("#PuntoVentaIdO").val(valor);

				$('#MiTabla tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
	                $("#PuntoVentaO").val(this.cells[4].innerHTML);
	                $("#PuntosVenta").dialog( "close" );
            	}
                 });
			}
			else
			{
			$("#PuntoVentaIdD").val(valor);

				$('#MiTabla tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
	                $("#PuntoVentaD").val(this.cells[4].innerHTML);
	                $("#PuntosVenta").dialog( "close" );
            	}
                 });
			}

		break;
		case 8:
			$("#CoordinadorId").val(valor);

				$('#MiTabla2 tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
	                $("#Coordinador").val(this.cells[1].innerHTML);
	                $("#Coordinaciones").dialog( "close" );
            	}
                 });
		break;
		case 9:
				$("#EmpleadoId").val(valor);

				$('#MiTabla2 tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {

	                $("#Empleado").val(this.cells[1].innerHTML);
	                $("#Empleados").dialog( "close" );
            	}
                 });
		break;
		case 10:
				$("#ODC").val(valor);
				$("#Ordenes").dialog( "close" );
		break;
		case 11:
				$("#Odt").val(valor);
				$('#MiTabla tr').each(function()
				{
                	if (!this.rowIndex) return;
                	if(this.cells[0].innerHTML==valor)
                	{
	                    $("#PuntoVentaOrigen").val(this.cells[2].innerHTML);
	               		$("#OrdenTraspaso").dialog( "close" );
            		}
                 });
		break;
    case 12:
        $("#EmpleadoId").val(valor);

        $('#MiTabla2 tr').each(function() {
                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
                  $("#Usuario").val(this.cells[1].innerHTML);
                  $("#Usuarios").dialog( "close" );
              }
                 });
    break;
    case 13:
        $("#PuntoVentaIdB").val(valor);

        $('#MiTabla2 tr').each(function() {

                if (!this.rowIndex) return;
                if(this.cells[0].innerHTML==valor)
                {
                  $("#PuntoVentaB").val(this.cells[4].innerHTML);
                  $("#PuntosVentaB").dialog( "close" );
              }
                 });
    break;


	}

}

function Remover(obj, Folio, Clave)
{
	switch(Clave)
	{
		case 1: //Borrar Linea de TLineas
				$.post("Acciones.php",{RegistroId:obj, Clave:Folio, modulo:22, opc:4},getLineasVU);
		break;
		case 2:
				$.post("Acciones.php",{RegistroId:obj, Clave:Folio, modulo:23, opc:4},getLineasVU);
		break;
		case 3:
				$.post("Acciones.php",{RegistroId:obj, Clave:Folio, modulo:30, opc:4},getLineasVU);
		break;
		case 4:
				$.post("Acciones.php",{RegistroId:obj, PuntoVentaId:Folio, modulo:33, opc:2},getLineasVU);
		break;
		case 5:
				$.post("Acciones.php",{RegistroId:obj, Clave:Folio, modulo:38, opc:2},getLecturaAccVta);
		break;
		case 6:
				$.post("Acciones.php",{RegistroId:obj, Clave:Folio, modulo:41, opc:2},getLecturaTPVta);
		break;
		case 7:
				$.post("Acciones.php",{RegistroId:obj, Clave:Folio, modulo:43, opc:2},getLecturaTPVta);
		break;
    case 8:
        $.post("Acciones.php",{RegistroId:obj, AddonId:Folio, modulo:71, opc:2},function(datos){$("#Addones").html(datos)});
    break;



	}

}

function guardarLectura()
{
	v1=$("#Factura").attr("value");
	v2=$("#PuntoVentaId").attr("value");
	v3=$("#Comentarios").attr("value");
	v4=$("#Clave").attr("value");

	$.post("Acciones.php",{Factura:v1, PuntoVentaId:v2, Comentarios:v3, Clave:v4, modulo:23, opc:5},getAltaVu);

}


function guardarTExpress()
{
	v1=$("#PuntoVentaIdO").attr("value");
	v2=$("#PuntoVentaIdD").attr("value");
	v3=$("#Comentarios").attr("value");
	v4=$("#Clave").attr("value");
	$.post("Acciones.php",{PuntoVentaIdO:v1, PuntoVentaIdD:v2, Comentarios:v3, Clave:v4, modulo:30, opc:5},getAltaVu);
}

function guardarTSalidas()
{
	v1=$("#PuntoVentaIdO").attr("value");
	v2=$("#PuntoVentaIdD").attr("value");
	v3=$("#Comentarios").attr("value");
	v4=$("#Clave").attr("value");
	$.post("Acciones.php",{PuntoVentaIdO:v1, PuntoVentaIdD:v2, Comentarios:v3, Clave:v4, modulo:28, opc:1},getAltaVu);
}

function guardarTEntradas()
{
  v1=$("#Odt").attr("value");
  v2=$("#Comentarios").attr("value");
  v3=$("#Clave").attr("value");
  v4=$("#PuntoVentaIdD").attr("value");
  $.post("Acciones.php",{Odt:v1, Comentarios:v2, Clave:v3, PuntoVentaId:v4, modulo:29, opc:2},getAltaVu);
}

function guardarVu()
{
	v1=$("#Folio").attr("value");
	v2=$("#FechaContrato").attr("value");

	v4=$("#PuntoVentaId").attr("value");
	v5=$("#VendedorId").attr("value");
	v6=$("#CoordinadorId").attr("value");
	v7=$("#ClienteId").attr("value");
	v8=$("#TipoContratacionId").attr("value");
	v9=$("#TipoPagoId").attr("value");
	v10=$("#Comentarios").attr("value");
	v11=$("#Clave").attr("value");
  v12=$("#ContratacionId").attr("value");

	$.post("Acciones.php",{Folio:v1, FechaContrato:v2, PuntoVentaId:v4, VendedorId:v5, CoordinadorId:v6,
		ClienteId:v7, TipoContratacionId:v8, TipoPagoId:v9, Comentarios:v10, Clave:v11, ContratacionId:v12, modulo:22, opc:5},getAltaVu);

}

function guardarOrsInv()
{
	v1=$("#Folio").attr("value");
	v4=$("#PuntoVentaId").attr("value");
	v5=$("#VendedorId").attr("value");
	v6=$("#CoordinadorId").attr("value");
	v7=$("#ClienteId").attr("value");
	v8=$("#TipoContratacionId").attr("value");
	v9=$("#TipoPagoId").attr("value");
	v10=$("#Comentarios").attr("value");

	$.post("Acciones.php",{Folio:v1, PuntoVentaId:v4, VendedorId:v5, CoordinadorId:v6,
		ClienteId:v7, TipoContratacionId:v8, TipoPagoId:v9, Comentarios:v10, modulo:26, opc:5},getAltaVu);

}


function guardarOr()
{
//alert("esto es por que si actualizaste cookies")
	v1=$("#Folio").attr("value");
	v2=$("#FechaSS").attr("value");

	v4=$("#PuntoVentaId").attr("value");
	v5=$("#VendedorId").attr("value");
	v6=$("#CoordinadorId").attr("value");
	v7=$("#ClienteId").attr("value");
	v8=$("#TipoContratacionId").attr("value");
	v9=$("#TipoPagoId").attr("value");
	v10=$("#Comentarios").attr("value");
	v11=$("#Clave").attr("value");

	  v12=$("#ContratacionId").attr("value");
	  v13=$("#TipoVentaId").attr("value");
  v14=$("#PlataformaId").attr("value");

//alert("v13 es:"+v13)
	$.post("Acciones.php",{Folio:v1, FechaContrato:v2, PuntoVentaId:v4, VendedorId:v5, CoordinadorId:v6,
		ClienteId:v7, TipoContratacionId:v8, TipoPagoId:v9, Comentarios:v10, Clave:v11, ContratacionId:v12, TipoVentaId:v13, PlataformaId:v14,
    modulo:24, opc:5},getAltaVu);
}


function getAltaVu(datos)
{

	if(datos=='OK')
		location.reload();
	else

	$("#resultados").html(datos);

}

function descargaLayout(opc)
{
 location.href="ExportaLayoutCsv.php?opc="+opc;
}

function descargaTemplate(opc)
{
 location.href="Templates/"+opc;
}

function descargaConsulta(opc)
{
 location.href="ExportaConsultasCsv.php?opc="+opc;
}


function changeEstatus(Folio)
{


	$("#foo").attr("action", "CambiarEstatus.php");
	$("#foo").attr("target", "CambiarEstatus");
	$("#MiFolio").val(Folio);

	ancho=800;
	alto=400;

	AbrirVentana(ancho, alto, 'CambiarEstatus');
	$("#foo").submit();
}

function addEquipos(Folio, Movimiento)
{

  $("#foo").attr("action", "AddEquipo.php");
	$("#foo").attr("target", "AgregarEquipos");
	$("#MiFolio").val(Folio);
	$("#Movimiento").val(Movimiento);

	ancho=900;
	alto=350;

	AbrirVentana(ancho, alto, 'AgregarEquipos');
	$("#foo").submit();

}

function verFactura(Folio)
{
	window.open("Pdf.php?VentaId="+Folio);
}


function Documentacion()
{

	$("#foo").attr("action", "Documentacion.php");
	$("#foo").attr("target", "AdjuntarDocumentos");

	ancho=450;
	alto=350;

	AbrirVentana(ancho, alto, 'AdjuntarDocumentos');
	$("#foo").submit();
}



function AbrirVentana(ancho,alto, nombreVentana)
{
	if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
	alto=eval(alto)+50;
	x=(screen.width- ancho)/2;
	y=(screen.height - alto)/2;
	dimensiones="width=" + ancho + ", height=" + alto + ", left=" + x + ", top=" + y;
	barra = "scrollbars=" + "1";
	features="status=0, toolbar=0, location=0, menubar=0, directories=0, resizable=0, " + barra + ", " + dimensiones;
  cjb=window.open('',nombreVentana,features);
  cjb.focus();
return;
}

function ActualizaEstatus(RegistroId, PlanId)
{

	v1=$("#EstatusId"+RegistroId).attr("value");
	v2=$("#FechaEstatus"+RegistroId).attr("value");
	v3=$("#Comentarios"+RegistroId).attr("value");
	v4=$("#Contrato"+RegistroId).attr("value");
	v5=$("#ModuloId").attr("value");
	v6=$("#DN"+RegistroId).attr("value");

	if(v1==0)
	{
		alert("Debes elegir el nuevo estatus")
		return false;
	}

	if(v4=="" & PlanId!=81 & v5!=22)
	{
		alert("Debes ingresar el numero de contrato");
		return false;
	}

	if(v5!=22 & v6=='')
	{
		alert("Debes ingresar el numero de DN");
		return false;
	}

	if(v4=="" & PlanId!=81 & v5!=22)
	{
	$.post("Acciones.php",
			{RegistroId:RegistroId, Contrato:v4, modulo:24, opc:1},
			function(datos){
				if(datos=='fail')
				{
					alert("Este numero de contrato no esta disponible");
					return false;
				}
				else
					$.post("Acciones.php",{RegistroId:RegistroId, EstatusId:v1, FechaEstatus:v2, Comentario:v3, Contrato:v4, DN:v6, modulo:22, opc:6},getRespuesta);
			});
	}else

	$.post("Acciones.php",{RegistroId:RegistroId, EstatusId:v1, FechaEstatus:v2, Comentario:v3, Contrato:v4, DN:v6, modulo:22, opc:6},getRespuesta);

}

 function ProcesaLecturaAcc(e)
 {

 	$("#resultados").html("");
	var v1=$("#CodAcc").prop("value");
	var v2=$("#PuntoVentaId").prop("value");
	var v3=$("#Clave").prop("value");

	if(e.which==13 & v1!='')
	{
		$.post("Acciones.php",{Lectura:v1, PuntoVentaId:v2, Clave:v3, modulo:38, opc:1},getLecturaAccVta);
	}
 }

function getLecturaAccVta(datos)
 {
 	var v1=$("#CodAcc").prop("value");
 	if(datos.toString().search('alerta')>0)
		{
			$("#resultados").html(datos);
		}
		else
		{
		$("#displayLineas").html(datos);
	 		if (typeof $("#Cantidad") != "undefined" & typeof $("#NoLineas") != "undefined")
			$("#TAcc").html($("#NoLineas").attr("value"));
			//$("#TT").html('$ '+formato_numero($("#MontoLineas").attr("value"),2));
			//$("#Restante").html('$ '+formato_numero($("#MontoLineas").attr("value")-($("#Efectivo").attr("value")+$("#TCredito").attr("value")),2));
			calculaMontosAcc();
			$("#CodAcc").val("")
		}
}

function calculaMontosAcc()
{
	$("#TT").html('$ '+formato_numero($("#MontoLineas").attr("value"),2));
	$("#Restante").html('$ '+formato_numero($("#MontoLineas").attr("value")-(parseFloat($("#Efectivo").attr("value"))+parseFloat($("#TCredito").attr("value"))),2));
}

 function ProcesaLectura(e)
 {
 	$("#resultados").html("");
 	$("#Equipo").val("");
	var v1=$("#Lectura").prop("value");
	var v2=$("#MiFolio").prop("value");
	if(e.which==13 & v1!='')
	{
		$.post("Acciones.php",{Lectura:v1, MiFolio:v2, modulo:24, opc:3},getLectura);
	}
 }


 function ProcesaLecturaSIM(e)
 {
  $("#resultados").html("");
  
  var v1=$("#codigo_sim").prop("value");
  var v2=$("#MiFolio").prop("value");
  if(e.which==13 & v1!='')
  {
    $.post("Acciones.php",{Lectura:v1, MiFolio:v2, modulo:24, opc:3},getLecturaSIM);
  }
 }



 function getLecturaSIM(datos)
 {

  var v1=$("#codigo_sim").prop("value");

  if(datos.toString().search('alerta')>0)
    {
      $("#resultados").html(datos);
    }
    else
    $("#DSim").val(datos);
}



 function getLectura(datos)
 {

 	var v1=$("#Lectura").prop("value");

 	if(datos.toString().search('alerta')>0)
		{
			$("#resultados").html(datos);
		}
		else
		$("#Equipo").val(datos);
}

function AgregaLineaOr()
{
	if($("#Equipo").attr("value")=="")
	{
	alert("Debes ingresar el Equipo");
	return false
	}

	if($("#PlanId").attr("value")=="0")
	{
	alert("Debes ingresar el Plan");
	return false
	}

  if($("#AddOnes").attr("value")=="")
  {
    alert("Debes elegir al menos un AddOn")
    return false
  }

	if($("#PlazoId").attr("value")=="0")
	{
	alert("Debes elegir el Plazo");
	return false
	}

	if($("#Diferencial").attr("value")!="" & $("#Diferencial").attr("value")!="0")
		if($("#TipoPagoId").attr("value")=="0")
		{
			alert("Debes elegir el tipo de pago del diferencia")
			return false;
		}

  if($("#DSim").attr("value")=="")
  {
  alert("Debes ingresar el SIM");
  return false
  }


	var v1=$("#Lectura").attr("value");
	var v2=$("#MiFolio").attr("value");
	var v3=$("#PlanId").attr("value");
	var v4=$("#TipoPlanId").attr("value");
	var v5=$("#AddOnes").attr("value")+'0';
	var v6=$("#OtrosServ").attr("value")+'0';
	var v7=$("#PlazoId").attr("value");
	var v8=$("#Movimiento").attr("value");

	var v9=$("#Movimiento").attr("value");
	var v10=$("#Movimiento").attr("value");

	var v11=$("#Diferencial").attr("value");
	var v12=$("#TipoPagoId").attr("value");
  var v13=$("#SeguroId").attr("value");

	if(v11=='')
		v11=0;
  var v14=$("#codigo_sim").attr("value");

	$.post("Acciones.php",{Serie:v1, MiFolio:v2, PlanId:v3, TipoPlanId:v4, AddOnes:v5, OtrosServ:v6, PlazoId:v7, Movimiento:v8, Diferencial:v11, TipoPagoDiferencial:v12, SeguroId:v13, codigo_sim: v14, modulo:24, opc:7},getResultadoOrg);


}

function getResultadoOrg(datos)
{

	if(datos=='ok')
		{
			document.forms[0].submit();

		}
		else
			$("#resultados").html(datos);

}

function setSolicitud(clave)
{

  //if($("#Folio").attr("readonly"))
    $("#Folio").val(clave);

}

function LiberaSerie()
{
	$("#resultados").html("");
	if($("#Serie").attr("value")=="")
	{
	alert("Debes ingresar el numero de serie");
	return false
	}

	var v1=$("#Serie").attr("value");
	$.post("Acciones.php",{Serie:v1,  modulo:34, opc:1},getRespuesta);

}

function CambiaFechaRecepcion()
{
	$("#resultados").html("");
	if($("#MovimientoId").attr("value")=="")
	{
	alert("Debes ingresar el numero de Recepcion");
	return false
	}

	if($("#FechaIngreso").attr("value")=="")
	{
	alert("Debes ingresar la fecha de Recepcion");
	return false
	}

	var v1=$("#MovimientoId").attr("value");
	var v2=$("#FechaIngreso").attr("value");

	$.post("Acciones.php",{MovimientoId:v1, FechaRecepcion:v2,  modulo:34, opc:2},getRespuesta);

}

function DesbloquearSerieTraspaso()
{
	$.post("Acciones.php",{modulo:34, opc:3},getRespuesta);
}

function DesbloquearCancelados()
{
  $.post("Acciones.php",{modulo:34, opc:5},getRespuesta);
}


function DesbloquearLecturaRecepcion()
{
	$("#resultados").html("");
	if($("#ClaveRecepcion").attr("value")=="")
	{
	alert("Debes ingresar la clave de recepcion");
	return false
	}

	var v1=$("#ClaveRecepcion").attr("value");
	$.post("Acciones.php",{ClaveRecepcion:v1,  modulo:34, opc:4},getRespuesta);
}

function getcampoTabla(campo)
{
var valor =$("#Llaves").attr("value").replace(',','');

	$('#myTable tr').each(function()
	{
    	if (!this.rowIndex) return;
        if(this.cells[1].innerHTML==valor)
        {
	        $("#ObjetoBaja").html(this.cells[campo].innerHTML);
        }
    });

}

function bajaPersonal()
{
	var v1 =$("#Llaves").attr("value").replace(',','');
	var v2= $("#CausaBajaId").attr("value");
	var v3= $("#FechaContrato").attr("value");

		$.post("Acciones.php",{EmpleadoId:v1, CausaBajaId:v2, FechaBaja:v3, modulo:10, opc:3},getRespuestaVentana);
}

function setConcepto()
{
  var v1 =$("#Llaves").attr("value");
  var v2= $("#ConceptoTRId").attr("value");


    $.post("Acciones.php",{TraspasoId:v1, ConceptoTRId:v2, modulo:29, opc:3},getRespuestaVentana);
}

function  getRespuestaVentana(datos)
{
	if(datos=='OK')
	{
	$("#Baja").dialog( "close" );
	BtLista();
	}
	else
	$("#avisoVentana").html(datos);
}

function GuardaSeguimiento()
{

	var v1= $("#Comentarios").attr("value");
	var v2= $("#EstatusId").attr("value");
  var v3= $("#dateTimeField").attr("value");
  var v4= $("#SeguimientoId").attr("value");

if(v3=='')
  v3='0000-00-00 00:00:00'

	$.post("Acciones.php",{SeguimientoId:v4, EstatusSeguimientoId:v2, Comentarios:v1, FechaHora:v3, modulo:36},getRespuesta);

    pagina=jQuery(location).attr('href')
    location.href=pagina
}

function GuardaReactivacion()
{

  var v1= $("#Comentarios").attr("value");
  var v2= $("#EstatusId").attr("value");
  var v3= $("#dateTimeField").attr("value");
  var v4= $("#RevisionId").attr("value");

if(v3=='')
  v3='0000-00-00 00:00:00'

  $.post("Acciones.php",{RevisionId:v4, EstatusSeguimientoId:v2, Comentarios:v1, FechaHora:v3, modulo:59},getRespuesta);

    pagina=jQuery(location).attr('href')
    location.href=pagina
}


function EnviaCliente(valor)
{

	$("#Nombre").val(valor);
	$("#foo").submit();
}

function AddProducto(clave, producto)
{
	$("#Productos").dialog("close");
	$("#Busqueda3").val("");
	$("input:radio").attr("checked", false);

	$.post("Acciones.php",{Clave:clave, ProductoId:producto, opc:1, modulo:41},getLecturaTPVta);
}

function getLecturaTPVta(datos)
 {
 	if(datos.toString().search('alerta')>0)
	$("#resultados").html(datos);
	else
	$("#displayLineas").html(datos);
}

function asistenteImprtar(Dato, Opcion)
{

	switch(Opcion)
	{

		case 3:
				$("#display").load("Display.php?opc="+Opcion+"&DatoId="+Dato);
				break;

		case 4:
				$("#display").load("Display.php?opc="+Opcion+"&DatoId="+Dato);
				break;
		case 5:
				if($("#FileImport").val()=='')
				{
					$("#msj").html("Por favor selecciona el archivo que deseas importar");
					return false;
				}

				  extension = ($("#FileImport").val().substring($("#FileImport").val().lastIndexOf("."))).toLowerCase();
				 if(extension!='.csv' & extension!='.CSV')
				 {
					$("#msj").html("Tipo de archivo no valido, debe ser delimitado por comas");
					return false;
				 }
				sendFile();
				break;
		case 6:
				location.reload();
		default:
				location.reload();
				break;

	}

}

function resetDate(obj)
{
	$(obj).val("00-00-0000");

}

function pasoNext()
{
	if($("#ModuloId").attr("value")==37)
	{
		var paso=parseInt($("#paso").attr("value")) + 1;
		var DatoId=$("#DatoId").attr("value");
		asistenteImprtar(DatoId, paso);
	}

}

function pasoLast()
{
	if($("#ModuloId").attr("value")==37)
	{
		var paso=$("#paso").attr("value") - 1;
		var DatoId=$("#DatoId").attr("value");
		asistenteImprtar(DatoId, paso);
	}
}

function guardarLecturaOdc()
{
	var extension = ($("#FileImport").val().substring($("#FileImport").val().lastIndexOf("."))).toLowerCase();

	if (extension.toLowerCase()!='.png' & extension.toLowerCase()!='.jpg' & extension.toLowerCase()!='.pdf' & extension.toLowerCase()!='.bmp' & extension.toLowerCase()!='.zip')
	{
		alert("El tipo de archivo del Documento Factura no es valido");
		return false;
	}

	var inputFile = document.getElementById("FileImport");//$("#FileImport");
	var file = inputFile.files[0];
	var clave=$('#Clave').attr("value");
	var datoId=$('#DatoId').attr("value");
	var v1=$("#ODC").attr("value");
	var v2=$("#PuntoVentaId").attr("value");
	var v3=$("#Comentarios").attr("value");
	var v4=$("#Clave").attr("value");

	var data = new FormData();

	data.append('archivo',file);
	data.append('Clave', clave);
	data.append('Factura', v1);
	data.append('PuntoVentaId', v2);
	data.append('Comentarios', v3);
	data.append('Clave', v4);
	data.append('Opc', 2);
	data.append('ext', extension);

	var url = "Upload.php";
	$.ajax({
			url:url,
			type:'POST',
			contentType:false,
			data:data,
			processData:false,
			cache:false
			})
	.done(function( data, textStatus, jqXHR ) {
			 pagina=jQuery(location).attr('href')
       location.href=pagina
	 })
	 .fail(function( jqXHR, textStatus, errorThrown ) {
	     if ( console && console.log ) {
	         $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro!</span>');
	         return false;
	     }
	});
}


function sendFile()
{
	var inputFile = document.getElementById("FileImport");//$("#FileImport");
	var file = inputFile.files[0];
	var clave=$('#Clave').attr("value");
	var datoId=$('#DatoId').attr("value");
	var data = new FormData();

	$("#contenido").html("La informacion se esta importando, el proceso puede tardar algunos minutos");

	data.append('archivo',file);
	data.append('Clave', clave);
	data.append('DatoId', datoId);
	data.append('Opc', 1);
	var url = "Upload.php";
	$.ajax({
			url:url,
			type:'POST',
			contentType:false,
			data:data,
			processData:false,
			cache:false
			})
	.done(function( data, textStatus, jqXHR ) {

	        //$("#contenido").html( "La solicitud se ha completado correctamente." );
	        $("#contenido").html(data);
			$("#paso").val("5");

	 })
	 .fail(function( jqXHR, textStatus, errorThrown ) {
	     if ( console && console.log ) {
	         $("#contenido").html("No fue posible cargar el archivo, intentalo nuevamente");
	     }
	});
}

function cargaTabla()
{
	var ModuloId=$("#ModuloId").attr("value");
	$("#foo").load("table.php?estatus=1&ModuloId="+ModuloId,  function () {$("#jqxgrid").jqxGrid('autoresizecolumns')});
}

function agregaUniforme()
{
	var clave=$('#Clave').attr("value");
	var v1=$('#UniformeId').attr("value");
	var v2=$('#Color').attr("value");
	var v3=$('#Talla').attr("value");
	var v4=$('#Cantidad').attr("value");

	if(v1==0 || v2==0 || v3==0 || v4=='' || v4=='0' )
		alert('Debes elegir todos los conceptos');
	else
		$.post("Acciones.php",{Clave:clave, UniformeId:v1, Color:v2, Talla:v3, Cantidad:v4, opc:1, modulo:43},getLecturaTPVta);
}

function SiguienteCurso(Empleado){
	$.post("Acciones.php",
		{EmpleadoId:Empleado, opc:1, modulo:48},
		function(datos){
			if(datos=='INVALIDO')
				alert('Ya no se tiene curso por asignar');
			else
				if(datos=='FAIL')
					alert('No fue podsible asignar el curso, favor de validar');
				else
					if(datos=='OK')
						location.reload();
		});
}

function calculaEsquema1(){

clearCalculo();
if($("#a1").attr("value")=='')
	$("#a1").val("0");
if($("#a2").attr("value")=='')
	$("#a2").val("0");
if($("#a3").attr("value")=='')
	$("#a3").val("0");
if($("#a4").attr("value")=='')
	$("#a4").val("0");
if($("#b1").attr("value")=='')
	$("#b1").val("0");
if($("#b2").attr("value")=='')
	$("#b2").val("0");
if($("#b3").attr("value")=='')
	$("#b3").val("0");
if($("#b4").attr("value")=='')
	$("#b4").val("0");
if($("#c1").attr("value")=='')
	$("#c1").val("0");
if($("#c2").attr("value")=='')
	$("#c2").val("0");
if($("#c3").attr("value")=='')
	$("#c3").val("0");
if($("#c4").attr("value")=='')
	$("#c4").val("0");



	var s1=parseFloat($("#a1").attr("value"))+parseFloat($("#b1").attr("value"))+parseFloat($("#c1").attr("value"));
	var s2=parseFloat($("#a2").attr("value"))+parseFloat($("#b2").attr("value"))+parseFloat($("#c2").attr("value"));
	var s3=parseFloat($("#a3").attr("value"))+parseFloat($("#b3").attr("value"))+parseFloat($("#c3").attr("value"));
	var s4=parseFloat($("#a4").attr("value"))+parseFloat($("#b4").attr("value"))+parseFloat($("#c4").attr("value"));

	totala=parseFloat($("#a1").attr("value"))+parseFloat($("#a2").attr("value"))+parseFloat($("#a3").attr("value"))+parseFloat($("#a4").attr("value"));
	totalb=parseFloat($("#b1").attr("value"))+parseFloat($("#b2").attr("value"))+parseFloat($("#b3").attr("value"))+parseFloat($("#b4").attr("value"));
	totalc=parseFloat($("#c1").attr("value"))+parseFloat($("#c2").attr("value"))+parseFloat($("#c3").attr("value"))+parseFloat($("#c4").attr("value"));


	if(s1<250)
	{
		fijo1=0;
		factor1=0;
	}
	if(s1>=250 & s1<500)
	{
		fijo1=300;
		factor1=0;
	}
	if(s1>=500 & s1<800)
	{
		fijo1=600;
		factor1=0;
	}
	if(s1>=800)
	{
		fijo1=1000;
		factor1=.35;
	}
	Comision1=factor1*s1;
	Pagar1=parseFloat(Comision1)+parseFloat(fijo1);

if(s2<250)
	{
		fijo2=0;
		factor2=0;
	}
	if(s2>=250 & s2<500)
	{
		fijo2=300;
		factor2=0;
	}
	if(s2>=500 & s2<800)
	{
		fijo2=600;
		factor2=0;
	}
	if(s2>=800)
	{
		fijo2=1000;
		factor2=.35;
	}
	Comision2=factor2*s2;
	Pagar2=parseFloat(Comision2)+parseFloat(fijo2);

	if(s3<250)
	{
		fijo3=0;
		factor3=0;
	}
	if(s3>=250 & s3<500)
	{
		fijo3=300;
		factor3=0;
	}
	if(s3>=500 & s3<800)
	{
		fijo3=600;
		factor3=0;
	}
	if(s3>=800)
	{
		fijo3=1000;
		factor3=.35;
	}
	Comision3=factor3*s3;
	Pagar3=parseFloat(Comision3)+parseFloat(fijo3);

	if(s4<250)
	{
		fijo4=0;
		factor4=0;
	}
	if(s4>=250 & s4<500)
	{
		fijo4=300;
		factor4=0;
	}
	if(s4>=500 & s4<800)
	{
		fijo4=600;
		factor4=0;
	}
	if(s4>=800)
	{
		fijo4=1000;
		factor4=.35;
	}
	Comision4=factor4*s4;
	Pagar4=parseFloat(Comision4)+parseFloat(fijo4);


	totalfijo=parseFloat(fijo1)+parseFloat(fijo2)+parseFloat(fijo3)+parseFloat(fijo4);
	totalfactor=parseFloat(factor1)+parseFloat(factor2)+parseFloat(factor3)+parseFloat(factor4);
	totalcomision=parseFloat(Comision1)+parseFloat(Comision2)+parseFloat(Comision3)+parseFloat(Comision4);
	totalPagar=parseFloat(Pagar1)+parseFloat(Pagar2)+parseFloat(Pagar3)+parseFloat(Pagar4);

var totalventa=parseFloat(totala)+parseFloat(totalb)+parseFloat(totalc);

if(totalventa<4000)
{
factor612=0
factor18=0
factor24=0
}

if(totalventa>=4000 & totalventa<6000)
{
factor612=0
factor18=0.4
factor24=0.5
}

if(totalventa>=6000 & totalventa<8000)
{
factor612=0
factor18=0.6
factor24=0.8
}

if(totalventa>=8000)
{
factor612=0
factor18=1
factor24=1.2
}

comision612=factor612*totala
comision18=factor18*totalb
comision24=factor24*totalc

sumacomision=parseFloat(comision612)+parseFloat(comision18)+parseFloat(comision24);

if(sumacomision>=totalcomision)
complemento=parseFloat(sumacomision)-parseFloat(totalcomision);
else
complemento=0;

CobroTotal=parseFloat(complemento)+parseFloat(totalPagar);

$("#totala").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');
$("#totalb").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalb,0)+'</div>');
$("#totalc").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalc,0)+'</div>');

$("#tventa1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s1,0)+'</div>');
$("#tventa2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s2,0)+'</div>');
$("#tventa3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s3,0)+'</div>');
$("#tventa4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s4,0)+'</div>');
$("#totaltventa").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#fijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo1,0)+'</div>');
$("#fijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo2,0)+'</div>');
$("#fijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo3,0)+'</div>');
$("#fijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo4,0)+'</div>');
$("#totalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijo,0)+'</div>');

$("#factor1").html(factor1,0);
$("#factor2").html(factor2,0);
$("#factor3").html(factor3,0);
$("#factor4").html(factor4,0);
//$("#totalfactor").html(totalfactor,0);

$("#Comision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision1,0)+'</div>');
$("#Comision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision2,0)+'</div>');
$("#Comision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision3,0)+'</div>');
$("#Comision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision4,0)+'</div>');
$("#totalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision,0)+'</div>');

$("#Pagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar1,0)+'</div>');
$("#Pagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar2,0)+'</div>');
$("#Pagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar3,0)+'</div>');
$("#Pagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar4,0)+'</div>');
$("#totalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalPagar,0)+'</div>');

$("#bonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#mensual612").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');
$("#mensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalb,0)+'</div>');
$("#mensual24").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalc,0)+'</div>');

$("#factor612").html(factor612,0);
$("#factor18").html(factor18,0);
$("#factor24").html(factor24,0);

$("#comision612").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision612,0)+'</div>');
$("#comision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision18,0)+'</div>');
$("#comision24").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision24,0)+'</div>');

$("#sumacomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(sumacomision,0)+'</div>');
$("#comisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision*-1,0)+'</div>');
$("#complemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#CobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CobroTotal,0)+'</div>');
}



function calculaEsquema2(){
clearCalculo();

if($("#a1").attr("value")=='')
	$("#a1").val("0");
if($("#a2").attr("value")=='')
	$("#a2").val("0");
if($("#a3").attr("value")=='')
	$("#a3").val("0");
if($("#a4").attr("value")=='')
	$("#a4").val("0");
if($("#b1").attr("value")=='')
	$("#b1").val("0");
if($("#b2").attr("value")=='')
	$("#b2").val("0");
if($("#b3").attr("value")=='')
	$("#b3").val("0");
if($("#b4").attr("value")=='')
	$("#b4").val("0");
if($("#c1").attr("value")=='')
	$("#c1").val("0");
if($("#c2").attr("value")=='')
	$("#c2").val("0");
if($("#c3").attr("value")=='')
	$("#c3").val("0");
if($("#c4").attr("value")=='')
	$("#c4").val("0");


	var s1=parseFloat($("#a1").attr("value"))
	var s2=parseFloat($("#a2").attr("value"))
	var s3=parseFloat($("#a3").attr("value"))
	var s4=parseFloat($("#a4").attr("value"))

	totala=parseFloat($("#a1").attr("value"))+parseFloat($("#a2").attr("value"))+parseFloat($("#a3").attr("value"))+parseFloat($("#a4").attr("value"));


	factor1=0;
	factor2=0;
	factor3=0;
	factor4=0;

	fijo1=800;
	fijo2=800;
	fijo3=800;
	fijo4=800;

	if(s1>=4000 & s1<5000)
	{
		fijo1=800;
		factor1=0.1;
	}

	if(s1>=5000 & s1<7000)
	{
		fijo1=2000;
		factor1=0.1;
	}

	if(s1>=7000)
	{
		fijo1=2500;
		factor1=0.1;
	}

	Comision1=factor1*s1;
	Pagar1=parseFloat(Comision1)+parseFloat(fijo1);

	if(s2>=4000 & s2<5000)
	{
		fijo2=800;
		factor2=0.1;
	}

	if(s2>=5000 & s2<7000)
	{
		fijo2=2000;
		factor2=0.1;
	}

	if(s2>=7000)
	{
		fijo2=2500;
		factor2=0.1;
	}

	Comision2=factor2*s2;
	Pagar2=parseFloat(Comision2)+parseFloat(fijo2);

	if(s3>=4000 & s3<5000)
	{
		fijo3=800;
		factor3=0.1;
	}


	if(s3>=5000 & s3<7000)
	{
		fijo3=2000;
		factor3=0.1;
	}

	if(s3>=7000)
	{
		fijo3=2500;
		factor3=0.1;
	}

	Comision3=factor3*s3;
	Pagar3=parseFloat(Comision3)+parseFloat(fijo3);

	if(s4>=4000 & s4<5000)
	{
		fijo4=800;
		factor4=0.1;
	}


	if(s4>=5000 & s4<7000)
	{
		fijo4=2000;
		factor4=0.1;
	}

	if(s4>=7000)
	{
		fijo4=2500;
		factor4=0.1;
	}

	Comision4=factor4*s4;
	Pagar4=parseFloat(Comision4)+parseFloat(fijo4);


	totalfijo=parseFloat(fijo1)+parseFloat(fijo2)+parseFloat(fijo3)+parseFloat(fijo4);
	totalfactor=parseFloat(factor1)+parseFloat(factor2)+parseFloat(factor3)+parseFloat(factor4);
	totalcomision=parseFloat(Comision1)+parseFloat(Comision2)+parseFloat(Comision3)+parseFloat(Comision4);
	totalPagar=parseFloat(Pagar1)+parseFloat(Pagar2)+parseFloat(Pagar3)+parseFloat(Pagar4);

var totalventa=parseFloat(totala);


if(totalventa<20000)
{
factor18=0
}

if(totalventa>=20000 & totalventa<25000)
{
factor18=totalventa*.3
}

if(totalventa>=25000 & totalventa<30000)
{
factor18=totalventa*.35
}

if(totalventa>=30000)
{
//factor18=10000
  factor18=totalventa*.45
}


comision18=factor18


if(comision18>=totalcomision)
complemento=parseFloat(comision18)-parseFloat(totalcomision);
else
complemento=0;


CobroTotal=parseFloat(complemento)+parseFloat(totalPagar);


$("#totala").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');

$("#tventa1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s1,0)+'</div>');
$("#tventa2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s2,0)+'</div>');
$("#tventa3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s3,0)+'</div>');
$("#tventa4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s4,0)+'</div>');
$("#totaltventa").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#fijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo1,0)+'</div>');
$("#fijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo2,0)+'</div>');
$("#fijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo3,0)+'</div>');
$("#fijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo4,0)+'</div>');
$("#totalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijo,0)+'</div>');

$("#factor1").html(factor1,0);
$("#factor2").html(factor2,0);
$("#factor3").html(factor3,0);
$("#factor4").html(factor4,0);
//$("#totalfactor").html(totalfactor,2);

$("#Comision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision1,0)+'</div>');
$("#Comision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision2,0)+'</div>');
$("#Comision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision3,0)+'</div>');
$("#Comision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision4,0)+'</div>');
$("#totalcomision").html('<div ="signo">$</div><div class="pesos">'+formato_numero(totalcomision,0)+'</div>');

$("#Pagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar1,0)+'</div>');
$("#Pagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar2,0)+'</div>');
$("#Pagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar3,0)+'</div>');
$("#Pagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar4,0)+'</div>');
$("#totalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalPagar,0)+'</div>');

$("#bonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#mensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');

$("#factor18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(factor18,0)+'</div>');

$("#comision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision18,0)+'</div>');

$("#comisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision*-1,0)+'</div>');
$("#complemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#CobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CobroTotal,0)+'</div>');
}

function calculaEsquema3(){

clearCalculo();
if($("#a1").attr("value")=='')
	$("#a1").val("0");
if($("#a2").attr("value")=='')
	$("#a2").val("0");
if($("#a3").attr("value")=='')
	$("#a3").val("0");
if($("#a4").attr("value")=='')
	$("#a4").val("0");
if($("#b1").attr("value")=='')
	$("#b1").val("0");
if($("#b2").attr("value")=='')
	$("#b2").val("0");
if($("#b3").attr("value")=='')
	$("#b3").val("0");
if($("#b4").attr("value")=='')
	$("#b4").val("0");
if($("#c1").attr("value")=='')
	$("#c1").val("0");
if($("#c2").attr("value")=='')
	$("#c2").val("0");
if($("#c3").attr("value")=='')
	$("#c3").val("0");
if($("#c4").attr("value")=='')
	$("#c4").val("0");


	var s1=parseFloat($("#a1").attr("value"))
	var s2=parseFloat($("#a2").attr("value"))
	var s3=parseFloat($("#a3").attr("value"))
	var s4=parseFloat($("#a4").attr("value"))

	totala=parseFloat($("#a1").attr("value"))+parseFloat($("#a2").attr("value"))+parseFloat($("#a3").attr("value"))+parseFloat($("#a4").attr("value"));


	factor1=0;
	factor2=0;
	factor3=0;
	factor4=0;

	fijo1=800;
	fijo2=800;
	fijo3=800;
	fijo4=800;


	if(s1<3000 & s1>=2000)
	{
		fijo1=800;
		factor1=0.1;
	}


	if(s1>=3000 & s1<5000)
	{
		fijo1=1650;
		factor1=0.1;
	}

	if(s1>=5000)
	{
		fijo1=2000;
		factor1=0.1;
	}

	Comision1=factor1*s1;
	Pagar1=parseFloat(Comision1)+parseFloat(fijo1);

	if(s2<3000 & s2>=2000)
	{
		fijo2=800;
		factor2=0.1;
	}


	if(s2>=3000 & s2<5000)
	{
		fijo2=1650;
		factor2=0.1;
	}

	if(s2>=5000)
	{
		fijo2=2000;
		factor2=0.1;
	}

	Comision2=factor2*s2;
	Pagar2=parseFloat(Comision2)+parseFloat(fijo2);

	if(s3<3000 & s3>=2000)
	{
		fijo3=800;
		factor3=0.1;
	}


	if(s3>=3000 & s3<5000)
	{
		fijo3=1650;
		factor3=0.1;
	}

	if(s3>=5000)
	{
		fijo3=2000;
		factor3=0.1;
	}

	Comision3=factor3*s3;
	Pagar3=parseFloat(Comision3)+parseFloat(fijo3);

	if(s4<3000 & s4>=2000)
	{
		fijo4=800;
		factor4=0.1;
	}


	if(s4>=3000 & s4<5000)
	{
		fijo4=1650;
		factor4=0.1;
	}

	if(s4>=5000)
	{
		fijo4=2000;
		factor4=0.1;
	}

	Comision4=factor4*s4;
	Pagar4=parseFloat(Comision4)+parseFloat(fijo4);


	totalfijo=parseFloat(fijo1)+parseFloat(fijo2)+parseFloat(fijo3)+parseFloat(fijo4);
	totalfactor=parseFloat(factor1)+parseFloat(factor2)+parseFloat(factor3)+parseFloat(factor4);
	totalcomision=parseFloat(Comision1)+parseFloat(Comision2)+parseFloat(Comision3)+parseFloat(Comision4);
	totalPagar=parseFloat(Pagar1)+parseFloat(Pagar2)+parseFloat(Pagar3)+parseFloat(Pagar4);

var totalventa=parseFloat(totala);


if(totalventa<13000)
{
factor18=0
}

if(totalventa>=13000 & totalventa<17000)
{
factor18=totalventa*.3
}

if(totalventa>=17000 & totalventa<20000)
{
factor18=totalventa*.35
}

if(totalventa>=20000)
{
factor18=totalventa*.45
}


comision18=factor18



if(comision18>=totalcomision)
complemento=parseFloat(comision18)-parseFloat(totalcomision);
else
complemento=0;


CobroTotal=parseFloat(complemento)+parseFloat(totalPagar);


$("#totala").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');

$("#tventa1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s1,0)+'</div>');
$("#tventa2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s2,0)+'</div>');
$("#tventa3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s3,0)+'</div>');
$("#tventa4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s4,0)+'</div>');
$("#totaltventa").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#fijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo1,0)+'</div>');
$("#fijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo2,0)+'</div>');
$("#fijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo3,0)+'</div>');
$("#fijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo4,0)+'</div>');
$("#totalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijo,0)+'</div>');

$("#factor1").html(factor1,0);
$("#factor2").html(factor2,0);
$("#factor3").html(factor3,0);
$("#factor4").html(factor4,0);
//$("#totalfactor").html(totalfactor,2);

$("#Comision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision1,0)+'</div>');
$("#Comision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision2,0)+'</div>');
$("#Comision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision3,0)+'</div>');
$("#Comision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision4,0)+'</div>');
$("#totalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision,0)+'</div>');

$("#Pagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar1,0)+'</div>');
$("#Pagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar2,0)+'</div>');
$("#Pagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar3,0)+'</div>');
$("#Pagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar4,0)+'</div>');
$("#totalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalPagar,0)+'</div>');

$("#bonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#mensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');

$("#factor18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(factor18,0)+'</div>');

$("#comision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision18,0)+'</div>');

$("#comisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision*-1,0)+'</div>');
$("#complemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#CobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CobroTotal,0)+'</div>');

}

function calculaEsquema4(){

clearCalculo();

if($("#a1").attr("value")=='')
	$("#a1").val("0");
if($("#a2").attr("value")=='')
	$("#a2").val("0");
if($("#a3").attr("value")=='')
	$("#a3").val("0");
if($("#a4").attr("value")=='')
	$("#a4").val("0");
if($("#b1").attr("value")=='')
	$("#b1").val("0");
if($("#b2").attr("value")=='')
	$("#b2").val("0");
if($("#b3").attr("value")=='')
	$("#b3").val("0");
if($("#b4").attr("value")=='')
	$("#b4").val("0");
if($("#c1").attr("value")=='')
	$("#c1").val("0");
if($("#c2").attr("value")=='')
	$("#c2").val("0");
if($("#c3").attr("value")=='')
	$("#c3").val("0");
if($("#c4").attr("value")=='')
	$("#c4").val("0");


	var s1=parseFloat($("#a1").attr("value"))
	var s2=parseFloat($("#a2").attr("value"))
	var s3=parseFloat($("#a3").attr("value"))
	var s4=parseFloat($("#a4").attr("value"))

	totala=parseFloat($("#a1").attr("value"))+parseFloat($("#a2").attr("value"))+parseFloat($("#a3").attr("value"))+parseFloat($("#a4").attr("value"));


	factor1=0;
	factor2=0;
	factor3=0;
	factor4=0;

	fijo1=800;
	fijo2=800;
	fijo3=800;
	fijo4=800;

	if(s1<3000 & s1>=1500)
	{
		fijo1=800;
		factor1=.10
	}


	if(s1>=3000)
	{
		fijo1=1000;
		factor1=.10;
	}

	Comision1=factor1*s1;
	Pagar1=parseFloat(Comision1)+parseFloat(fijo1);

	if(s2<3000 & s2>=1500)
	{
		fijo2=800;
		factor2=.10
	}


	if(s2>=3000)
	{
		fijo2=1000;
		factor2=.10;
	}

	Comision2=factor2*s2;
	Pagar2=parseFloat(Comision2)+parseFloat(fijo2);


	if(s3<3000 & s3>=1500)
	{
		fijo3=800;
		factor3=.10
	}


	if(s3>=3000)
	{
		fijo3=1000;
		factor3=.10;
	}

	Comision3=factor3*s3;
	Pagar3=parseFloat(Comision3)+parseFloat(fijo3);

	if(s4<3000 & s4>=1500)
	{
		fijo4=800;
		factor4=.10
	}


	if(s4>=3000)
	{
		fijo4=1000;
		factor4=.10;
	}

	Comision4=factor4*s4;
	Pagar4=parseFloat(Comision4)+parseFloat(fijo4);


	totalfijo=parseFloat(fijo1)+parseFloat(fijo2)+parseFloat(fijo3)+parseFloat(fijo4);
	totalfactor=parseFloat(factor1)+parseFloat(factor2)+parseFloat(factor3)+parseFloat(factor4);
	totalcomision=parseFloat(Comision1)+parseFloat(Comision2)+parseFloat(Comision3)+parseFloat(Comision4);
	totalPagar=parseFloat(Pagar1)+parseFloat(Pagar2)+parseFloat(Pagar3)+parseFloat(Pagar4);

var totalventa=parseFloat(totala);


if(totalventa<10000)
{
factor18=0
}

if(totalventa>=10000 & totalventa<15000)
{
factor18=totalventa*.3
}

if(totalventa>=15000 & totalventa<18000)
{
factor18=totalventa*.35
}

if(totalventa>=18000)
{
factor18=totalventa*.45
}


comision18=factor18



if(comision18>=totalcomision)
complemento=parseFloat(comision18)-parseFloat(totalcomision);
else
complemento=0;


CobroTotal=parseFloat(complemento)+parseFloat(totalPagar);


$("#totala").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');

$("#tventa1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s1,0)+'</div>');
$("#tventa2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s2,0)+'</div>');
$("#tventa3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s3,0)+'</div>');
$("#tventa4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s4,0)+'</div>');
$("#totaltventa").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#fijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo1,0)+'</div>');
$("#fijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo2,0)+'</div>');
$("#fijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo3,0)+'</div>');
$("#fijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo4,0)+'</div>');
$("#totalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijo,0)+'</div>');

$("#factor1").html(factor1,0);
$("#factor2").html(factor2,0);
$("#factor3").html(factor3,0);
$("#factor4").html(factor4,0);

$("#Comision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision1,0)+'</div>');
$("#Comision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision2,0)+'</div>');
$("#Comision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision3,0)+'</div>');
$("#Comision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision4,0)+'</div>');
$("#totalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision,0)+'</div>');

$("#Pagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar1,0)+'</div>');
$("#Pagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar2,0)+'</div>');
$("#Pagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar3,0)+'</div>');
$("#Pagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar4,0)+'</div>');
$("#totalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalPagar,0))+'</div>';

$("#bonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#mensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');

$("#factor18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(factor18,0)+'</div>');

$("#comision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision18,0)+'</div>');

$("#comisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision*-1,0)+'</div>');
$("#complemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#CobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CobroTotal,0)+'</div>');
}

function calculaEsquema5(){

clearCalculo();

if($("#a1").attr("value")=='')
  $("#a1").val("0");
if($("#a2").attr("value")=='')
  $("#a2").val("0");
if($("#a3").attr("value")=='')
  $("#a3").val("0");
if($("#a4").attr("value")=='')
  $("#a4").val("0");
if($("#b1").attr("value")=='')
  $("#b1").val("0");
if($("#b2").attr("value")=='')
  $("#b2").val("0");
if($("#b3").attr("value")=='')
  $("#b3").val("0");
if($("#b4").attr("value")=='')
  $("#b4").val("0");
if($("#c1").attr("value")=='')
  $("#c1").val("0");
if($("#c2").attr("value")=='')
  $("#c2").val("0");
if($("#c3").attr("value")=='')
  $("#c3").val("0");
if($("#c4").attr("value")=='')
  $("#c4").val("0");


  var s1=parseFloat($("#a1").attr("value"))
  var s2=parseFloat($("#a2").attr("value"))
  var s3=parseFloat($("#a3").attr("value"))
  var s4=parseFloat($("#a4").attr("value"))

  var sb1=parseFloat($("#b1").attr("value"))
  var sb2=parseFloat($("#b2").attr("value"))
  var sb3=parseFloat($("#b3").attr("value"))
  var sb4=parseFloat($("#b4").attr("value"))

  totala=parseFloat($("#a1").attr("value"))+parseFloat($("#a2").attr("value"))+parseFloat($("#a3").attr("value"))+parseFloat($("#a4").attr("value"));
  totalb=parseFloat($("#b1").attr("value"))+parseFloat($("#b2").attr("value"))+parseFloat($("#b3").attr("value"))+parseFloat($("#b4").attr("value"));

  factor1=0;
  factor2=0;
  factor3=0;
  factor4=0;

  fijo1=3000;
  fijo2=3000;
  fijo3=3000;
  fijo4=3000;

  factors1=0;
  factors2=0;
  factors3=0;
  factors4=0;

  fijos1=0;
  fijos2=0;
  fijos3=0;
  fijos4=0;

  if(s1>=12000)
  {
    factors1=.03
    fijos1=sb1*.03
  }

  if(s1<18000 & s1>=12000)
  {
    factor1=.03
  }

  if(s1<20000 & s1>=18000)
  {
    fijo1=4000;
    factor1=.03
  }

  if(s1>=20000)
  {
    fijo1=5000;
    factor1=.03
  }



  Comision1=factor1*s1;
  Pagar1=parseFloat(Comision1)+parseFloat(fijo1);

  if(s2>=12000)
  {
    factors2=.03
    fijos2=sb2*.03
  }

  if(s2<18000 & s2>=12000)
  {
    factor2=.03
  }

  if(s2<20000 & s2>=18000)
  {
    fijo2=4000;
    factor2=.03
  }


  if(s2>=20000)
  {
    fijo2=5000;
    factor2=.03
  }

  Comision2=factor2*s2;
  Pagar2=parseFloat(Comision2)+parseFloat(fijo2);

  if(s3>=12000)
  {
    factors3=.03
    fijos3=sb3*.03
  }

  if(s3<18000 & s3>=12000)
  {
    factor3=.03
  }

  if(s3<20000 & s3>=18000)
  {
    fijo3=4000;
    factor3=.03
  }


  if(s3>=20000)
  {
    fijo3=5000;
    factor3=.03
  }

  Comision3=factor3*s3;
  Pagar3=parseFloat(Comision3)+parseFloat(fijo3);

  if(s4>=12000)
  {
    factors4=.03
    fijos4=sb4*.03
  }

  if(s4<18000 & s4>=12000)
  {
    factor4=.03
  }

  if(s4<20000 & s4>=18000)
  {
    fijo4=4000;
    factor4=.03
  }


  if(s4>=20000)
  {
    fijo4=5000;
    factor4=.03
  }

  Comision4=factor4*s4;
  Pagar4=parseFloat(Comision4)+parseFloat(fijo4);


  totalfijo=parseFloat(fijo1)+parseFloat(fijo2)+parseFloat(fijo3)+parseFloat(fijo4);
  totalfijos=parseFloat(fijos1)+parseFloat(fijos2)+parseFloat(fijos3)+parseFloat(fijos4);
  totalfactor=parseFloat(factor1)+parseFloat(factor2)+parseFloat(factor3)+parseFloat(factor4);
  totalcomision=parseFloat(Comision1)+parseFloat(Comision2)+parseFloat(Comision3)+parseFloat(Comision4);
  totalPagar=parseFloat(Pagar1)+parseFloat(Pagar2)+parseFloat(Pagar3)+parseFloat(Pagar4);

var totalventa=parseFloat(totala);


if(totalventa<60000)
{
factor18=0
}

if(totalventa>=60000 & totalventa<80000)
{
factor18=totalventa*.05
}

if(totalventa>=80000 & totalventa<100000)
{
factor18=totalventa*.10
}

if(totalventa>=100000)
{
factor18=totalventa*.20
}


comision18=factor18



if(comision18>=totalcomision)
complemento=parseFloat(comision18)-parseFloat(totalcomision);
else
complemento=0;


CobroTotal=parseFloat(complemento)+parseFloat(totalPagar);


$("#totala").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');

$("#tventa1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s1,0)+'</div>');
$("#tventa2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s2,0)+'</div>');
$("#tventa3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s3,0)+'</div>');
$("#tventa4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s4,0)+'</div>');
$("#totaltventa").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#fijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo1,0)+'</div>');
$("#fijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo2,0)+'</div>');
$("#fijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo3,0)+'</div>');
$("#fijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo4,0)+'</div>');
$("#totalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijo,0)+'</div>');

$("#factor1").html(factor1,0);
$("#factor2").html(factor2,0);
$("#factor3").html(factor3,0);
$("#factor4").html(factor4,0);

$("#fijos1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijos1,0)+'</div>');
$("#fijos2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijos2,0)+'</div>');
$("#fijos3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijos3,0)+'</div>');
$("#fijos4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijos4,0)+'</div>');
$("#totalfijos").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijos,0)+'</div>');

$("#factors1").html(factors1,0);
$("#factors2").html(factors2,0);
$("#factors3").html(factors3,0);
$("#factors4").html(factors4,0);

$("#PagoSub").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijos,0)+'</div>');

$("#Comision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision1,0)+'</div>');
$("#Comision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision2,0)+'</div>');
$("#Comision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision3,0)+'</div>');
$("#Comision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision4,0)+'</div>');
$("#totalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision,0)+'</div>');

$("#Pagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar1,0)+'</div>');
$("#Pagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar2,0)+'</div>');
$("#Pagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar3,0)+'</div>');
$("#Pagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar4,0)+'</div>');
$("#totalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalPagar,0))+'</div>';

$("#bonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#mensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totala,0)+'</div>');

$("#factor18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(factor18,0)+'</div>');

$("#comision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision18,0)+'</div>');

$("#comisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision*-1,0)+'</div>');
$("#complemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#CobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CobroTotal+totalfijos,0)+'</div>');
}


function calculaComparativo(){

	if($("#b1").attr("value")=='')
		$("#b1").val("0");
	if($("#b2").attr("value")=='')
		$("#b2").val("0");
	if($("#b3").attr("value")=='')
		$("#b3").val("0");
	if($("#b4").attr("value")=='')
		$("#b4").val("0");
	if($("#c1").attr("value")=='')
		$("#c1").val("0");
	if($("#c2").attr("value")=='')
		$("#c2").val("0");
	if($("#c3").attr("value")=='')
		$("#c3").val("0");
	if($("#c4").attr("value")=='')
		$("#c4").val("0");

	var s1=parseFloat($("#b1").attr("value"))+parseFloat($("#c1").attr("value"));
	var s2=parseFloat($("#b2").attr("value"))+parseFloat($("#c2").attr("value"));
	var s3=parseFloat($("#b3").attr("value"))+parseFloat($("#c3").attr("value"));
	var s4=parseFloat($("#b4").attr("value"))+parseFloat($("#c4").attr("value"));

	totalb=parseFloat($("#b1").attr("value"))+parseFloat($("#b2").attr("value"))+parseFloat($("#b3").attr("value"))+parseFloat($("#b4").attr("value"));
	totalc=parseFloat($("#c1").attr("value"))+parseFloat($("#c2").attr("value"))+parseFloat($("#c3").attr("value"))+parseFloat($("#c4").attr("value"));

/*Ejecutivos*/
	if(s1<250)
	{
		Efijo1=0;
		Efactor1=0;
	}
	if(s1>=250 & s1<500)
	{
		Efijo1=300;
		Efactor1=0;
	}
	if(s1>=500 & s1<800)
	{
		Efijo1=600;
		Efactor1=0;
	}
	if(s1>=800)
	{
		Efijo1=1000;
		Efactor1=.35;
	}
	EComision1=Efactor1*s1;
	EPagar1=parseFloat(EComision1)+parseFloat(Efijo1);

if(s2<250)
	{
		Efijo2=0;
		Efactor2=0;
	}
	if(s2>=250 & s2<500)
	{
		Efijo2=300;
		Efactor2=0;
	}
	if(s2>=500 & s2<800)
	{
		Efijo2=600;
		Efactor2=0;
	}
	if(s2>=800)
	{
		Efijo2=1000;
		Efactor2=.35;
	}
	EComision2=Efactor2*s2;
	EPagar2=parseFloat(EComision2)+parseFloat(Efijo2);

	if(s3<250)
	{
		Efijo3=0;
		Efactor3=0;
	}
	if(s3>=250 & s3<500)
	{
		Efijo3=300;
		Efactor3=0;
	}
	if(s3>=500 & s3<800)
	{
		Efijo3=600;
		Efactor3=0;
	}
	if(s3>=800)
	{
		Efijo3=1000;
		Efactor3=.35;
	}
	EComision3=Efactor3*s3;
	EPagar3=parseFloat(EComision3)+parseFloat(Efijo3);

	if(s4<250)
	{
		Efijo4=0;
		Efactor4=0;
	}
	if(s4>=250 & s4<500)
	{
		Efijo4=300;
		Efactor4=0;
	}
	if(s4>=500 & s4<800)
	{
		Efijo4=600;
		Efactor4=0;
	}
	if(s4>=800)
	{
		Efijo4=1000;
		Efactor4=.35;
	}
	EComision4=Efactor4*s4;
	EPagar4=parseFloat(EComision4)+parseFloat(Efijo4);


	Etotalfijo=parseFloat(Efijo1)+parseFloat(Efijo2)+parseFloat(Efijo3)+parseFloat(Efijo4);
	Etotalfactor=parseFloat(Efactor1)+parseFloat(Efactor2)+parseFloat(Efactor3)+parseFloat(Efactor4);
	Etotalcomision=parseFloat(EComision1)+parseFloat(EComision2)+parseFloat(EComision3)+parseFloat(EComision4);
	EtotalPagar=parseFloat(EPagar1)+parseFloat(EPagar2)+parseFloat(EPagar3)+parseFloat(EPagar4);

var totalventa=parseFloat(totalb)+parseFloat(totalc);

if(totalventa<4000)
{
Efactor18=0
Efactor24=0
}

if(totalventa>=4000 & totalventa<6000)
{
Efactor18=0.4
Efactor24=0.5
}

if(totalventa>=6000 & totalventa<8000)
{
Efactor18=0.6
Efactor24=0.8
}

if(totalventa>=8000)
{
Efactor18=1
Efactor24=1.2
}

Ecomision18=Efactor18*totalb
Ecomision24=Efactor24*totalc

Esumacomision=parseFloat(Ecomision18)+parseFloat(Ecomision24);

if(Esumacomision>=Etotalcomision)
Ecomplemento=parseFloat(Esumacomision)-parseFloat(Etotalcomision);
else
Ecomplemento=0;

ECobroTotal=parseFloat(Ecomplemento)+parseFloat(EtotalPagar);



$("#totalb").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalb,0)+'</div>');
$("#totalc").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalc,0)+'</div>');

$("#tventa1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s1,0)+'</div>');
$("#tventa2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s2,0)+'</div>');
$("#tventa3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s3,0)+'</div>');
$("#tventa4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s4,0)+'</div>');
$("#totaltventa").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#Efijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Efijo1,0)+'</div>');
$("#Efijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Efijo2,0)+'</div>');
$("#Efijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Efijo3,0)+'</div>');
$("#Efijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Efijo4,0)+'</div>');
$("#Etotalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Etotalfijo,0)+'</div>');

$("#Efactor1").html(Efactor1,0);
$("#Efactor2").html(Efactor2,0);
$("#Efactor3").html(Efactor3,0);
$("#Efactor4").html(Efactor4,0);

$("#EComision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EComision1,0)+'</div>');
$("#EComision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EComision2,0)+'</div>');
$("#EComision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EComision3,0)+'</div>');
$("#EComision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EComision4,0)+'</div>');
$("#Etotalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Etotalcomision,0)+'</div>');

$("#EPagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EPagar1,0)+'</div>');
$("#EPagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EPagar2,0)+'</div>');
$("#EPagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EPagar3,0)+'</div>');
$("#EPagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EPagar4,0)+'</div>');
$("#EtotalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(EtotalPagar,0)+'</div>');

$("#EbonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ecomplemento,0)+'</div>');
$("#Emensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalb,0)+'</div>');
$("#Emensual24").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalc,0)+'</div>');


$("#Efactor18").html(Efactor18,0);
$("#Efactor24").html(Efactor24,0);

$("#Ecomision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ecomision18,0)+'</div>');
$("#Ecomision24").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ecomision24,0)+'</div>');

$("#Esumacomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Esumacomision,0)+'</div>');
$("#Ecomisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Etotalcomision*-1,0)+'</div>');
$("#Ecomplemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ecomplemento,0)+'</div>');
$("#ECobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(ECobroTotal,0)+'</div>');

	Afactor1=0;
	Afactor2=0;
	Afactor3=0;
	Afactor4=0;

	Afijo1=800;
	Afijo2=800;
	Afijo3=800;
	Afijo4=800;

	if(s1>=4000 & s1<5000)
	{
		Afijo1=800;
		Afactor1=0.1;
	}

	if(s1>=5000 & s1<7000)
	{
		//Afijo1=1650;  este estaba activo
    Afijo1=2000;
		Afactor1=0.1;
	}

	if(s1>=7000)
	{
		Afijo1=2500;
		Afactor1=0.1;
	}

	AComision1=Afactor1*s1;
	APagar1=parseFloat(AComision1)+parseFloat(Afijo1);

	if(s2>=4000 & s2<5000)
	{
		Afijo2=800;
		Afactor2=0.1;
	}

	if(s2>=5000 & s2<7000)
	{
    //Afijo1=1650;  este estaba activo
    Afijo1=2000;
		Afactor2=0.1;
	}

	if(s2>=7000)
	{
		Afijo2=2500;
		Afactor2=0.1;
	}

	AComision2=Afactor2*s2;
	APagar2=parseFloat(AComision2)+parseFloat(Afijo2);

	if(s3>=4000 & s3<5000)
	{
		Afijo3=800;
		Afactor3=0.1;
	}


	if(s3>=5000 & s3<7000)
	{
    //Afijo1=1650;  este estaba activo
    Afijo1=2000;

		Afactor3=0.1;
	}

	if(s3>=7000)
	{
		Afijo3=2500;
		Afactor3=0.1;
	}

	AComision3=Afactor3*s3;
	APagar3=parseFloat(AComision3)+parseFloat(Afijo3);

	if(s4>=4000 & s4<5000)
	{
		Afijo4=800;
		Afactor4=0.1;
	}


	if(s4>=5000 & s4<7000)
	{
    //Afijo1=1650;  este estaba activo
    Afijo1=2000;

		Afactor4=0.1;
	}

	if(s4>=7000)
	{
		Afijo4=2500;
		Afactor4=0.1;
	}

	AComision4=Afactor4*s4;
	APagar4=parseFloat(AComision4)+parseFloat(Afijo4);


	Atotalfijo=parseFloat(Afijo1)+parseFloat(Afijo2)+parseFloat(Afijo3)+parseFloat(Afijo4);
	Atotalfactor=parseFloat(Afactor1)+parseFloat(Afactor2)+parseFloat(Afactor3)+parseFloat(Afactor4);
	Atotalcomision=parseFloat(AComision1)+parseFloat(AComision2)+parseFloat(AComision3)+parseFloat(AComision4);
	AtotalPagar=parseFloat(APagar1)+parseFloat(APagar2)+parseFloat(APagar3)+parseFloat(APagar4);




if(totalventa<20000)
{
Afactor18=0
}

if(totalventa>=20000 & totalventa<25000)
{
Afactor18=totalventa*.3
}

if(totalventa>=25000 & totalventa<30000)
{
Afactor18=totalventa*.35
}

if(totalventa>=30000)
{
//Afactor18=10000
Afactor18=totalventa*.45
}


Acomision18=Afactor18


if(Acomision18>=Atotalcomision)
Acomplemento=parseFloat(Acomision18)-parseFloat(Atotalcomision);
else
Acomplemento=0;


ACobroTotal=parseFloat(Acomplemento)+parseFloat(AtotalPagar);



$("#Afijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Afijo1,0)+'</div>');
$("#Afijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Afijo2,0)+'</div>');
$("#Afijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Afijo3,0)+'</div>');
$("#Afijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Afijo4,0)+'</div>');
$("#Atotalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Atotalfijo,0)+'</div>');

$("#Afactor1").html(Afactor1,0);
$("#Afactor2").html(Afactor2,0);
$("#Afactor3").html(Afactor3,0);
$("#Afactor4").html(Afactor4,0);
//$("#totalfactor").html(totalfactor,2);

$("#AComision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(AComision1,0)+'</div>');
$("#AComision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(AComision2,0)+'</div>');
$("#AComision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(AComision3,0)+'</div>');
$("#AComision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(AComision4,0)+'</div>');
$("#Atotalcomision").html('<div ="signo">$</div><div class="pesos">'+formato_numero(Atotalcomision,0)+'</div>');

$("#APagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(APagar1,0)+'</div>');
$("#APagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(APagar2,0)+'</div>');
$("#APagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(APagar3,0)+'</div>');
$("#APagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(APagar4,0)+'</div>');
$("#AtotalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(AtotalPagar,0)+'</div>');

$("#AbonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Acomplemento,0)+'</div>');
$("#Amensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#Afactor18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Afactor18,0)+'</div>');

$("#Acomision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Acomision18,0)+'</div>');

$("#Acomisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Atotalcomision*-1,0)+'</div>');
$("#Acomplemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Acomplemento,0)+'</div>');
$("#ACobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(ACobroTotal,0)+'</div>');

	Bfactor1=0;
	Bfactor2=0;
	Bfactor3=0;
	Bfactor4=0;

	Bfijo1=800;
	Bfijo2=800;
	Bfijo3=800;
	Bfijo4=800;


	if(s1<3000 & s1>=2000)
	{
		Bfijo1=800;
		Bfactor1=0.1;
	}


	if(s1>=3000 & s1<5000)
	{
		Bfijo1=1650;
		Bfactor1=0.1;
	}

	if(s1>=5000)
	{
		Bfijo1=2000;
		Bfactor1=0.1;
	}

	BComision1=Bfactor1*s1;
	BPagar1=parseFloat(BComision1)+parseFloat(Bfijo1);

	if(s2<3000 & s2>2000)
	{
		Bfijo2=800;
		Bfactor2=0.1;
	}


	if(s2>=3000 & s2<5000)
	{
		Bfijo2=1650;
		Bfactor2=0.1;
	}

	if(s2>=5000)
	{
		Bfijo2=2000;
		Bfactor2=0.1;
	}

	BComision2=Bfactor2*s2;
	BPagar2=parseFloat(BComision2)+parseFloat(Bfijo2);

	if(s3<3000 & s3>2000)
	{
		Bfijo3=800;
		Bfactor3=0.1;
	}


	if(s3>=3000 & s3<5000)
	{
		Bfijo3=1650;
		Bfactor3=0.1;
	}

	if(s3>=5000)
	{
		Bfijo3=2000;
		Bfactor3=0.1;
	}

	BComision3=Bfactor3*s3;
	BPagar3=parseFloat(BComision3)+parseFloat(Bfijo3);

	if(s4<3000 & s4>2000)
	{
		Bfijo4=800;
		Bfactor4=0.1;
	}


	if(s4>=3000 & s4<5000)
	{
		Bfijo4=1650;
		Bfactor4=0.1;
	}

	if(s4>=5000)
	{
		Bfijo4=2000;
		Bfactor4=0.1;
	}

	BComision4=Bfactor4*s4;
	BPagar4=parseFloat(BComision4)+parseFloat(Bfijo4);


	Btotalfijo=parseFloat(Bfijo1)+parseFloat(Bfijo2)+parseFloat(Bfijo3)+parseFloat(Bfijo4);
	Btotalfactor=parseFloat(Bfactor1)+parseFloat(Bfactor2)+parseFloat(Bfactor3)+parseFloat(Bfactor4);
	Btotalcomision=parseFloat(BComision1)+parseFloat(BComision2)+parseFloat(BComision3)+parseFloat(BComision4);
	BtotalPagar=parseFloat(BPagar1)+parseFloat(BPagar2)+parseFloat(BPagar3)+parseFloat(BPagar4);




if(totalventa<13000)
{
Bfactor18=0
}

if(totalventa>=13000 & totalventa<17000)
{
Bfactor18=totalventa*.3
}

if(totalventa>=17000 & totalventa<20000)
{
Bfactor18=totalventa*.35
}

if(totalventa>=20000)
{
//Bfactor18=10000
Bfactor18=totalventa*totalventa*.45
}


Bcomision18=Bfactor18



if(Bcomision18>=Btotalcomision)
Bcomplemento=parseFloat(Bcomision18)-parseFloat(Btotalcomision);
else
Bcomplemento=0;


BCobroTotal=parseFloat(Bcomplemento)+parseFloat(BtotalPagar);

$("#Bfijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Bfijo1,0)+'</div>');
$("#Bfijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Bfijo2,0)+'</div>');
$("#Bfijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Bfijo3,0)+'</div>');
$("#Bfijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Bfijo4,0)+'</div>');
$("#Btotalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Btotalfijo,0)+'</div>');

$("#Bfactor1").html(Bfactor1,0);
$("#Bfactor2").html(Bfactor2,0);
$("#Bfactor3").html(Bfactor3,0);
$("#Bfactor4").html(Bfactor4,0);
//$("#totalfactor").html(totalfactor,2);

$("#BComision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BComision1,0)+'</div>');
$("#BComision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BComision2,0)+'</div>');
$("#BComision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BComision3,0)+'</div>');
$("#BComision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BComision4,0)+'</div>');
$("#Btotalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Btotalcomision,0)+'</div>');

$("#BPagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BPagar1,0)+'</div>');
$("#BPagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BPagar2,0)+'</div>');
$("#BPagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BPagar3,0)+'</div>');
$("#BPagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BPagar4,0)+'</div>');
$("#BtotalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BtotalPagar,0)+'</div>');

$("#BbonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Bcomplemento,0)+'</div>');
$("#Bmensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#Bfactor18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Bfactor18,0)+'</div>');

$("#Bcomision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Bcomision18,0)+'</div>');

$("#Bcomisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Btotalcomision*-1,0)+'</div>');
$("#Bcomplemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Bcomplemento,0)+'</div>');
$("#BCobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(BCobroTotal,0)+'</div>');

	Cfactor1=0;
	Cfactor2=0;
	Cfactor3=0;
	Cfactor4=0;

	Cfijo1=800;
	Cfijo2=800;
	Cfijo3=800;
	Cfijo4=800;

	if(s1<3000 & s1>=1500)
	{
		Cfijo1=800;
		Cfactor1=.10
	}


	if(s1>=3000)
	{
		Cfijo1=1000;
		Cfactor1=.10;
	}

	CComision1=Cfactor1*s1;
	CPagar1=parseFloat(CComision1)+parseFloat(Cfijo1);

	if(s2<3000 & s2>=2000)
	{
		Cfijo2=800;
		Cfactor2=.10
	}


	if(s2>=3000)
	{
		Cfijo2=1000;
		Cfactor2=.10;
	}

	CComision2=Cfactor2*s2;
	CPagar2=parseFloat(CComision2)+parseFloat(Cfijo2);


	if(s3<3000 & s3>=2000)
	{
		Cfijo3=800;
		Cfactor3=.10
	}


	if(s3>=3000)
	{
		Cfijo3=1000;
		Cfactor3=.10;
	}

	CComision3=Cfactor3*s3;
	CPagar3=parseFloat(CComision3)+parseFloat(Cfijo3);

	if(s4<3000 & s4>=2000)
	{
		Cfijo4=800;
		Cfactor4=.10
	}


	if(s4>=3000)
	{
		Cfijo4=1000;
		Cfactor4=.10;
	}

	CComision4=Cfactor4*s4;
	CPagar4=parseFloat(CComision4)+parseFloat(Cfijo4);


	Ctotalfijo=parseFloat(Cfijo1)+parseFloat(Cfijo2)+parseFloat(Cfijo3)+parseFloat(Cfijo4);
	Ctotalfactor=parseFloat(Cfactor1)+parseFloat(Cfactor2)+parseFloat(Cfactor3)+parseFloat(Cfactor4);
	Ctotalcomision=parseFloat(CComision1)+parseFloat(CComision2)+parseFloat(CComision3)+parseFloat(CComision4);
	CtotalPagar=parseFloat(CPagar1)+parseFloat(CPagar2)+parseFloat(CPagar3)+parseFloat(CPagar4);



if(totalventa<10000)
{
Cfactor18=0
}

if(totalventa>=10000 & totalventa<15000)
{
Cfactor18=totalventa*.3
}

if(totalventa>=15000 & totalventa<18000)
{
Cfactor18=totalventa*.35
}

if(totalventa>=18000)
{
//Cfactor18=10000
Cfactor18=totalventa*.45

}


Ccomision18=Cfactor18



if(Ccomision18>=Ctotalcomision)
Ccomplemento=parseFloat(Ccomision18)-parseFloat(Ctotalcomision);
else
Ccomplemento=0;


CCobroTotal=parseFloat(Ccomplemento)+parseFloat(CtotalPagar);


$("#Cfijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Cfijo1,0)+'</div>');
$("#Cfijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Cfijo2,0)+'</div>');
$("#Cfijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Cfijo3,0)+'</div>');
$("#Cfijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Cfijo4,0)+'</div>');
$("#Ctotalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ctotalfijo,0)+'</div>');

$("#Cfactor1").html(Cfactor1,0);
$("#Cfactor2").html(Cfactor2,0);
$("#Cfactor3").html(Cfactor3,0);
$("#Cfactor4").html(Cfactor4,0);
//$("#totalfactor").html(totalfactor,2);

$("#CComision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CComision1,0)+'</div>');
$("#CComision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CComision2,0)+'</div>');
$("#CComision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CComision3,0)+'</div>');
$("#CComision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CComision4,0)+'</div>');
$("#Ctotalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ctotalcomision,0)+'</div>');

$("#CPagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CPagar1,0)+'</div>');
$("#CPagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CPagar2,0)+'</div>');
$("#CPagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CPagar3,0)+'</div>');
$("#CPagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CPagar4,0)+'</div>');
$("#CtotalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CtotalPagar,0))+'</div>';

$("#CbonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ccomplemento,0)+'</div>');
$("#Cmensual18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#Cfactor18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Cfactor18,0)+'</div>');

$("#Ccomision18").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ccomision18,0)+'</div>');

$("#Ccomisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ctotalcomision*-1,0)+'</div>');
$("#Ccomplemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Ccomplemento,0)+'</div>');
$("#CCobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CCobroTotal,0)+'</div>');
}



function calculoEsquemaTp1(){

clearCalculo();
if($("#b1").attr("value")=='')
  $("#b1").val("0");
if($("#b2").attr("value")=='')
  $("#b2").val("0");
if($("#b3").attr("value")=='')
  $("#b3").val("0");
if($("#b4").attr("value")=='')
  $("#b4").val("0");
if($("#c1").attr("value")=='')
  $("#c1").val("0");
if($("#c2").attr("value")=='')
  $("#c2").val("0");
if($("#c3").attr("value")=='')
  $("#c3").val("0");
if($("#c4").attr("value")=='')
  $("#c4").val("0");



  var s1=(parseFloat($("#b1").attr("value"))/2)+parseFloat($("#c1").attr("value"));
  var s2=(parseFloat($("#b2").attr("value"))/2)+parseFloat($("#c2").attr("value"));
  var s3=(parseFloat($("#b3").attr("value"))/2)+parseFloat($("#c3").attr("value"));
  var s4=(parseFloat($("#b4").attr("value"))/2)+parseFloat($("#c4").attr("value"));

  totalb=(parseFloat($("#b1").attr("value"))+parseFloat($("#b2").attr("value"))+parseFloat($("#b3").attr("value"))+parseFloat($("#b4").attr("value")))/2;
  totalc=parseFloat($("#c1").attr("value"))+parseFloat($("#c2").attr("value"))+parseFloat($("#c3").attr("value"))+parseFloat($("#c4").attr("value"));

factor1=0;
factor2=0;
factor3=0;
factor4=0;


  if(s1<340)
  {
    fijo1=0;
    factor1=0;
  }
  if(s1>=340 & s1<500)
    fijo1=300;

  if(s1>=344)
    factor1=0.30;

  if(s1>=500 & s1<800)
    fijo1=600;

  if(s1>=800)
  {
    fijo1=1000;
    factor1=0.50;
  }



  Comision1=factor1*s1;
  Pagar1=parseFloat(Comision1)+parseFloat(fijo1);

  if(s2<340)
  {
    fijo2=0;
    factor2=0;
  }
  if(s2>=340 & s2<500)
    fijo2=300;

  if(s2>=344)
    factor2=0.30;

  if(s2>=500 & s2<800)
    fijo2=600;

  if(s2>=800)
  {
    fijo2=1000;
    factor2=0.50;
  }

  Comision2=factor2*s2;
  Pagar2=parseFloat(Comision2)+parseFloat(fijo2);

  if(s3<340)
  {
    fijo3=0;
    factor3=0;
  }
  if(s3>=340 & s3<500)
    fijo3=300;

  if(s3>=344)
    factor3=0.30;

  if(s3>=500 & s3<800)
    fijo3=600;

  if(s3>=800)
  {
    fijo3=1000;
    factor3=0.50;
  }

  Comision3=factor3*s3;
  Pagar3=parseFloat(Comision3)+parseFloat(fijo3);

  if(s4<340)
  {
    fijo4=0;
    factor4=0;
  }
  if(s4>=340 & s4<500)
    fijo4=300;

  if(s4>=344)
    factor4=0.30;

  if(s4>=500 & s4<800)
    fijo4=600;

  if(s4>=800)
  {
    fijo4=1000;
    factor4=0.50;
  }

  Comision4=factor4*s4;
  Pagar4=parseFloat(Comision4)+parseFloat(fijo4);

  totalfijo=parseFloat(fijo1)+parseFloat(fijo2)+parseFloat(fijo3)+parseFloat(fijo4);
  totalfactor=parseFloat(factor1)+parseFloat(factor2)+parseFloat(factor3)+parseFloat(factor4);
  totalcomision=parseFloat(Comision1)+parseFloat(Comision2)+parseFloat(Comision3)+parseFloat(Comision4);
  totalPagar=parseFloat(Pagar1)+parseFloat(Pagar2)+parseFloat(Pagar3)+parseFloat(Pagar4);

var totalventa=parseFloat(totalb)+parseFloat(totalc);


if(totalventa<3000)
factor24=0

if(totalventa>=3000 & totalventa<5000)
factor24=0.7

if(totalventa>=5000 & totalventa<7000)
factor24=1

if(totalventa>=7000 & totalventa<10000)
factor24=1.3

if(totalventa>=10000)
factor24=1.5

comision24=factor24*totalc

sumacomision=parseFloat(comision24);

if(sumacomision>=totalcomision)
complemento=parseFloat(sumacomision)-parseFloat(totalcomision);
else
complemento=0;

CobroTotal=parseFloat(complemento)+parseFloat(totalPagar);

$("#totalb").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalb,0)+'</div>');
$("#totalc").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalc,0)+'</div>');

$("#tventa1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s1,0)+'</div>');
$("#tventa2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s2,0)+'</div>');
$("#tventa3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s3,0)+'</div>');
$("#tventa4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s4,0)+'</div>');
$("#totaltventa").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#fijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo1,0)+'</div>');
$("#fijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo2,0)+'</div>');
$("#fijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo3,0)+'</div>');
$("#fijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo4,0)+'</div>');
$("#totalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijo,0)+'</div>');

$("#factor1").html(factor1,0);
$("#factor2").html(factor2,0);
$("#factor3").html(factor3,0);
$("#factor4").html(factor4,0);
//$("#totalfactor").html(totalfactor,0);

$("#Comision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision1,0)+'</div>');
$("#Comision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision2,0)+'</div>');
$("#Comision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision3,0)+'</div>');
$("#Comision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision4,0)+'</div>');
$("#totalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision,0)+'</div>');

$("#Pagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar1,0)+'</div>');
$("#Pagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar2,0)+'</div>');
$("#Pagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar3,0)+'</div>');
$("#Pagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar4,0)+'</div>');
$("#totalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalPagar,0)+'</div>');

$("#bonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#mensual24").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#factor24").html(factor24,0);

$("#comision24").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision24,0)+'</div>');

$("#sumacomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(sumacomision,0)+'</div>');
$("#comisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision*-1,0)+'</div>');
$("#complemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#CobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CobroTotal,0)+'</div>');


$("#s1Real").html('<div class="signo">$</div><div class="pesos">'+formato_numero((parseFloat($("#b1").attr("value"))/2),0)+'</div>');
$("#s2Real").html('<div class="signo">$</div><div class="pesos">'+formato_numero((parseFloat($("#b2").attr("value"))/2),0)+'</div>');
$("#s3Real").html('<div class="signo">$</div><div class="pesos">'+formato_numero((parseFloat($("#b3").attr("value"))/2),0)+'</div>');
$("#s4Real").html('<div class="signo">$</div><div class="pesos">'+formato_numero((parseFloat($("#b4").attr("value"))/2),0)+'</div>');
$("#totalreal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalb,0)+'</div>');


}

function calculoEsquemaTp2(){
clearCalculo();
if($("#b1").attr("value")=='')
  $("#b1").val("0");
if($("#b2").attr("value")=='')
  $("#b2").val("0");
if($("#b3").attr("value")=='')
  $("#b3").val("0");
if($("#b4").attr("value")=='')
  $("#b4").val("0");
if($("#c1").attr("value")=='')
  $("#c1").val("0");
if($("#c2").attr("value")=='')
  $("#c2").val("0");
if($("#c3").attr("value")=='')
  $("#c3").val("0");
if($("#c4").attr("value")=='')
  $("#c4").val("0");



  var s1=(parseFloat($("#b1").attr("value"))/2)+parseFloat($("#c1").attr("value"));
  var s2=(parseFloat($("#b2").attr("value"))/2)+parseFloat($("#c2").attr("value"));
  var s3=(parseFloat($("#b3").attr("value"))/2)+parseFloat($("#c3").attr("value"));
  var s4=(parseFloat($("#b4").attr("value"))/2)+parseFloat($("#c4").attr("value"));

  totalb=(parseFloat($("#b1").attr("value"))+parseFloat($("#b2").attr("value"))+parseFloat($("#b3").attr("value"))+parseFloat($("#b4").attr("value")))/2;
  totalc=parseFloat($("#c1").attr("value"))+parseFloat($("#c2").attr("value"))+parseFloat($("#c3").attr("value"))+parseFloat($("#c4").attr("value"));

factor1=0;
factor2=0;
factor3=0;
factor4=0;

  if(s1<1000)
  {
    fijo1=0;
    factor1=0;
  }
  if(s1>=1000 & s1<2000)
    fijo1=500;

  if(s1>=2000 & s1<3000)
    fijo1=1000;

  if(s1>=2750)
    factor1=0.10;


  if(s1>=3000 & s1<4000)
    fijo1=1500;

  if(s1>=4000)
  {
    fijo1=2000;
    factor1=0.20;
  }



  Comision1=factor1*s1;
  Pagar1=parseFloat(Comision1)+parseFloat(fijo1);

  if(s2<1000)
  {
    fijo2=0;
    factor2=0;
  }
  if(s2>=1000 & s2<2000)
    fijo2=500;

  if(s2>=2000 & s2<3000)
    fijo2=1000;

  if(s2>=2750)
    factor2=0.10;


  if(s2>=3000 & s2<4000)
    fijo2=1500;

  if(s2>=4000)
  {
    fijo2=2000;
    factor2=0.20;
  }

  Comision2=factor2*s2;
  Pagar2=parseFloat(Comision2)+parseFloat(fijo2);

  if(s3<1000)
  {
    fijo3=0;
    factor3=0;
  }
  if(s3>=1000 & s3<2000)
    fijo3=500;

  if(s3>=2000 & s3<3000)
    fijo3=1000;

  if(s3>=2750)
    factor3=0.10;


  if(s3>=3000 & s3<4000)
    fijo3=1500;

  if(s3>=4000)
  {
    fijo3=2000;
    factor3=0.20;
  }

  Comision3=factor3*s3;
  Pagar3=parseFloat(Comision3)+parseFloat(fijo3);

  if(s4<1000)
  {
    fijo4=0;
    factor4=0;
  }
  if(s4>=1000 & s4<2000)
    fijo4=500;

  if(s4>=2000 & s4<3000)
    fijo4=1000;

  if(s4>=2750)
    factor4=0.10;


  if(s4>=3000 & s4<4000)
    fijo4=1500;

  if(s4>=4000)
  {
    fijo4=2000;
    factor4=0.20;
  }

  Comision4=factor4*s4;
  Pagar4=parseFloat(Comision4)+parseFloat(fijo4);

  totalfijo=parseFloat(fijo1)+parseFloat(fijo2)+parseFloat(fijo3)+parseFloat(fijo4);
  totalfactor=parseFloat(factor1)+parseFloat(factor2)+parseFloat(factor3)+parseFloat(factor4);
  totalcomision=parseFloat(Comision1)+parseFloat(Comision2)+parseFloat(Comision3)+parseFloat(Comision4);
  totalPagar=parseFloat(Pagar1)+parseFloat(Pagar2)+parseFloat(Pagar3)+parseFloat(Pagar4);

var totalventa=parseFloat(totalb)+parseFloat(totalc);


if(totalventa<10000)
factor24=0

if(totalventa>=10000 & totalventa<15000)
factor24=0.30

if(totalventa>=15000 & totalventa<30000)
factor24=0.40


if(totalventa>=30000)
factor24=0.50

comision24=factor24*totalc

sumacomision=parseFloat(comision24);

if(sumacomision>=totalcomision)
complemento=parseFloat(sumacomision)-parseFloat(totalcomision);
else
complemento=0;

CobroTotal=parseFloat(complemento)+parseFloat(totalPagar);

$("#totalb").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalb,0)+'</div>');
$("#totalc").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalc,0)+'</div>');

$("#tventa1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s1,0)+'</div>');
$("#tventa2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s2,0)+'</div>');
$("#tventa3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s3,0)+'</div>');
$("#tventa4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(s4,0)+'</div>');
$("#totaltventa").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#fijo1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo1,0)+'</div>');
$("#fijo2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo2,0)+'</div>');
$("#fijo3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo3,0)+'</div>');
$("#fijo4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(fijo4,0)+'</div>');
$("#totalfijo").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalfijo,0)+'</div>');

$("#factor1").html(factor1,0);
$("#factor2").html(factor2,0);
$("#factor3").html(factor3,0);
$("#factor4").html(factor4,0);
//$("#totalfactor").html(totalfactor,0);

$("#Comision1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision1,0)+'</div>');
$("#Comision2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision2,0)+'</div>');
$("#Comision3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision3,0)+'</div>');
$("#Comision4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Comision4,0)+'</div>');
$("#totalcomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision,0)+'</div>');

$("#Pagar1").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar1,0)+'</div>');
$("#Pagar2").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar2,0)+'</div>');
$("#Pagar3").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar3,0)+'</div>');
$("#Pagar4").html('<div class="signo">$</div><div class="pesos">'+formato_numero(Pagar4,0)+'</div>');
$("#totalPagar").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalPagar,0)+'</div>');

$("#bonoMensual").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#mensual24").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalventa,0)+'</div>');

$("#factor24").html(factor24,0);

$("#comision24").html('<div class="signo">$</div><div class="pesos">'+formato_numero(comision24,0)+'</div>');

$("#sumacomision").html('<div class="signo">$</div><div class="pesos">'+formato_numero(sumacomision,0)+'</div>');
$("#comisionanterior").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalcomision*-1,0)+'</div>');
$("#complemento").html('<div class="signo">$</div><div class="pesos">'+formato_numero(complemento,0)+'</div>');
$("#CobroTotal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(CobroTotal,0)+'</div>');

$("#s1Real").html('<div class="signo">$</div><div class="pesos">'+formato_numero((parseFloat($("#b1").attr("value"))/2),0)+'</div>');
$("#s2Real").html('<div class="signo">$</div><div class="pesos">'+formato_numero((parseFloat($("#b2").attr("value"))/2),0)+'</div>');
$("#s3Real").html('<div class="signo">$</div><div class="pesos">'+formato_numero((parseFloat($("#b3").attr("value"))/2),0)+'</div>');
$("#s4Real").html('<div class="signo">$</div><div class="pesos">'+formato_numero((parseFloat($("#b4").attr("value"))/2),0)+'</div>');
$("#totalreal").html('<div class="signo">$</div><div class="pesos">'+formato_numero(totalb,0)+'</div>');

}

function clearCalculo()
{

$("#totala").html("");

$("#tventa1").html("");
$("#tventa2").html("");
$("#tventa3").html("");
$("#tventa4").html("");
$("#totaltventa").html("");

$("#fijo1").html("");
$("#fijo2").html("");
$("#fijo3").html("");
$("#fijo4").html("");
$("#totalfijo").html("");

$("#factor1").html("");
$("#factor2").html("");
$("#factor3").html("");
$("#factor4").html("");
//$("#totalfactor").html(totalfactor,2);

$("#Comision1").html("");
$("#Comision2").html("");
$("#Comision3").html("");
$("#Comision4").html("");
$("#totalcomision").html("");

$("#Pagar1").html("");
$("#Pagar2").html("");
$("#Pagar3").html("");
$("#Pagar4").html("");
$("#totalPagar").html("");

$("#bonoMensual").html("");
$("#mensual18").html("");

$("#factor18").html("");

$("#comision18").html("");

$("#comisionanterior").html("");
$("#complemento").html("");
$("#CobroTotal").html("");
}

function cambioEstatus(obj)
  {
  if(obj.value==6)
    muestra('Fechas')
    else
    oculta('Fechas')
  }


  function oculta(id){
  var elDiv = document.getElementById(id); //se define la variable "elDiv" igual a nuestro div
      elDiv.style.display='none'; //damos un atributo display:none que oculta el div
    }

  function muestra(id){
    var elDiv = document.getElementById(id); //se define la variable "elDiv" igual a nuestro div
      elDiv.style.display='block';//damos un atributo display:block que  el div
  }

function verAvisos(dato)
{
 $.post("Display.php",{DatoId:dato, opc:5},
   function( data )
   {
      $("#Avisos").html('');
      $("#Avisos").html(data);
   }
   );
}

function guardaAviso()
{

  var extension = ($("#FileImport").val().substring($("#FileImport").val().lastIndexOf("."))).toLowerCase();
  var inputFile = document.getElementById("FileImport");//$("#FileImport");
  var file = inputFile.files[0];
  var titulo=$('#TituloAviso').attr("value");
  var aviso=$('#Aviso').attr("value");
  var claseificacionaviso=$("#ClasificacioAvisoId").attr("value");
  var FInicio=$("#FechaInicio").attr("value");
  var FFin=$("#FechaFin").attr("value");
  var clave=$("#Clave").attr("value");

  var data = new FormData();

  data.append('archivo',file);
  data.append('titulo', titulo);
  data.append('aviso', aviso);
  data.append('Clasificacion', claseificacionaviso);
  data.append('FInicio', FInicio);
  data.append('FFin', FFin);
  data.append('Opc', 3);
  data.append('ext', extension);
  data.append('clave', clave);

  var url = "Upload.php";
  $.ajax({
      url:url,
      type:'POST',
      contentType:false,
      data:data,
      processData:false,
      cache:false
      })
  .done(function( data, textStatus, jqXHR ) {
      pagina=jQuery(location).attr('href')
      location.href=pagina
   })
   .fail(function( jqXHR, textStatus, errorThrown ) {
       if ( console && console.log ) {
           $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro!</span>');
           return false;
       }
  });
}


function guardaRevisionBuro()
{

  var extension1 = ($("#FileImportIdentificacion").val().substring($("#FileImportIdentificacion").val().lastIndexOf("."))).toLowerCase();
  var inputFile1 = document.getElementById("FileImportIdentificacion");//$("#FileImport");
  var file1 = inputFile1.files[0];

  var extension2 = ($("#FileImportBuro").val().substring($("#FileImportBuro").val().lastIndexOf("."))).toLowerCase();
  var inputFile2 = document.getElementById("FileImportBuro");//$("#FileImport");
  var file2 = inputFile2.files[0];

  var TipoPersonaId=$('#TipoPersonaId').attr("value");
  var NombreC=$('#NombreC').attr("value");
  var PaternoC=$("#PaternoC").attr("value");
  var MaternoC=$("#MaternoC").attr("value");
  var RFCC=$("#RFCC").attr("value");
  var TLocal=$("#TLocal").attr("value");
  var TMovil=$("#TMovil").attr("value");
  var Calle=$("#Calle").attr("value");
  var NExterior=$("#NExterior").attr("value");
  var NInterior=$("#NInterior").attr("value");
  var ColoniaId=$("#ColoniaId").attr("value");
  var clave=$("#Clave").attr("value");

  var data = new FormData();

  data.append('archivo1',file1);
  data.append('archivo2',file2);
  data.append('ext1', extension1);
  data.append('ext2', extension2);
  data.append('TipoPersonaId', TipoPersonaId);
  data.append('NombreC', NombreC);
  data.append('PaternoC', PaternoC);
  data.append('MaternoC', MaternoC);
  data.append('RFCC', RFCC);

  data.append('TLocal', TLocal);
  data.append('TMovil', TMovil);
  data.append('Calle', Calle);
  data.append('NExterior', NExterior);
  data.append('NInterior', NInterior);
  data.append('ColoniaId', ColoniaId);
  data.append('clave', clave);

  data.append('Opc', 4);
  var url = "Upload.php";
  $.ajax({
      url:url,
      type:'POST',
      contentType:false,
      data:data,
      processData:false,
      cache:false
      })
  .done(function( data, textStatus, jqXHR ) {
      pagina=jQuery(location).attr('href')
      location.href=pagina
   })
   .fail(function( jqXHR, textStatus, errorThrown ) {
       if ( console && console.log ) {
           $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro!</span>');
           return false;
       }
  });
}

function guardarChecador()
{

  v1=$("#CoordinadorId").attr("value");
  v2=$("#pwd").attr("value");

  $.post("Acciones.php",{modulo:64, CoordinadorId:v1, Pwd:v2},function(datos){

    if(datos=='OK')
    {
      pagina=jQuery(location).attr('href')
      location.href=pagina
    }
    else
      $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro. Contraseña no valida!</span>');

  });
}

function sendNC(nc, user)
{
  $.post("Acciones.php",{NC:nc,  modulo:63, opc:1},function(datos)
    {
      if(datos=='OK')
        alert("Nueva contraseña para "+user+": 12345");
      else
        alert("No se realizo la operacion");
    });

}

function validaPunto()
{

  if($("#PuntoVentaId").attr("value")==0)
  {
    alert("Debes elegir el Punto de Venta")
    return false;
  }
  return true;
}

function validaPunto()
{

  if($("#PuntoVentaId").attr("value")==0)
  {
    alert("Debes elegir el Punto de Venta")
    return false;
  }
  return true;
}


function guardaRecarga()
{

  var extension1 = ($("#FileIfe").val().substring($("#FileIfe").val().lastIndexOf("."))).toLowerCase();
  var inputFile1 = document.getElementById("FileIfe");
  var file1 = inputFile1.files[0];

  $("#resultados").html('');
  v1=$("#PuntoVentaId").attr("value");
  v2=$("#VendedorId").attr("value");
  v3=$("#CoordinadorId").attr("value");
  v4=$("#Comentarios").attr("value");
  v5=$("#Folio").attr("value");
  v6=$("#CompaniaId").attr("value");
  v7=$("#MontoRecargaId").attr("value");
  v8=$("#NTel").attr("value");
  v9=$("#SIM").attr("value");
  v10=$("#PortabilidadId").attr("value");
  v11=$("#NTelP").attr("value");
  v12=$("#Nip").attr("value");
  v13=$("#Nombre").attr("value");
  v14=$("#Materno").attr("value");
  v15=$("#Paterno").attr("value");
  v16=$("#TelContacto").attr("value");
  v17=$("#MailContacto").attr("value");

var clave=$("#Clave").attr("value");
  var data = new FormData();

  data.append('archivo1',file1);
  data.append('ext1', extension1);

  data.append('PuntoVentaId', v1);
  data.append('VendedorId', v2);
  data.append('CoordinadorId', v3);
  data.append('Comentario', v4);
  data.append('Folio', v5);
  data.append('CompaniaId', v6);
  data.append('MontoRecargaId', v7);
  data.append('NTel', v8);
  data.append('Serie', v9);
  data.append('CompaniaPId', v10);
  data.append('NTelP', v11);
  data.append('Nip', v12);
  data.append('Nombre', v13);
  data.append('Materno', v14);
  data.append('Paterno', v15);
  data.append('TelContacto', v16);
  data.append('MailContacto', v17);
  data.append('clave', clave);

  data.append('Opc', 7);
  var url = "Upload.php";
  $.ajax({
      url:url,
      type:'POST',
      contentType:false,
      data:data,
      processData:false,
      cache:false
      })
  .done(function( data, textStatus, jqXHR ) {
$("#resultados").html(data);

  //    pagina=jQuery(location).attr('href')
//     location.href=pagina
   })
   .fail(function( jqXHR, textStatus, errorThrown ) {
       if ( console && console.log ) {
           $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro!</span>');
           return false;
       }
  });
}


function guardaDeposito()
{

  var extension1 = ($("#FileImportFicha").val().substring($("#FileImportFicha").val().lastIndexOf("."))).toLowerCase();
  var inputFile1 = document.getElementById("FileImportFicha");
  var file1 = inputFile1.files[0];

  var TipoDepositoId=$('#TipoDepositoId').attr("value");
  var FechaHora=$('#dateTimeField').attr("value");
  var Deposito=$("#NFicha").attr("value");
  var Monto=$("#Monto").attr("value");
  var PuntoVentaId=$("#PuntoVentaId").attr("value");
  var Comentarios=$("#Comentarios").attr("value");
  var clave=$("#Clave").attr("value");

  var data = new FormData();

  data.append('archivo1',file1);
  data.append('ext1', extension1);
  data.append('TipoDepositoId', TipoDepositoId);
  data.append('FechaHora', FechaHora);
  data.append('Deposito', Deposito);
  data.append('Monto', Monto);
  data.append('Comentarios', Comentarios);
  data.append('PuntoVentaId', PuntoVentaId);
  data.append('clave', clave);

  data.append('Opc', 5);
  var url = "Upload.php";
  $.ajax({
      url:url,
      type:'POST',
      contentType:false,
      data:data,
      processData:false,
      cache:false
      })
  .done(function( data, textStatus, jqXHR ) {

      pagina=jQuery(location).attr('href')
     location.href=pagina
   })
   .fail(function( jqXHR, textStatus, errorThrown ) {
       if ( console && console.log ) {
           $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro!</span>');
           return false;
       }
  });
}

function BtValidar()
{
  var Deposito=$("#DepositoId").attr("value");
  $.post("Acciones.php",{modulo:66, DepositoId:Deposito},getRespuesta);
  $("#isValidado").html('');
}

function asignaClientePuntoVenta(){

  var SeguimientoId=$("#SeguimientoId").attr("value");
  var PuntoVentaId=$("#PuntoVentaId").attr("value");

  $.post("Acciones.php",{modulo:68, SeguimientoId:SeguimientoId, PuntoVentaId:PuntoVentaId},function()
    {
      pagina=jQuery(location).attr('href')
      location.href=pagina
    });
}

function actualizaValidacionVenta(){

var ValidacionId=$("#ValidacionId").attr("value");
var EstatusValidacionId=$("#EstatusValidacionId").attr("value");
var Observaciones=$("#ComentariosV").attr("value");
var EstatusNoeId=$("#EstatusNoeId").attr("value");
var FechaEstatus=$("#FechaEstatus").attr("value");

var Nombre=$("#Nombre").attr("value");
var Paterno=$("#Paterno").attr("value");
var Materno=$("#Materno").attr("value");
var Telefono=$("#Telefono").attr("value");
var PuntoVentaId=$("#PuntoVentaId").attr("value");
var Comentarios=$("#Comentarios").attr("value");
var DescEquipos=$("#DescEquipos").attr("value");
var DescPlanes=$("#DescPlanes").attr("value");

var Calle=$("#Calle").attr("value");
var NExterior=$("#NExterior").attr("value");
var NInterior=$("#NInterior").attr("value");
var ColoniaId=$("#ColoniaId").attr("value");
var EstatusValidacionIdOld=$("#EstatusValidacionIdOld").attr("value");

  $.post("Acciones.php",{modulo:70, opc:1, EstatusValidacionIdOld:EstatusValidacionIdOld, ValidacionId:ValidacionId, EstatusValidacionId:EstatusValidacionId, Observaciones:Observaciones,EstatusNoeId:EstatusNoeId, FechaEstatus:FechaEstatus,Nombre:Nombre,Paterno:Paterno,Materno:Materno,Telefono:Telefono,PuntoVentaId:PuntoVentaId,Comentarios:Comentarios,DescEquipos:DescEquipos,DescPlanes:DescPlanes,Calle:Calle,NExterior:NExterior,NInterior:NInterior,ColoniaId:ColoniaId
  },function()
    {

      pagina=jQuery(location).attr('href')
      location.href=pagina
    });

}

function addValidacionVenta()
{

  var extension1 = ($("#FileImportIdentificacion").val().substring($("#FileImportIdentificacion").val().lastIndexOf("."))).toLowerCase();
  var inputFile1 = document.getElementById("FileImportIdentificacion");//$("#FileImport");
  var file1 = inputFile1.files[0];

  var extension2 = ($("#FileImportDomicilio").val().substring($("#FileImportDomicilio").val().lastIndexOf("."))).toLowerCase();
  var inputFile2 = document.getElementById("FileImportDomicilio");//$("#FileImport");
  var file2 = inputFile2.files[0];

  var extension3 = ($("#FileImportWord").val().substring($("#FileImportWord").val().lastIndexOf("."))).toLowerCase();
  var inputFile3 = document.getElementById("FileImportWord");//$("#FileImport");
  var file3 = inputFile3.files[0];

  var extension4 = ($("#FileImportIfe").val().substring($("#FileImportIfe").val().lastIndexOf("."))).toLowerCase();
  var inputFile4 = document.getElementById("FileImportIfe");//$("#FileImport");
  var file4 = inputFile4.files[0];

  var extension5 = ($("#FileImportBuro").val().substring($("#FileImportBuro").val().lastIndexOf("."))).toLowerCase();
  var inputFile5 = document.getElementById("FileImportBuro");//$("#FileImport");
  var file5 = inputFile5.files[0];

  var Folio=$('#Folio').attr("value");
  var clave=$("#Clave").attr("value");
  var Nombre=$("#Nombre").attr("value");
  var Paterno=$("#Paterno").attr("value");
  var Materno=$("#Materno").attr("value");
  var Telefono=$("#Telefono").attr("value");
  var PuntoVentaId=$("#PuntoVentaId").attr("value");
  var Comentarios=$("#Comentarios").attr("value");
  var DescEquipos=$("#DescEquipos").attr("value");
  var DescPlanes=$("#DescPlanes").attr("value");

  var Calle=$("#Calle").attr("value");
  var NExterior=$("#NExterior").attr("value");
  var NInterior=$("#NInterior").attr("value");
  var ColoniaId=$("#ColoniaId").attr("value");

  var MiColonia=$("#MiColonia").attr("value");
  var Cp=$("#Cp").attr("value");



if(Folio.length<7)
{
alert("error en folio")
return false;
}

if(Telefono.length<10)
{
alert("error en telefono")
return false;
}


  if(MiColonia!='')
  $.post("Acciones.php",{Colonia:MiColonia, cp:Cp, modulo:70, opc:2},

    function(datos){
      this.id_colonia=datos;
    }
    );

  var data = new FormData();
  data.append('archivo1',file1);
  data.append('archivo2',file2);
  data.append('archivo3',file3);
  data.append('archivo4',file4);
  data.append('archivo5',file5);
  data.append('ext1', extension1);
  data.append('ext2', extension2);
  data.append('ext3', extension3);
  data.append('ext4', extension4);
  data.append('ext5', extension5);

  data.append('Calle', Calle);
  data.append('NExterior', NExterior);
  data.append('NInterior', NInterior);
  data.append('ColoniaId', ColoniaId);
  data.append('MiColonia', MiColonia);

  data.append('Folio', Folio);
  data.append('clave', clave);
  data.append('Observacion', Comentarios);

  data.append('Nombre', Nombre);
  data.append('Paterno', Paterno);
  data.append('Materno', Materno);
  data.append('PuntoVentaId', PuntoVentaId);
  data.append('DescEquipos', DescEquipos);
  data.append('DescPlanes', DescPlanes);
  data.append('Telefono', Telefono);
  data.append('Opc', 6);
  var url = "Upload.php";
  $.ajax({
      url:url,
      type:'POST',
      contentType:false,
      data:data,
      processData:false,
      cache:false
      })
  .done(function( data, textStatus, jqXHR ) {

      pagina=jQuery(location).attr('href')
      //location.href=pagina

      if(data.substring(0, 5)=='Error')
        $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro! Validar si el registro ya existe</span>');
      else
      $("#resultados").html(data);

   })
   .fail(function( jqXHR, textStatus, errorThrown ) {
       if ( console && console.log ) {
           $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro!</span>');
           return false;
       }
  });
}

function seleccionaFolio(folio)
{
  $("#Lectura4").val(folio);
  $("#foo").submit();
}

function ActualizaHFolios()
{

  v1=$("#FolioN").attr("value");
  v2=$("#FechaSS").attr("value");
  v3=$("#Folio").attr("value");
  v4=$("#PuntoVentaId").attr("value");
  v5=$("#VendedorId").attr("value");
  v6=$("#CoordinadorId").attr("value");
  v7=$("#ClienteId").attr("value");
  v8=$("#TipoContratacionId").attr("value");
  v9=$("#TipoPagoId").attr("value");
  v10=$("#Comentarios").attr("value");
  v11=$("#Clave").attr("value");
  v12=$("#ContratacionId").attr("value");
  v13=$("#PuntoVentaIdOld").attr("value");

  $.post("Acciones.php",{Folio:v1, FechaContrato:v2, FolioOld:v3, PuntoVentaId:v4,
    VendedorId:v5, CoordinadorId:v6, ClienteId:v7, TipoContratacionId:v8,
    TipoPagoId:v9, Comentarios:v10, Clave:v11, ContratacionId:v12, PuntoVentaIdOld:v13,
    modulo:71, opc:1},getAltaVu);
}

function agregarAddOn(Id)
{
  v1=$("#AddonId"+Id).attr("value");
  if(v1==0)
  {
    alert("Debes elegir un Add On");
    return false;
  }
  $.post("Acciones.php",{RegistroId:Id, AddonId:v1, modulo:71, opc:3},
          function(datos){
                          $("#Addones").html(datos);
                        }
        );
}

function actualizaLinea(id)
{

v1=$("#RegistroId").attr("value");
v2=$("#PlanId"+id).attr("value");
v14=$("#EquipoId"+id).attr("value");
v3=$("#EstatusId"+id).attr("value");

v4=$("#PlazoId"+id).attr("value");
v5=$("#FechaEstatus"+id).attr("value");
v6=$("#Contrato"+id).attr("value");

v7=$("#Dn"+id).attr("value");
v8=$("#Diferencial"+id).attr("value");
v9=$("#TipoPagoId"+id).attr("value");

v10=$("#Comentarios"+id).attr("value");

v11=$("#MovimientoId"+id).attr("value");
v12=$("#Serie"+id).attr("value");
v13=$("#EstatusIdOld"+id).attr("value");

  $.post("Acciones.php",{RegistroId:v1, PlanId:v2, EstatusId:v3, PlazoId:v4, FechaEstatus:v5, Contrato:v6, Dn:v7,
  Diferencial:v8, TipoPagoDiferencial:v9, Observaciones:v10, MovimientoId:v11, Serie:v12, EstatusIdOld:v13, EquipoId:v14, modulo:71, opc:4},getAltaVu);
}

function CrearUsuario(){
v1=$("#EmpleadoId").attr("value");

if(v1==0)
  {
    alert("Debes elegir el usuario")
    return false;
  }
 $.post("Acciones.php",{EmpleadoId:v1, modulo:21, opc:1},
  function(datos){
    if(datos=='FAIL')
    $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro!</span>');
    else
      $("#resultados").html('<span class="notificacion">¡Se creo el usuario '+datos+' con la contraseña 12345!</span>');
  });
}


function ReingresarPersonal(){

        if($("#ClasificacionPersonalVentaId").attr("value")=="0")
        {
        alert("Debes elegir la clasificacion de venta");
        return false
        }

        if($("#PuestoId").attr("value")=="0")
        {
             alert("Debes elegir el Puesto");
            return false

        }
          if($("#SubCategoriaId").attr("value")=="0")
          {
            alert("Debes elegir la Sub Categoria Empleado");
            return false
          }

        if($("#Operador").attr("value")=="")
        {
        alert("Debes ingresar al operador");
        return false
        }

        if($("#Porcentaje").attr("value")=="")
        {
        alert("Debes ingresar el porcentaje");
        return false
        }

        if($("#FechaIngreso").attr("value")=="")
        {
        alert("Debes ingresar la fecha de ingreso");
        return false
        }

v1=$("#ClasificacionPersonalVentaId").attr("value")
v2=$("#PuestoId").attr("value")
v3=$("#SubCategoriaId").attr("value")
v4=$("#Operador").attr("value")
v5=$("#Porcentaje").attr("value")
v6=$("#FechaIngreso").attr("value")
claves=$("#Llaves").attr("value");

 $.post("Acciones.php",{EmpleadoId:claves, ClasificacionPersonalVentaId:v1, PuestoId:v2,
  SubCategoriaId:v3, Operador:v4, Porcentaje:v5, FechaIngreso:v6, modulo:40, opc:3},
  function(datos){
    if(datos=='FAIL')

    $("#resultados").html('<span class="alerta">¡No fue posible agregar el registro!</span>');
    else
      $("#resultados").html('<span class="notificacion">¡Se realizo el ingreso correctamente!</span>');
$("#Activa").dialog("close");
location.reload();
  });


}

function editaColonia()
{
  $("#MiColonia").show();
  $("#ColoniaId").hide();
  $("#Edit").hide();
}
