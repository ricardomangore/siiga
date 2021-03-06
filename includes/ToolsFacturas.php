<?php
class ToolsFacturas extends Conectar{
  var $UsuarioId;
	function ToolsFacturas($UsuarioId)
  {
		$this->Conectar();
    $this->UsuarioId=$UsuarioId;
    require("CNumeroaLetra.php");
	return;
	}
		
	function Consulta($sql){
	$Query=mysql_query("$sql", $this->conexion) or die("Error al Consultar: $sql ".mysql_error());
	return $Query;
	}  	
	
	function GetUsuarioFactura(){
	$Q0="SELECT Usuario FROM Accesofactura LIMIT 1";
	$R0=$this->Consulta($Q0);
	list($Usuario)=mysql_fetch_row($R0);
	return $Usuario;
	}
	
	function GetPasswordFactura(){
	$Q0="SELECT Password FROM Accesofactura LIMIT 1";
	$R0=$this->Consulta($Q0);
	list($Password)=mysql_fetch_row($R0);
	return $Password;
	}
	
  function getDatosCliente($ClienteId)	
	{    
     $Q0="SELECT CONCAT_WS(' ', T1.Nombre, T1.Paterno, T1.Materno) AS Nombre,
       T2.NombreContacto, 
       IF(TelefonoLocal='',TelefonoMovil,TelefonoLocal) AS Telefono,
       Rfc,
       CONCAT_WS(' ', T1.Nombre, T1.Paterno, T1.Materno) AS RazonSocial,
       Calle, NoExterior,
       NoInterior,
       Colonia,
       '' AS Localidad,
       '' AS Referencia,      
       'México',
       CodigoPostal,
       Municipio,
       EstadoFacturas
       FROM Clientes AS T1
        LEFT JOIN
                (
                SELECT T1.ClienteId, CONCAT_WS(' ', NombreContacto, PaternoContacto, MaternoContacto) AS NombreContacto,
                       Calle, NoExterior, NoInterior, ColoniaId, TelefonoLocal, TelefonoMovil
                FROM HistorialDatosClientes AS T1
                INNER JOIN (
                            SELECT MAX(HistorialdatosClienteId), ClienteId
                            FROM HistorialDatosClientes
                            GROUP BY ClienteId
                           ) AS T2 ON T2.ClienteId=T1.ClienteId
                ) AS T2 ON T2.ClienteId=T1.ClienteId
        LEFT JOIN Colonias AS T3 ON T3.ColoniaId=T2.ColoniaId
        LEFT JOIN Municipios AS T4 ON T4.MunicipioId=T3.MunicipioId    
        LEFT JOIN Estados AS T5 ON T5.EstadoId=T4.EstadoId   
        WHERE T1.Clienteid=$ClienteId";

        return mysql_fetch_row($this->Consulta($Q0));
  }

  function getEdoMunPv($PuntoVentaId)
  {
    $Q0="SELECT EstadoFacturas, Municipio FROM PuntosVenta AS T1
          INNER JOIN Colonias AS T2 ON T2.ColoniaId=T1.ColoniaId
          INNER JOIN Municipios AS T3 ON T3.MunicipioId=T2.MunicipioId
          LEFT JOIN Estados AS T4 ON T4.EstadoId=T3.estadoId
          WHERE PuntoventaId=$PuntoVentaId
          LIMIT 1";
    return mysql_fetch_row($this->Consulta($Q0));       
  }

	function begin()
  {
     $this->Consulta("SET AUTOCOMMIT = 0");
	   $this->Consulta("START TRANSACTION");      
  }
		
    /*************************************************************************************
           Funcion para Guardar Venta de Accesorios.
     *************************************************************************************/

	function GuardaVenta($PuntoVentaId, $VendedorId, $CoordinadorId, $ClienteId, $Comentario, $Clave)
	{

        $destinatario = "d.juarez@solucell.com.mx";	
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
        $headers .= "From: Sistema Accesorios <accesorios@icallco.com>\r\n";        

    list($Nombre, $NombreC, $Telefono, $Rfc, $RazonSocial, $Calle, $NExterior, $NInterior, $Colonia, $LReceptor, $RReceptor, $Pais, $CodigoPostal, $Municipio, $Estado)=$this->getDatosCliente($ClienteId);

  //  list($Estado, $Municipio)=$this->getEdoMunPv($PuntoVentaId);

    $datosReceptor= array();    
    $datosReceptor[0]=$Nombre;       //'asdasd'; // Nombre del cliente (REQUERIDO)
    $datosReceptor[1]=$NombreC;   //'';//$dataDB['cliente']['nombreContacto']; // Contacto de referencia del cliente (opcional)
    $datosReceptor[2]=$Telefono;    //'';//$dataDB['cliente']['Telefono']; // Teléfono del cliente (opcional)
    $datosReceptor[3]='';      //'';//$dataDB['cliente']['Email']; // Email del cliente (opcional)
    $datosReceptor[4]=$Rfc;         //'DEMO000000FEL'; // RFC del receptor (REQUERIDO)
    $datosReceptor[5]=$RazonSocial; //'Prueba';  // Nombre del receptor (REQUERIDO)
    $datosReceptor[6]=$Calle;       //'Topacio'; // Calle del receptor (REQUERIDO)
    $datosReceptor[7]=$NExterior;   //'3500'; // No. exterior del receptor (REQUERIDO)
    $datosReceptor[8]=$NInterior;   //'';//$dataDB['cliente']['noInt']; // No. interior del receptor (opcional)
    $datosReceptor[9]=$Colonia;     //'Esmeralda'; // Colonia del receptor (REQUERIDO)
    $datosReceptor[10]=$LReceptor;  //'';//$dataDB['cliente']['localidad']; // Localidad del receptor (opcional)
    $datosReceptor[11]=$RReceptor;  //'';//$dataDB['cliente']['referencia']; // Referencia del receptor (opcional)
    $datosReceptor[12]=$Municipio;  //'Puebla'; // Municipio del receptor (REQUERIDO)
    $datosReceptor[13]=$Estado;   //'Puebla'; // Estado del receptor (REQUERIDO)
    $datosReceptor[14]=$Pais;       //'México'; // País del receptor (REQUERIDO)
    $datosReceptor[15]=$CodigoPostal; //'72400'; // Código Postal del receptor (REQUERIDO)

		$this->begin();	  
    $Q0="INSERT INTO AccVentas (VentaId, Factura, PuntoVentaId, VendedorId, CoordinadorId, ClienteId, Comentario, UsuarioId, Fecha, Hora, Activo)
           VALUES(NULL, '', $PuntoVentaId, $VendedorId, $CoordinadorId, $ClienteId, '$Comentario', $this->UsuarioId, CURDATE(), CURTIME(), 1)";
		$this->Consulta($Q0);
    $X1="SELECT LAST_INSERT_ID()";
         $R0=mysql_query("$X1", $this->conexion) or die(mysql_error());
	       list($VentaId)=mysql_fetch_row($R0);
		 if($VentaId!=0)
	  {          
	       $Q1="INSERT INTO AccVentasLineas
                SELECT RegistroId, '$VentaId', T1.Codigo, Precio FROM AccVtaTemp AS T1
                LEFT JOIN AccListasPuntos AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
                LEFT JOIN AccArticulosPrecios AS T3 ON T3.ListaPrecioId=T2.ListaId AND T3.Codigo=T1.Codigo
                WHERE Clave='$Clave'
                GROUP BY RegistroId
                ";
            $Q2="UPDATE AccInventario AS T1
                  INNER JOIN (
                              SELECT Codigo, COUNT(RegistroId) AS Cta
                              FROM AccVentasLineas
                              WHERE VentaId=$VentaId
                              GROUP BY Codigo
                             ) AS T2 ON T2.Codigo=T1.Codigo
                  SET Cantidad=Cantidad-Cta
                  WHERE PuntoVentaId=$PuntoVentaId";                  
        if($this->Consulta($Q1) & $this->Consulta($Q2))
        {
			  		 $Bandera=$this->GeneraFactura($VentaId,$datosReceptor,$PuntoVentaId);
						 if($Bandera)
							{
						   $folio=$this->GetFolio($VentaId);               
					      if($folio!=0)
					        {                  
											$QB="UPDATE AccVentas SET Factura='$folio' WHERE VentaId=$VentaId";
											      if($this->Consulta($QB))
					                  {     
                             
                              #mail($destinatario,'Venta'.$VentaId,$this->DetalleVentaCorreo($VentaId),$headers); 
							                $this->Consulta("COMMIT");
											        return '<a href="Pdf.php?VentaId='.$VentaId.'" target="_blank">Abrir Factura</a>';
							               }					               
									 }//Validacion folio       															
							}  #Validacion Respuesta de webservice y creacion de xml
        }
			} #Validacion Tipo de Pago  
	     $this->Consulta("ROLLBACK");
     return "FAIL";  
	}
	
     /*************************************************************************************
           Funcion para Generar Factura 2014.
     *************************************************************************************/

	 function GeneraFactura($VentaId=0,$datosReceptor='',$PuntoVentaId=0)
	   {
      $QA="SELECT 
                    ROUND(SUM(Precio),2) AS TOTAL, 
                    ROUND(SUM(Precio/1.16),2) STOTAL, 
                    ROUND(SUM(Precio)-SUM(Precio/1.16),2) AS IVA
         FROM AccVentasLineas
         WHERE VentaId=$VentaId";
        list($Total, $SubTotal, $Iva)=mysql_fetch_row($this->Consulta($QA));
		   $Monto= new CNumeroaletra;
       $PVIva=1.16;
       $Monto->setMoneda("PESOS");
       $Monto->setNumero(str_replace(',','',$Total));   // Total en Letra
       $Letra=$Monto;
		   $usuario=  $this->GetUsuarioFactura(); //RFC del emisor (REQUERIDO)
            $cuenta=  $this->GetUsuarioFactura(); //Cuenta del usuario (REQUERIDO)
           $password= $this->GetPasswordFactura(); //Password del usuario (REQUERIDO)
		 		 
		   $soap_request  = "<?xml version=\"1.0\"?>\n";
           $soap_request .= "<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\n";
           $soap_request .= "<soap:Body>\n";
           $soap_request .= "<GenerarCFDIv32 xmlns=\"http://www.theenginesoftware.com/\">\n";
  
           //Ingreso de Autenticación del Cliente con su Usuario, Cuenta y Contraseña.
           //Si se desea apuntar a otra sucursal, aqui debe indicar el valor referenciado de la sucursal, Ejemplo. "TiendaNorte" (REQUERIDO).
           $soap_request .= "<credenciales>\n";
           $soap_request .= "<Usuario>".$usuario."</Usuario>
                             <Cuenta>".$cuenta."</Cuenta>
					         <Password>".$password."</Password>\n";
           $soap_request .= "</credenciales>\n";
  
           //*************************************************************************************
           // Sección de variables para agregar los valores al comprobante CFDi.
           //*************************************************************************************
           $soap_request .= "    <comprobante>\n";
           $soap_request .= "    <formaDePago>Pago en una sola exhibición</formaDePago>\n";
           $soap_request .= "    <subTotal>$SubTotal</subTotal>\n";  
           $soap_request .= "    <descuento xsi:nil=\"true\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"/>\n"; 
           $soap_request .= "    <Moneda>MN</Moneda>\n";
           $soap_request .= "    <total>$Total</total>\n";
           $soap_request .= "    <tipoDeComprobante>FACTURA</tipoDeComprobante>\n";
           $soap_request .= "    <metodoDePago>Efectivo</metodoDePago>\n";
           $soap_request .= "    <LugarExpedicion>Puebla, Puebla</LugarExpedicion>\n";
  
           /**************************************************************************************
            Sección de variables para identificar y actualizar los datos del Cliente(Receptor).
           **************************************************************************************/
           $soap_request .= "    <Receptor>\n";
           $soap_request .= "    <NombreCliente>$datosReceptor[0]</NombreCliente>\n";
           $soap_request .= "    <Contacto>$datosReceptor[1]</Contacto>\n";
           $soap_request .= "    <emailContacto>$datosReceptor[3]</emailContacto>\n";
           $soap_request .= "    <RFC>$datosReceptor[4]</RFC>\n";
           $soap_request .= "    <Nombre>$datosReceptor[5]</Nombre>\n";
           $soap_request .= "    <calle>$datosReceptor[6]</calle>\n";
           $soap_request .= "    <noExterior>$datosReceptor[7]</noExterior>\n";
           $soap_request .= "    <colonia>$datosReceptor[9]</colonia>\n";
           $soap_request .= "    <localidad>$datosReceptor[10]</localidad>\n";
           $soap_request .= "    <referencia>$datosReceptor[11]</referencia>\n";
           $soap_request .= "    <municipio>$datosReceptor[12]</municipio>\n";
           $soap_request .= "    <estado>$datosReceptor[13]</estado>\n";
           $soap_request .= "    <pais>$datosReceptor[14]</pais>\n";
           $soap_request .= "    <codigoPostal>$datosReceptor[15]</codigoPostal>\n";
           $soap_request .= "    </Receptor>\n";
    
           /*************************************************************************************
           Sección de variables para la descripción de los conceptos
           *************************************************************************************/    
           /************************************************************************************
                                     CONCEPTO
           ************************************************************************************/   
           //Cantidad, Unidad, Descripcion, ValorUnitario e Importe del Concepto. (REQUERIDOS)  
            $QR="SELECT COUNT(RegistroId) AS Cantidad, T1.Codigo, Descripcion, Precio FROM AccVentasLineas AS T1
                LEFT JOIN AccArticulos AS T2 ON T2.Codigo=T1.Codigo
                WHERE VentaId=$VentaId
                GROUP BY T1.Codigo";	    

            $RQ=$this->Consulta($QR);
			
            while($A0=mysql_fetch_row($RQ))
              {
	            $ValorUnitario=$this->str2num(number_format($A0[3]/$PVIva,2));
	            $Importe=      $this->str2num(number_format($this->str2num($A0[3])/$PVIva,2)) * $this->str2num($A0[0]); 
	 	 
                $soap_request .= "<Conceptos>";	 
                $soap_request .= "<ConceptoR cantidad=\"$A0[0]\" unidad=\"PZA\" noIdentificacion=\"$A0[1]\" descripcion=\"$A0[2]\" valorUnitario=\"$ValorUnitario\" importe=\"$Importe\">\n";
                $soap_request .= "<DetalleConcepto>\n";
                $soap_request .= "<TipoCalculo>PARTIDA</TipoCalculo>\n";
		$soap_request .= "<Descuento>0</Descuento>\n";
                $soap_request .= "</DetalleConcepto>\n"; 
                $soap_request .= "</ConceptoR>\n";                  
                $soap_request .= "</Conceptos>\n";
              }

  
              /**********************************************************************************************
              'Sección de variables para la información de todos los impuestos Retenidos  
		      y de Traslado utilizados en el CFDI.
              '**********************************************************************************************/
                $soap_request .= "	<Impuestos>\n";
                $soap_request .= "	<totalImpuestosRetenidos>0.0</totalImpuestosRetenidos>\n";
                $soap_request .= "	<totalImpuestosTrasladados>$Iva</totalImpuestosTrasladados>\n";               
			    //Impuestos de Traslado del CFDi
                $soap_request .= "     <Traslados>\n";
                $soap_request .= "     <TrasladoR>\n";
                $soap_request .= "     <Impuesto>IVA</Impuesto>\n";
                $soap_request .= "     <Tasa>16.00</Tasa>\n";
                $soap_request .= "     <Importe>$Iva</Importe>\n";
                $soap_request .= "     <NombreImpuesto>IVA</NombreImpuesto>\n";
                $soap_request .= "     </TrasladoR>\n";
                $soap_request .= "     </Traslados>\n";
                $soap_request .= "	   </Impuestos>\n";
  
  
                 //Regimen fiscal con el cual saldra emitido el documento CFDi. (REQUERIDO).
                $soap_request .= "	<RegimenesFiscales>\n";                
            		$soap_request .= "	<RegimenFiscalR>\n"; 
                $soap_request .= "	<Regimen>Regimen General de las Personas Fisicas</Regimen></RegimenFiscalR>\n";
                $soap_request .= "	</RegimenesFiscales>\n";
  
                /**********************************************************************************************
                 Sección de variables para la información de todos los impuestos Locales 
		         Retenidos  y de Traslado utilizados en el CFDi.
                **********************************************************************************************/
                $soap_request .= "	<ComplementoImpuestosLocales>\n";
                $soap_request .= "	<TotaldeRetenciones>0</TotaldeRetenciones>\n";
                $soap_request .= "	<TotaldeTraslados>0</TotaldeTraslados>\n";
                $soap_request .= "	</ComplementoImpuestosLocales>\n";
                $soap_request .= "	<ClaveCFDI>FAC</ClaveCFDI>\n";      
                //Cantidad con letra del Comprobante(REQUERIDO)
                $soap_request .= "	<FechaTipoCambio xsi:nil=\"true\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"/><ImporteConLetra>$Monto</ImporteConLetra>\n";
                $soap_request .= "	</comprobante>\n";
                $soap_request .= "	</GenerarCFDIv32>\n";
                $soap_request .= "	</soap:Body>\n";
                $soap_request .= "</soap:Envelope>";
  
		        //creo un archivo soap_reequest.xml e introduzco la cadena_xml
	            $new_xml = fopen ("Ventas/Documentos/soap-request".$VentaId.".xml", "w");
	            fwrite($new_xml,$soap_request);
	            fclose($new_xml);

                //Esta parde es el Header de la peticion SOAP y en ella se incluye el contenido de la pagina del servicio
                $header = array(
  	            "POST /ConexionRemotaCFDI32/ConexionRemota.asmx HTTP/1.1",
	            "Host: www.fel.mx",
	            "Content-Type: text/xml; charset=utf-8",
	            "Content-Length: ".strlen($soap_request),
	            "SOAPAction: \"http://www.theenginesoftware.com/GenerarCFDIv32\""
                               );
                //Parametros de la conexion al webservice y URL del servicio
                $soap_do = curl_init();
                curl_setopt($soap_do, CURLOPT_URL, "https://www.fel.mx/ConexionRemotaCFDI32/ConexionRemota.asmx");
                curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($soap_do, CURLOPT_TIMEOUT,        10);
                curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($soap_do, CURLOPT_POST,           true );
                curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $soap_request);
                curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

                // Respuesta del webservice
                $response = curl_exec($soap_do); 
                curl_close($soap_do);
			    
				$xml = fopen ("Ventas/Documentos/soap-response".$VentaId.".xml", "w");
	            fwrite($xml, $response);
	            fclose($xml);
								
				if(file_exists('Ventas/Documentos/soap-response'.$VentaId.'.xml'))
				{
				
				     $doc = new DOMDocument(); 
                     $doc->load('Ventas/Documentos/soap-response'.$VentaId.'.xml'); 			
			         if($doc->getElementsByTagName('GenerarCFDIv32Result')->item(0)->nodeValue)
				     {
						 return true;
					 }			
				}			   			
		        return false;								   
	    } 


/*************************************************************************************
           Obtiene el folio de la factura.
*************************************************************************************/


        function GetFolio($VentaId)
		{
	  
	        if(file_exists('Ventas/Documentos/soap-response'.$VentaId.'.xml'))
				{
			        $doc = new DOMDocument(); 
                    $doc->load('Ventas/Documentos/soap-response'.$VentaId.'.xml'); 
                    $xml = $doc->getElementsByTagName("XML"); 
                    $result = $xml->item(0)->nodeValue; 
	        
			        $dom = new DOMDocument(); 
                    $dom->loadXML($result);
				
				    foreach ($dom->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*') as $element) 
					{  
                      return $element->getAttribute('folio'); 
                    }
								
				}
	    
		    return 0;
         
		}




/*************************************************************************************
           Obtiene el UUID de la factura.
*************************************************************************************/


        function GetUUID($VentaId)
		{
	  
	        if(file_exists('Ventas/Documentos/soap-response'.$VentaId.'.xml'))
				{
			        $doc = new DOMDocument(); 
                    $doc->load('Ventas/Documentos/soap-response'.$VentaId.'.xml'); 
                    $xml = $doc->getElementsByTagName("XML"); 
                    $result = $xml->item(0)->nodeValue; 
	        
			        $dom = new DOMDocument(); 
                    $dom->loadXML($result);
				
				    foreach ($dom->getElementsByTagNameNS('http://www.sat.gob.mx/TimbreFiscalDigital', '*') as $element) 
					{  
                      $UUID=$element->getAttribute('UUID'); 
                    }
				
				     if(isset($UUID))
					 return $UUID;
					 else
					 return 0;				
				}
	    
		    return 0;
         
		}
		 
/*************************************************************************************
           Obtiene Archivo del PDF.
*************************************************************************************/		 
		 
  function GetResponsePdf($VentaId,$UUID){
	       $usuario=  $this->GetUsuarioFactura(); //RFC del emisor (REQUERIDO)
            $cuenta=  $this->GetUsuarioFactura(); //Cuenta del usuario (REQUERIDO)
           $password= $this->GetPasswordFactura(); //Password del usuario (REQUERIDO)
	  
 		 
           $soap_request  = "<?xml version=\"1.0\"?>\n";
           $soap_request .= "<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\n";  
           $soap_request .= "  <soap:Body>\n";
           $soap_request .= "    <ObtenerPDF xmlns=\"http://www.theenginesoftware.com/\">\n";
  
           //Ingreso de Autenticación del Cliente con su Usuario, Cuenta y Contraseña.
           //Si se desea apuntar a otra sucursal, aqui debe indicar el valor referenciado de la sucursal, Ejemplo. "TiendaNorte" (REQUERIDO).
           $soap_request .= "    <credenciales>\n";
           $soap_request .= "    <Usuario>".$usuario."</Usuario><Cuenta>".$cuenta."</Cuenta><Password>".$password."</Password>\n";
           $soap_request .= "    </credenciales>\n";
           $soap_request .= "    <uuid>".$UUID."</uuid>\n";
    
           //Cierro el Soap Request
           $soap_request .= "	</ObtenerPDF>\n";
           $soap_request .= "	</soap:Body>\n";
           $soap_request .= "</soap:Envelope>";
  
           //creo un archivo soap_reequest.xml e introduzco la cadena_xml
	       $new_xml = fopen ("Ventas/Documentos/soap-request_PDF".$VentaId.".xml", "w");
	       fwrite($new_xml,$soap_request);
	       fclose($new_xml);
  
          //Esta parde es el Header de la peticion SOAP y en ella se incluye el contenido de la pagina del servicio
           $header = array(
  	       "POST /ConexionRemotaCFDI32/ConexionRemota.asmx HTTP/1.1",
	       "Host: www.fel.mx",
	       "Content-Type: text/xml; charset=utf-8",
     	   "Content-Length: ".strlen($soap_request),
	       "SOAPAction: \"http://www.theenginesoftware.com/ObtenerPDF\""
           );

           //Parametros de la conexion al webservice y URL del servicio
          $soap_do = curl_init();
          curl_setopt($soap_do, CURLOPT_URL, "https://www.fel.mx/ConexionRemotaCFDI32/ConexionRemota.asmx");
          curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
          curl_setopt($soap_do, CURLOPT_TIMEOUT,        10);
          curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
          curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($soap_do, CURLOPT_POST,           true );
          curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $soap_request);
          curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

          // Respuesta del webservice
          $response = curl_exec($soap_do); 
          curl_close($soap_do);
			//print $response;			
		  $xml = fopen ("Ventas/Documentos/soap-response_PDF".$VentaId.".xml", "w");
	      fwrite($xml, $response);
	      fclose($xml);
		 
    
		       if(file_exists('Ventas/Documentos/soap-response_PDF'.$VentaId.'.xml'))
				{
				
				     $doc = new DOMDocument(); 
                     $doc->load('Ventas/Documentos/soap-response_PDF'.$VentaId.'.xml'); 			
			         if($doc->getElementsByTagName('ObtenerPDFResult')->item(0)->nodeValue)
				     {
						 return true;
					 }			
				}
			   				
		        return false;		
		 
		 
  }
		 
		 
		 
		 
		 
		 
        
      function DetalleVentaCorreo($VentaId=0){	
	
	$Q0="SELECT CONCAT_WS(' ',T2.Nombre,T2.Paterno,T2.Materno)Nombre,DATE_FORMAT(T1.Fecha,'%d-%m-%Y')Fecha
        ,T1.Hora,T5.PuntoVenta,T4.Qty,T1.Comentario,IF(T1.TipoVentaId=1,'Ejecutivo','Publico'),
        T6.Monto AS Efectivo,T7.Monto AS Credito,T8.Total
        FROM AccesorioVentas AS T1
        LEFT JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
        LEFT JOIN (SELECT VentaId,SUM(Cantidad)Qty FROM AccesorioVentaDetalle GROUP BY VentaId) AS T4 ON T4.VentaId=T1.VentaId
        LEFT JOIN PuntosVenta AS T5 ON T5.PuntoVentaId=T1.PuntoVentaId
        LEFT JOIN (SELECT VentaId,Monto FROM AccesorioVentaPago WHERE TipoPagoId=1) AS T6 ON T6.VentaId=T1.VentaId
        LEFT JOIN (SELECT VentaId,Monto FROM AccesorioVentaPago WHERE TipoPagoId=2) AS T7 ON T7.VentaId=T1.VentaId
        LEFT JOIN (SELECT VentaId,SUM(Monto)Total FROM AccesorioVentaPago GROUP BY VentaId) AS T8 ON T8.VentaId=T1.VentaId
        WHERE T1.VentaId=$VentaId LIMIT 1";

		$R0=$this->Consulta($Q0);
		$arreglo=$this->fetch_row($R0);
	
       	$Datos='<title>Venta</title> </head>';	 
    $Datos.='<body bgcolor="#ffffff" rightmargin="0" leftmargin="0" topmargin="0" style="margin-top:0; margin-bottom:0; margin-right:0; margin-left:0">';
    $Datos.='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">';
    $Datos.='<tr> <td height="1"></td></tr><tr>';
    $Datos.='<td class="EtiquetasFormulario"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF"><tr>';          
    $Datos.='<td width="180"  height="26"><div align="center" class="LabelsMenuLeft"><strong>Datos de la Venta.</strong></div></td>';        
    $Datos.='<td>&nbsp;&nbsp;&nbsp;</td></tr></table></td></tr><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';        
    $Datos.='<td width="85%"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#C0D8EF"><tr height="20">';          
    $Datos.='<td width="19%"><span class="LabelsMenuLeft">PuntoVenta</span></td>';                                                           
    $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>';
    $Datos.=                  $arreglo[3]; echo'</strong></td>';
   $Datos.='                   <td width="16%"><span class="LabelsMenuLeft"></span></td>';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"></td>';
   $Datos.='                 </tr>';
   $Datos.='                 <tr height="20" bgcolor="#E6EFF9"> ';
   $Datos.='                   <td><span class="LabelsMenuLeft">Fecha:</span></td> ';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>';    
   $Datos.=                 $arreglo[1];  echo'</strong></td>';
   $Datos.='                   <td class="LabelsMenuLeft">Hora:</td>';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>';
   $Datos.=                 $arreglo[2];  echo' </strong></td> ';                   
   $Datos.='                 </tr>';
   
   $Datos.='                 <tr height="20" bgcolor="#E6EFF9">';
   $Datos.='                   <td class="LabelsMenuLeft">Usuario:</td>';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>';
   $Datos.=                  $arreglo[0];  echo' </strong></td> ';
   $Datos.='                   <td class="LabelsMenuLeft">Tipo Venta</td>';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>';
   $Datos.=                   $arreglo[6]; echo' </strong></td>';
   $Datos.='                 </tr>';
   
   $Datos.='                 <tr height="20" bgcolor="#E6EFF9">';
   $Datos.='                   <td class="LabelsMenuLeft">Efectivo:</td>';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>$';
   $Datos.=                  $arreglo[7];  echo' </strong></td> ';
   $Datos.='                   <td class="LabelsMenuLeft">Credito</td>';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>$';
   $Datos.=                   $arreglo[8]; echo' </strong></td>';
   $Datos.='                 </tr>';
   
   $Datos.='                 <tr height="20" bgcolor="#E6EFF9">';
   $Datos.='                   <td class="LabelsMenuLeft">Total Accesorios</td>';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>';
   $Datos.=                  $arreglo[4];  echo' </strong></td> ';
   $Datos.='                   <td class="LabelsMenuLeft">Total Venta</td>';
   $Datos.='                   <td colspan="2" class="LabelsMenuLeft"><strong>$';
   $Datos.=                   $arreglo[9]; echo' </strong></td>';
   $Datos.='                 </tr>';
   
  
    
   $Datos.='               </table></td>';
   $Datos.='            </tr>';
   $Datos.='           </table></td> ';
   $Datos.='         </tr>';
   $Datos.='           </table></td> ';
   $Datos.='         </tr> ';  
   $Datos.='         <tr> ';
   $Datos.='           <td><table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#FFFFFF">  ';
   $Datos.='             <tr height="20">  ';
   $Datos.='               <td width="24%" bgcolor="#4F91D2" class="LabelsMenuLeft">Item</td>           ';
   $Datos.='               <td width="42%" bgcolor="#4F91D2" class="LabelsMenuLeft">Descripcion</td>    ';
   $Datos.='               <td width="42%" bgcolor="#4F91D2" class="LabelsMenuLeft">Precio</td>    ';
   $Datos.='               <td width="34%" bgcolor="#4F91D2" class="LabelsMenuLeft">Cantidad</td>     ';   
   $Datos.='             </tr>';
   
                 $Q2="SELECT T2.Clave,T2.Descripcion,T1.Cantidad,FORMAT(T1.Precio,2) FROM AccesorioVentaDetalle AS T1
                      LEFT JOIN Accesorios AS T2 ON T2.AccesorioId=T1.AccesorioId
                      WHERE T1.VentaId=$VentaId";               
 				$R2=$this->Consulta($Q2);
				
			while($A2=mysql_fetch_row($R2)){	  
   
 $Datos.='		            <tr height="20">  ';
 $Datos.='                 <td class="LabelsMenuLeft"  bgcolor="#C0D8EF"><strong>';
 $Datos.=                  $A2[0];  echo'</strong></td> ';
 $Datos.='                 <td class="LabelsMenuLeft"  bgcolor="#C0D8EF"><strong>';   
 $Datos.=                  $A2[1];  echo'</strong></td>    '; 
 $Datos.='                 <td class="LabelsMenuLeft"  bgcolor="#C0D8EF"><strong>$';   
 $Datos.=                  $A2[3];      echo'</strong></td>';
 $Datos.='                 <td class="LabelsMenuLeft"  bgcolor="#C0D8EF"><strong>';   
 $Datos.=                  $A2[2];      echo'</strong></td>';
 $Datos.='               </tr>   ';
                 
			              
				}	
				
$Datos.='				<tr>';
 $Datos.='		   <td class="LabelsMenuLeft" bgcolor="#C0D8EF">Comentario:</td>';
 $Datos.='                     <td colspan="2" class="LabelsMenuLeft" bgcolor="#C0D8EF"><strong>';
 $Datos.=                   $arreglo[5];  echo' </strong></td>';
 $Datos.='		   </tr>';				 
 
 $Datos.='             </table></td>      ';
 $Datos.='           </tr>         ';
 $Datos.='           <tr>        ';
 $Datos.='             <td>&nbsp;</td>  ';
 $Datos.='           </tr>              ';
 $Datos.='           <tr>    ';
 $Datos.='			    <td height="23" class="LabelPie">&nbsp;</td> ';
 $Datos.='		    </tr>             ';
 $Datos.='          </table>      ';
 $Datos.='            </body>    ';
 $Datos.='               </html>  ';	
	
	return $Datos;
	
	}
      
  
  function str2num($str)
   { 
          
	    if(strpos($str, '.') < strpos($str,','))
		{ 
        $str = str_replace('.','',$str); 
        $str = strtr($str,',','.');            
        } 
        
		else
		{ 
        $str = str_replace(',','',$str);            
        } 
        return (float)$str; 
    } 	

  function SaveNumFactura($VentaId=0,$Factura=0)
  {	   	
	  $Q0="UPDATE AccVentas SET Factura='$Factura' WHERE VentaId=$VentaId";
	  $this->Consulta($Q0);	
	}	
		
}//De la clase
?>
