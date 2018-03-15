$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});

function CerrarSesion()
{
	document.getElementById('logout').submit();
}

function Todos(){
  return true;
  var cadena='';
  for (i=0;i<document.foo.elements.length;i++)
  {
    if(document.foo.elements[i].type == "checkbox")
      {
      document.foo.elements[i].checked=1

      cadena=cadena+document.foo.elements[i].value+",";
      }
  }
  document.foo.Llaves.value=cadena;
}
function Ninguno(){
  for (i=0;i<document.foo.elements.length;i++)
    if(document.foo.elements[i].type == "checkbox")
      document.foo.elements[i].checked=0

    document.foo.Llaves.value='';
}

function changeDato(Obj, campo)
{
  if (Obj.checked==1)
      setDato(campo)
    else
      removeDato(campo)
}

function setDato(campo)
{
  document.foo.Llaves.value=document.foo.Llaves.value+campo+",";
}

function removeDato(campo)
{
  document.foo.Llaves.value=document.foo.Llaves.value.replace(campo+',','');
}


function utf8_decode (str_data) {
  // http://kevin.vanzonneveld.net
  // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
  // +      input by: Aman Gupta
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: Norman "zEh" Fuchs
  // +   bugfixed by: hitwork
  // +   bugfixed by: Onno Marsman
  // +      input by: Brett Zamir (http://brett-zamir.me)
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: kirilloid
  // *     example 1: utf8_decode('Kevin van Zonneveld');
  // *     returns 1: 'Kevin van Zonneveld'

  var tmp_arr = [],
    i = 0,
    ac = 0,
    c1 = 0,
    c2 = 0,
    c3 = 0,
    c4 = 0;

  str_data += '';

  while (i < str_data.length) {
    c1 = str_data.charCodeAt(i);
    if (c1 <= 191) {
      tmp_arr[ac++] = String.fromCharCode(c1);
      i++;
    } else if (c1 <= 223) {
      c2 = str_data.charCodeAt(i + 1);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
      i += 2;
    } else if (c1 <= 239) {
      // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
      i += 3;
    } else {
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      c4 = str_data.charCodeAt(i + 3);
      c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
      c1 -= 0x10000;
      tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1>>10) & 0x3FF));
      tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
      i += 4;
    }
  }

  return tmp_arr.join('');
}


$(function() {
 //Array para dar formato en español
  $.datepicker.regional['es'] =
  {
    changeMonth: true,
      changeYear: true,
  closeText: 'Cerrar',
  prevText: 'Anterior',
  nextText: 'Siguiente',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
  monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
  dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
  dateFormat: 'dd/mm/yy', firstDay: 0,
  initStatus: 'Selecciona la fecha', isRTL: false};
 $.datepicker.setDefaults($.datepicker.regional['es']);

 //miDate: fecha de comienzo D=días | M=mes | Y=año
 //maxDate: fecha tope D=días | M=mes | Y=año

    $('#FechaNacimiento').live('click', function () {
            $(this).datepicker({ minDate: "-70Y", maxDate: "-15Y" }).focus();
    });

    $('#FechaIngreso').live('click', function () {
            $(this).datepicker({ minDate: "-2M", maxDate: "+5d" }).focus();
    });

    $('#FechaIngresoPunto').live('click', function () {
            $(this).datepicker({ minDate: "-2M", maxDate: "+5d" }).focus();
    });

    $('#FechaContrato').live('click', function () {
            $(this).datepicker({ minDate: "-5M", maxDate: "+5d" }).focus();
    });

   $('#FechaSS').live('click', function () {
            $(this).datepicker({ minDate: "-2M", maxDate: "+5d" }).focus();
    });

    $(".FechaEstatus").live('click', function () {
            $(this).datepicker({ minDate: "-8M", maxDate: "+1d" }).focus();
    });

    $("#FechaSolicitudImss").live('click', function () {
            $(this).datepicker({ minDate: "-3M", maxDate: "+1M" }).focus();
    });

    $("#FechaAltaImss").live('click', function () {
            $(this).datepicker({ minDate: "-4M", maxDate: "+0d" }).focus();
    });


    $("#FechaInstalacion").live('click', function () {
            $(this).datepicker({ minDate: "-5M", maxDate: "+1M" }).focus();
    });

    $(".FechaSolicitudImss").live('click', function () {
            $(this).datepicker({ minDate: "-3M", maxDate: "+1M" }).focus();
    });

    $(".FechaAltaImss").live('click', function () {
            $(this).datepicker({ minDate: "-4M", maxDate: "+0d" }).focus();
    });


  });


function removeClassName (elem, className) {
  elem.className = elem.className.replace(className, "").trim();
}

function addCSSClass (elem, className) {
  removeClassName (elem, className);
  elem.className = (elem.className + " " + className).trim();
}

String.prototype.trim = function() {
  return this.replace( /^\s+|\s+$/, "" );
}

function stripedTable() {
  if (document.getElementById && document.getElementsByTagName) {
    var allTables = document.getElementsByTagName('myTable');
    if (!allTables) { return; }

    for (var i = 0; i < allTables.length; i++) {
      if (allTables[i].className.match(/[\w\s ]*scrollTable[\w\s ]*/)) {
        var trs = allTables[i].getElementsByTagName("tr");
        for (var j = 0; j < trs.length; j++) {
          removeClassName(trs[j], 'alternateRow');
          addCSSClass(trs[j], 'normalRow');
        }
        for (var k = 0; k < trs.length; k += 2) {
          removeClassName(trs[k], 'normalRow');
          addCSSClass(trs[k], 'alternateRow');
        }
      }
    }
  }
}

//window.onload = function() { stripedTable(); }


function CargaPhoto()
{
var destino='SubirFoto.php';
var ancho='500';
var alto='300';

  if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
    alto=eval(alto)+50;
dimensiones="width=" + ancho + ", height=" + alto;
barra = "scrollbars=" + "1";
nombreVentana="actual";
x=(screen.width - ancho) / 2;
y=(screen.height - alto) / 2;
features="status=0, toolbar=0, location=0, menubar=0, directories=0, resizable=0, " + barra + ", " + dimensiones;
  cjb=window.open(destino,nombreVentana,features);
  //cjb.moveTo(x,y);
  cjb.focus();
return;
}


function formato_numero(numero, decimales){ // v2007-08-06
  var separador_decimal='.' ;
  var separador_miles=',';

    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}



$(document).ready(function(){


  // Write on keyup event of keyword input element
  $(".Busqueda").live('keyup', function(){
    // When value of the input is not blank
    if( $(this).val() != "")
    {

      var tabla;
       if ($('#myTable').is (':visible')) tabla='myTable';
       if ($('#Usuarios').is (':visible')) tabla='MiTabla2';
      if ($('#PuntosVenta').is (':visible')) tabla='MiTabla';
      if ($('#Vendedores').is (':visible')) tabla='MiTabla2';
      if ($('#AddOn').is (':visible')) tabla='MiTabla3';
      if ($('#SAdicional').is (':visible')) tabla='MiTabla4';
      if ($('#Clientes').is (':visible')) tabla='MiTabla5';
      if ($('#Equipos').is (':visible')) tabla='MiTabla6';
      if ($('#Planes').is (':visible')) tabla='MiTabla7';
      if ($('#Coordinaciones').is (':visible')) tabla='MiTabla2';
      if ($('#Productos').is (':visible')) tabla='MiTabla6';
      if ($('#Empleados').is (':visible')) tabla='MiTabla2';
      if ($('#Ordenes').is (':visible')) tabla='MiTabla6';

      // Show only matching TR, hide rest of them
      $("#"+tabla+" tbody>tr").hide();
      $("#"+tabla+" td:contains-ci('" + $(this).val() + "')").parent("tr").show();
    }
    else
    {
      // When there is no input or clean again, show everything back
      $("#"+tabla+" tbody>tr").show();
    }
  });
});
// jQuery expression for case-insensitive filter
$.extend($.expr[":"],
{
    "contains-ci": function(elem, i, match, array)
  {
    return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
  }
});

function openLink(liga)
{
  $.post("Acciones.php",{modulo:0, opc:5, Url:liga},
         function(data)
         {

            window.open(liga,"_blank");
         }
   );
}

function verAvisos(dato)
{
 $.post("Display.php",{DatoId:dato, opc:5},
   function( data )
   {
      $("#Avisos").html('');
      $("#Avisos").html(data);

      $(function()
      {
      $.each($('.datagridColor'), function(i, post)
        {
               $(post).css('width', 30+'%');
        });
      });

   }
   );
}
