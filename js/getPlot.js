var x;
x=$(document);
x.ready(inicializarEventos);

function inicializarEventos()
{	
	$("#resultados").html('<div id="plot" style="height: 400px;"></div>');
	(darwPlot)();
}

function darwPlot()
{
	$.post("Acciones.php",{modulo:0, opc:4},
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
	
}