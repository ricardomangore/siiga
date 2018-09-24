<?php
include("includes/Conectar.php");
include("includes/Security.php");
include("includes/ToolsFacturas.php");


$Seguridad=new Security();
  if(!$Seguridad->SesionExiste())
    header("Location: index.php");
  
  //$Herramientas= new Tools($_SESSION['UsuarioId']);
  $HerramientasFacturas = new ToolsFacturas($_SESSION['UsuarioId']);

$VentaId=$_GET['VentaId'];

 if (file_exists("Ventas/Documentos/ArchivoPDF".$VentaId.".pdf"))   
 {
     header('Content-type: application/pdf');
     header('Content-Disposition: attachment; filename="ArchivoPDF'.$VentaId.'.pdf"');
     $file='Ventas/Documentos/ArchivoPDF'.$VentaId.'.pdf';
     readfile($file); 
 }
      
  else
    {
          if (file_exists("Ventas/Documentos/soap-response".$VentaId.".xml"))   
           {
 	                         if($UUID=$HerramientasFacturas->GetUUID($VentaId))
			        {    			                                    
                                    
                                          if($HerramientasFacturas->GetResponsePdf($VentaId,$UUID)) 
					   {
                                             $doc = new DOMDocument(); 
                                                      $doc->load("Ventas/Documentos/soap-response_PDF".$VentaId.".xml");  
                                                      $items= $doc->getElementsByTagName('PDF')->item(0)->nodeValue;    
                                                      $new_pdf = fopen ("Ventas/Documentos/ArchivoPDF".$VentaId.".pdf", "w");
                                                      fwrite($new_pdf,base64_decode($items));
					              fclose($new_pdf);					 
						      header('Content-type: application/pdf');
                                                      header('Content-Disposition: attachment; filename="ArchivoPDF'.$VentaId.'.pdf"');
                                                      $file='Ventas/Documentos/ArchivoPDF'.$VentaId.'.pdf';
						      readfile($file);
                                         }
			           
                                 }
                        
                       
         }   
 
         else 
 
         {
          exit('Error al Leer Xml.');
         }

      }
?> 
