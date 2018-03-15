/***********************************************************************************************************************

************************************************************************************************************************/
$(document).ready(function() {
	 
	//ACCORDION BUTTON ACTION (ON CLICK DO THE FOLLOWING)
	$('.Familias').click(function() 
	{
		//REMOVE THE ON CLASS FROM ALL BUTTONS
		$('.Familias').removeClass('on');
		  
		//NO MATTER WHAT WE CLOSE ALL OPEN SLIDES
	 	$('.Modulos').slideUp('fast');
   
		//IF THE NEXT SLIDE WASN'T OPEN THEN OPEN IT
		if($(this).next().is(':hidden') == true) 
		{		
			//ADD THE ON CLASS TO THE BUTTON
			$(this).addClass('on');			  
			//OPEN THE SLIDE
			$(this).next().slideDown('fast');
		 } 
		  
	 });
	 	

	/*** REMOVE IF MOUSEOVER IS NOT REQUIRED ***/
	
	//ADDS THE .OVER CLASS FROM THE STYLESHEET ON MOUSEOVER 
	$('.Familias').mouseover(function() {
		$(this).addClass('over');
		
	//ON MOUSEOUT REMOVE THE OVER CLASS
	}).mouseout(function() {
		$(this).removeClass('over');										
	});
	
	/*** END REMOVE IF MOUSEOVER IS NOT REQUIRED ***/
	
	
	/********************************************************************************************************************
	CLOSES ALL S ON PAGE LOAD
	********************************************************************************************************************/	
	$('.Modulos').hide();

});

