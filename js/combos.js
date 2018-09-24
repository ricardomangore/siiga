$(document).ready(function(){

	
	$("#Cp").live('blur', function ()
	{		
		$.post("query/combos.php",{ id:$(this).prop("value"), opc:1},function(data){$("#ColoniaId").html(data);})
	});

	$("#CpContacto").blur(function()
	{		
		$.post("query/combos.php",{ id:$(this).attr("value"), opc:1},function(data){$("#ColoniaIdContacto").html(data);})
	});
	
})
