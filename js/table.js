var x;
x=$(document);
x.ready(inicializarEventos);

function inicializarEventos()
{	


	$(function() {
    $.each($('.datagridColor'), function(i, post) {
    	/*
        var max = 7,
            min = 3,
            rand = (Math.floor(Math.random() * (max - min)) + min)*10;
            */
             $(post).css('width', 30+'%');           
	    });
	});


$.post("Acciones.php",{modulo:0, opc:3, EncuestaId:1},
function(participo){
				if(participo=='N')
				{	
				$('#PanelEncuesta').slideDown('slow');
				$('#OtroMomento').click(function(){$('#PanelEncuesta').slideUp();});
				$('#Votar').click(
								function(){ 					
									if($("#Si").is(':checked'))
										var v1=1;
									else
										if($("#No").is(':checked'))
											var v1=2;
										else
											alert("Debes elegir una opcion")					

									var v2='';
									$.post("Acciones.php",{modulo:0, opc:2, RespuestaId:v1, RespuestaTxt:v2},
										function(data){
													$('#PanelEncuesta').click(function(){$('#PanelEncuesta').slideUp();});	
													$("#resultados").html('<div id="plot" style="height: 400px;"></div>');
													datos=data.split(",");
													
													var s1 = [['Si',parseInt(datos[0])], ['No',parseInt(datos[1])]];									        
													    var plot8 = $.jqplot('plot', [s1], {
													        grid: 
													        	{
													            drawBorder: false, 
													            drawGridlines: false,
													            background: '#ffffff',
													            shadow:false
													        	},
													        axesDefaults: 
													        	{},
													        seriesDefaults:
													        	{
													            renderer:$.jqplot.PieRenderer,
													            rendererOptions: {sliceMargin: 4, showDataLabels: true},									            
													        	},
													        legend: 
													        	{
													            show: true,
													            rendererOptions: {numberRows: 2},
													            location: 's'
													        	}
													    }); 
										});//Fin POS			
								}); //FIN VOTAR	
				}			
			});//fin pos
}