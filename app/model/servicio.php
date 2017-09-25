<?php
namespace App\Model;
use App\Lib\PHPMailer;
class Servicio {
	
    private $key = '123456789012345678901234';
	private $iv = 'password';
	
    public function __CONSTRUCT() {
    }

    public function descifrar($key, $iv, $data) {
        if (strlen($key) != 24) {
            echo "La longitud de la key ha de ser de 24 dígitos.<br>";
            return -1;
        }
        if ((strlen($iv) % 8 ) != 0) {
            echo "La longitud del vector iv ha de ser múltiple de 8 dígitos.<br>";
            return -2;
        }
        return @mcrypt_decrypt(MCRYPT_3DES, $key, base64_decode($data), MCRYPT_MODE_CBC, $iv);
    }

    public function cifrar($key, $iv, $data) {
        return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $data, MCRYPT_MODE_CBC, $iv));
    }

    public function limpiarCadena($cadena) {
        return (ereg_replace('[^ A-Za-z0-9_-ñÑ,\\@\.\-]', '', $cadena));
    }

   public function generateRandomString($length = 10) {	 
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function getKey() {
        return $this->key;
    }
    public function getIv() {
        return $this->iv;
	}	
	
	
    
    public function enviarEmail($data) {
		//print_r($data);exit;
		$lineaTemp = (array) $data[0];
        $factAnt = $lineaTemp['EntryFactWeb'];
        $factAux = $lineaTemp['EntryFactWeb'];
		$cuerpo = '';
		//echo $lineaTemp['EmailPerfil'];exit;
		
		$mail = new PHPMailer();
		$mail->setFrom('Legalisapp@css.com', 'Legalisapp');
		$mail->addAddress($lineaTemp['EmailPerfil'], 'Perfil');
		$mail->Subject  = 'Informacion Legalizacion';
		$mail->IsHTML(true);
		//echo "aqui voy nojodaa";exit;
		/*$mail->Body     = 'Prueba imagen.';
		$mail->addAttachment('../app/model/Adjuntos/Red prueba.jpeg');
		$mail->send();*/
		//if(!$mail->send()) {
		  //echo 'Message was not sent.';
		  //echo 'Mailer error: ' . $mail->ErrorInfo;
		//} else {
		  //echo 'Message has been sent.';
		//}
       
/*
        $email_to = $lineaTemp['Aprobador'];
        $email_from = $lineaTemp['EmailPerfil'];
        $email_subject = "Informacion Legalizacion";*/
        $cuerpo2 = '';
        $cuerpo = '


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
		
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit ;
			text-decoration:none ;
			font-size:inherit ;
			font-family:inherit ;
			font-weight:inherit ;
			line-height:inherit ;
		}
		#bodyCell{
			padding:10px;
			border-top:0;
		}
		.templateContainer{
			max-width:600px ;
			border:0;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto ;
		}
		.mcnDividerBlock{
			table-layout:fixed ;
		}

		body,#bodyTable{
			background-color:#ebebeb;
		}

		#bodyCell{
			border-top:0;
		}

		.templateContainer{
			border:0;
		}

		h1{
			color:#202020;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h2{
			color:#202020;
			font-family:Helvetica;
			font-size:22px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h3{
			color:#202020;
			font-family:Helvetica;
			font-size:20px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h4{
			color:#202020;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
		#templatePreheader{
			background-color:#FAFAFA;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:9px;
		}
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			color:#656565;
			font-family:Helvetica;
			font-size:12px;
			line-height:150%;
			text-align:left;
		}
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			color:#656565;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateHeader{
			background-color:#ffffff;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:0;
		}
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:16px;
			line-height:150%;
			text-align:left;
		}
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			color:#2BAADF;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateBody{
			background-color:#FFFFFF;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:2px solid #EAEAEA;
			padding-top:0;
			padding-bottom:9px;
		}
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:16px;
			line-height:150%;
			text-align:left;
		}
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			color:#2BAADF;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateFooter{
			background-color:#FAFAFA;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:9px;
		}
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			color:#656565;
			font-family:Helvetica;
			font-size:12px;
			line-height:150%;
			text-align:center;
		}
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			color:#656565;
			font-weight:normal;
			text-decoration:underline;
		}




		table#miyazaki { 
		  margin: 0 auto;
		  border-collapse: collapse;
		  font-family:Helvetica;
		  font-size:11px;
		  font-weight: 100; 
		  background: #202020; 
		  color: #fff;
		  text-rendering: optimizeLegibility;
		}
		table#miyazaki thead th { font-weight: 600; }
		table#miyazaki thead th, table#miyazaki tbody td { 
		  padding: .8rem; font-size:11px;
		}
		table#miyazaki tbody td { 
		  padding: .8rem; 
		  font-size:11px;
		  color: #202020; 
		  background: #eee; 
		}
		table#miyazaki tbody tr:not(:last-child) { 
		  border-top: 1px solid #ddd;
		  border-bottom: 1px solid #ddd;  
		}

		@media screen and (max-width: 650px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 310px;
		    overflow-y: hidden;
		    overflow-x: auto;

		  }
		}

		@media screen and (max-width: 650px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 100%;
		    overflow-y: hidden;
		    overflow-x: auto;

		  }
		}

		@media screen and (max-width: 485px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 300px;
		    overflow-y: hidden;
		    overflow-x: auto;
			display: block;
		  }
		}


		



			@media only screen and (min-width:768px){
				.templateContainer{
					width:600px ;
				}

		}	@media only screen and (max-width: 480px){
				body,table,td,p,a,li,blockquote{
					-webkit-text-size-adjust:none ;
				}

		}	@media only screen and (max-width: 480px){
				body{
					width:100% ;
					min-width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				#bodyCell{
					padding-top:10px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImage{
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer{
					max-width:100% ;
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnBoxedTextContentContainer{
					min-width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupContent{
					padding:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
					padding-top:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardTopImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
					padding-top:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardBottomImageContent{
					padding-bottom:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupBlockInner{
					padding-top:0 ;
					padding-bottom:0 ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupBlockOuter{
					padding-top:9px ;
					padding-bottom:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnTextContent,.mcnBoxedTextContentColumn{
					padding-right:18px ;
					padding-left:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
					padding-right:18px ;
					padding-bottom:0 ;
					padding-left:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcpreview-image-uploader{
					display:none ;
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				h1{
					font-size:14px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h2{
					font-size:20px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h3{
					font-size:18px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h4{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templatePreheader{
					display:block ;
				}

		}	@media only screen and (max-width: 480px){
				#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}

</style>
	</head>
    <body>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templatePreheader"  style="background-color: #043f7d"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">

</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:390px;" width="100%" class="mcnTextContentContainer">
                    <tbody>
                        
                        <tr>
                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px; color: #fff">
                                Recuerde revisar las facturas correspondientes a la legalizacion:	
                            </td>																				
                        </tr>
                </tbody></table>
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:210px;" width="100%" class="mcnTextContentContainer">
                    <tbody>
						<tr>
							<td valign="top" class="mcnTextContent" style="padding-top: 0; padding-left: 5px; padding-right: 10px;
    color: #fff;
    float: right;">
                                ' . $lineaTemp['EntryLegMovil'] . '
                            </td>
						</tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader"></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">





















		<tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">

            <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>
						<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Descripcion:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:5px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['DescripcionLega'] . '</h1>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:5px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorLega'] . '</h1>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Perfil:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:15px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['NombrePerfil'] . '</h1>
	                        </td>
	                    </tr>


                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
	                            <h1 style="font-size: 18px;">INFORME DE LA FACTURA</h1>
	                        </td>
                    	</tr>

                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Referencia:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Referencia'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorFact'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Fecha:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Fecha'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>

					 </tbody></table>


        
			';

			

			$files = array();
			/*if ($lineaTemp['Adjunto']!==''&&$lineaTemp['Adjunto']!==NULL&&$lineaTemp['Adjunto']!==null&&!empty($lineaTemp['Adjunto'])&&strlen($lineaTemp['Adjunto'])>10) {
				define('UPLOAD_DIR', '../app/model/Adjuntos/');
				$img = $lineaTemp['Adjunto'];
				$img = str_replace('data:image/jpeg;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data1 = base64_decode($img);
				$file = UPLOAD_DIR .$lineaTemp['Referencia']. '.jpeg';
				$success = file_put_contents($file, $data1);
				array_push($files,$file);
			}*/
			
			for ($i = 0; $i < (count($data)); $i++) {
				$lineaTemp = (array) $data[$i];
				$factAnt = $factAux;
				$factAux = $lineaTemp['EntryFactWeb'];


				/*if ($lineaTemp['Adjunto']!==''&&$lineaTemp['Adjunto']!==NULL&&$lineaTemp['Adjunto']!==null&&!empty($lineaTemp['Adjunto'])&&strlen($lineaTemp['Adjunto'])>10) {
					define('UPLOAD_DIR', '../app/model/Adjuntos/');
					$img = $lineaTemp['Adjunto'];
					$img = str_replace('data:image/jpeg;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$data = base64_decode($img);
					$file = UPLOAD_DIR .$lineaTemp['Referencia']. '.jpeg';
					$success = file_put_contents($file, $data);
					array_push($files,$file);
				}*/
	
				$info = $lineaTemp['Info1'];
				if ($lineaTemp['Info2'] !== null && $lineaTemp['Info2'] !== '' && $lineaTemp['Info2'] !== 'null') {
					$info = $info . " - " . $lineaTemp['Info2'];
				}
				if ($lineaTemp['Info3'] !== null && $lineaTemp['Info3'] !== '' && $lineaTemp['Info3'] !== 'null') {
					$info = $info . " - " . $lineaTemp['Info3'];
				}
	
				if ($factAnt !== $factAux) {
					if ($lineaTemp['Adjunto']!==''&&$lineaTemp['Adjunto']!==NULL&&$lineaTemp['Adjunto']!==null&&!empty($lineaTemp['Adjunto'])&&strlen($lineaTemp['Adjunto'])>10) {
						define('UPLOAD_DIR', '../app/model/Adjuntos/');
						$img = $lineaTemp['Adjunto'];
						$img = str_replace('data:image/jpeg;base64,', '', $img);
						$img = str_replace(' ', '+', $img);
						$data3 = base64_decode($img);
						$file = UPLOAD_DIR .$lineaTemp['Referencia']. '.jpeg';
						$success = file_put_contents($file, $data3);
						array_push($files,$file);
					}
					$cuerpo = $cuerpo . '
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
	                            <h1 style="font-size: 18px;">INFORME DE LA FACTURA</h1>
	                        </td>
                    	</tr>

                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Referencia:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Referencia'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorFact'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Fecha:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Fecha'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>

						








						
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Moneda:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Moneda'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Valor'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Gasto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['NombreGasto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Info:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Info1'] . '</h1>
	                            <p></p>
	                        </td>

                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Impuesto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Impuesto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Tipo doc:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">'.$lineaTemp['TipoDoc'].'</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Documento:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Documento'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Nota:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Notas'] . '</h1>
	                            <p></p>
	                        </td>
						</tr>
						
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>

                </tbody></table>
					';
	            } else {
					if ($lineaTemp['Adjunto']!==''&&$lineaTemp['Adjunto']!==NULL&&$lineaTemp['Adjunto']!==null&&!empty($lineaTemp['Adjunto'])&&strlen($lineaTemp['Adjunto'])>10) {
						define('UPLOAD_DIR', '../app/model/Adjuntos/');
						$img = $lineaTemp['Adjunto'];
						$img = str_replace('data:image/jpeg;base64,', '', $img);
						$img = str_replace(' ', '+', $img);
						$data4 = base64_decode($img);
						$file = UPLOAD_DIR .$lineaTemp['Referencia']. '.jpeg';
						$success = file_put_contents($file, $data4);
						array_push($files,$file);
					}
	                $cuerpo = $cuerpo . '
				<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>			
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Moneda:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Moneda'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Valor'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Gasto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['NombreGasto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Info:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['ComentarioLine'] . '</h1>
	                            <p></p>
	                        </td>

                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Impuesto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Impuesto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Tipo doc:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">'.$lineaTemp['TipoDoc'].'</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Documento:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Documento'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Nota:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Notas'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>


                </tbody></table>';
			}
			
        }


       // $cuerpo2 = $cuerpo;
       /* $cuerpo = $cuerpo . '
				

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>


<td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                	<p style="color: #656565;
											    font-family: Helvetica;
											    font-size: 12px;
											    line-height: 150%;
											    text-align: center;font-weight: bold;">
                                		CODIGO DE VERIFICACION:
                                	</p>
                                	<p style="color: #202020;
											    font-family: Helvetica;
											    font-size: 18px"><strong>' . $lineaTemp['NoAprobacion'] . '</strong></p>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
';*/

        $cuerpo = $cuerpo . '

            </td>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 10px 18px 25px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #EEEEEE;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">          
						Crea y Autoriza Legalizaciones de manera Offline<br>
					    Mas informacion <a href="http://www.consensussa.com/">www.consensussa.com</a></a>
						<br><br>
						<em>Copyright  |  2016  |  Consensus s.a.s<br> Todos los derechos reservados.</em>
					                        </td>
					                    </tr>
					                    
					                </tbody></table>
					            </td>
					        </tr>
					    </tbody>
					    
					</table></td>

                            </tr>

                        </table>

                    </td>

                </tr>
                
            </table>

        </center>

    </body>
</html>

';



        /*$cabecera = "MIME-Version: 1.0\r\n";
		$cabecera .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$mail->addCustomHeader($cabecera);*/
		$mail->Body = $cuerpo;

		//print_r($files);exit;
		if (!empty($files)) {
			foreach ($files as $fil) {
				$mail->addAttachment($fil);	
			}
		}
		//$mail->addAttachment('../app/model/Adjuntos/Red prueba.jpeg');
		//$mail->send();
		if(!$mail->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
		  //echo 'Message has been sent.';
		}


        /*if ($lineaTemp['Dimension2'] === '1' || $lineaTemp['Dimension2'] === 1) {
            @mail($email_to, $email_subject, $cuerpo, $cabecera);
        }
        @mail($email_from, $email_subject, $cuerpo2, $cabecera);*/
	}
	




	public function enviarEmailAprobador($data) {
		$lineaTemp = (array) $data[0];
        $factAnt = $lineaTemp['EntryFactWeb'];
        $factAux = $lineaTemp['EntryFactWeb'];
		$cuerpo = '';
		//echo $lineaTemp['EmailPerfil'];exit;
		$mail2 = new PHPMailer();
		$mail2->setFrom('Legalisapp@css.com', 'Legalisapp');
		$mail2->addAddress($lineaTemp['Aprobador'], 'Aprobador');
		$mail2->Subject  = 'Informacion Legalizacion';
		$mail2->IsHTML(true);
		//echo "aqui voy nojodaa";exit;
		/*$mail->Body     = 'Prueba imagen.';
		$mail->addAttachment('../app/model/Adjuntos/Red prueba.jpeg');
		$mail->send();*/
		//if(!$mail->send()) {
		  //echo 'Message was not sent.';
		  //echo 'Mailer error: ' . $mail->ErrorInfo;
		//} else {
		  //echo 'Message has been sent.';
		//}
       
/*
        $email_to = $lineaTemp['Aprobador'];
        $email_from = $lineaTemp['EmailPerfil'];
        $email_subject = "Informacion Legalizacion";*/
        $cuerpo2 = '';
        $cuerpo = '


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
		
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit ;
			text-decoration:none ;
			font-size:inherit ;
			font-family:inherit ;
			font-weight:inherit ;
			line-height:inherit ;
		}
		#bodyCell{
			padding:10px;
			border-top:0;
		}
		.templateContainer{
			max-width:600px ;
			border:0;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto ;
		}
		.mcnDividerBlock{
			table-layout:fixed ;
		}

		body,#bodyTable{
			background-color:#ebebeb;
		}

		#bodyCell{
			border-top:0;
		}

		.templateContainer{
			border:0;
		}

		h1{
			color:#202020;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h2{
			color:#202020;
			font-family:Helvetica;
			font-size:22px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h3{
			color:#202020;
			font-family:Helvetica;
			font-size:20px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h4{
			color:#202020;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
		#templatePreheader{
			background-color:#FAFAFA;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:9px;
		}
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			color:#656565;
			font-family:Helvetica;
			font-size:12px;
			line-height:150%;
			text-align:left;
		}
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			color:#656565;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateHeader{
			background-color:#ffffff;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:0;
		}
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:16px;
			line-height:150%;
			text-align:left;
		}
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			color:#2BAADF;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateBody{
			background-color:#FFFFFF;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:2px solid #EAEAEA;
			padding-top:0;
			padding-bottom:9px;
		}
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:16px;
			line-height:150%;
			text-align:left;
		}
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			color:#2BAADF;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateFooter{
			background-color:#FAFAFA;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:9px;
		}
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			color:#656565;
			font-family:Helvetica;
			font-size:12px;
			line-height:150%;
			text-align:center;
		}
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			color:#656565;
			font-weight:normal;
			text-decoration:underline;
		}




		table#miyazaki { 
		  margin: 0 auto;
		  border-collapse: collapse;
		  font-family:Helvetica;
		  font-size:11px;
		  font-weight: 100; 
		  background: #202020; 
		  color: #fff;
		  text-rendering: optimizeLegibility;
		}
		table#miyazaki thead th { font-weight: 600; }
		table#miyazaki thead th, table#miyazaki tbody td { 
		  padding: .8rem; font-size:11px;
		}
		table#miyazaki tbody td { 
		  padding: .8rem; 
		  font-size:11px;
		  color: #202020; 
		  background: #eee; 
		}
		table#miyazaki tbody tr:not(:last-child) { 
		  border-top: 1px solid #ddd;
		  border-bottom: 1px solid #ddd;  
		}

		@media screen and (max-width: 650px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 310px;
		    overflow-y: hidden;
		    overflow-x: auto;

		  }
		}

		@media screen and (max-width: 650px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 100%;
		    overflow-y: hidden;
		    overflow-x: auto;

		  }
		}

		@media screen and (max-width: 485px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 300px;
		    overflow-y: hidden;
		    overflow-x: auto;
			display: block;
		  }
		}


		



			@media only screen and (min-width:768px){
				.templateContainer{
					width:600px ;
				}

		}	@media only screen and (max-width: 480px){
				body,table,td,p,a,li,blockquote{
					-webkit-text-size-adjust:none ;
				}

		}	@media only screen and (max-width: 480px){
				body{
					width:100% ;
					min-width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				#bodyCell{
					padding-top:10px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImage{
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer{
					max-width:100% ;
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnBoxedTextContentContainer{
					min-width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupContent{
					padding:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
					padding-top:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardTopImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
					padding-top:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardBottomImageContent{
					padding-bottom:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupBlockInner{
					padding-top:0 ;
					padding-bottom:0 ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupBlockOuter{
					padding-top:9px ;
					padding-bottom:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnTextContent,.mcnBoxedTextContentColumn{
					padding-right:18px ;
					padding-left:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
					padding-right:18px ;
					padding-bottom:0 ;
					padding-left:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcpreview-image-uploader{
					display:none ;
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				h1{
					font-size:14px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h2{
					font-size:20px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h3{
					font-size:18px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h4{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templatePreheader{
					display:block ;
				}

		}	@media only screen and (max-width: 480px){
				#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}

</style>
	</head>
    <body>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templatePreheader"  style="background-color: #043f7d"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">

</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:390px;" width="100%" class="mcnTextContentContainer">
                    <tbody>
                        
                        <tr>
                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px; color: #fff">
                                Recuerde revisar las facturas correspondientes a la legalizacion:	
                            </td>																				
                        </tr>
                </tbody></table>
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:210px;" width="100%" class="mcnTextContentContainer">
                    <tbody>
						<tr>
							<td valign="top" class="mcnTextContent" style="padding-top: 0; padding-left: 5px; padding-right: 10px;
    color: #fff;
    float: right;">
                                ' . $lineaTemp['EntryLegMovil'] . '
                            </td>
						</tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader"></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">





















		<tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">

            <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>
						<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Descripcion:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:5px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['DescripcionLega'] . '</h1>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:5px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorLega'] . '</h1>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Perfil:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:15px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['NombrePerfil'] . '</h1>
	                        </td>
	                    </tr>


                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
	                            <h1 style="font-size: 18px;">INFORME DE LA FACTURA</h1>
	                        </td>
                    	</tr>

                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Referencia:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Referencia'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorFact'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Fecha:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Fecha'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>

					 </tbody></table>


        
			';

			

			$files2 = array();
			/*if ($lineaTemp['Adjunto']!==''&&$lineaTemp['Adjunto']!==NULL&&$lineaTemp['Adjunto']!==null&&!empty($lineaTemp['Adjunto'])&&strlen($lineaTemp['Adjunto'])>10) {
				define('UPLOAD_DIR', '../app/model/Adjuntos/');
				$img = $lineaTemp['Adjunto'];
				$img = str_replace('data:image/jpeg;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data5 = base64_decode($img);
				$file2 = UPLOAD_DIR .$lineaTemp['Referencia']. '.jpeg';
				$success = file_put_contents($file2, $data5);
				array_push($files2,$file2);
			}*/
			for ($i = 0; $i < (count($data)); $i++) {
				$lineaTemp = (array) $data[$i];
				$factAnt = $factAux;
				$factAux = $lineaTemp['EntryFactWeb'];
	
				$info = $lineaTemp['Info1'];
				if ($lineaTemp['Info2'] !== null && $lineaTemp['Info2'] !== '' && $lineaTemp['Info2'] !== 'null') {
					$info = $info . " - " . $lineaTemp['Info2'];
				}
				if ($lineaTemp['Info3'] !== null && $lineaTemp['Info3'] !== '' && $lineaTemp['Info3'] !== 'null') {
					$info = $info . " - " . $lineaTemp['Info3'];
				}
	
				if ($factAnt !== $factAux) {
					if ($lineaTemp['Adjunto']!==''&&$lineaTemp['Adjunto']!==NULL&&$lineaTemp['Adjunto']!==null&&!empty($lineaTemp['Adjunto'])&&strlen($lineaTemp['Adjunto'])>10) {
						define('UPLOAD_DIR', '../app/model/Adjuntos/');
						$img = $lineaTemp['Adjunto'];
						$img = str_replace('data:image/jpeg;base64,', '', $img);
						$img = str_replace(' ', '+', $img);
						$data6 = base64_decode($img);
						$file2 = UPLOAD_DIR .$lineaTemp['Referencia']. '.jpeg';
						$success = file_put_contents($file2, $data6);
						array_push($files2,$file2);
					}
					$cuerpo = $cuerpo . '
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
	                            <h1 style="font-size: 18px;">INFORME DE LA FACTURA</h1>
	                        </td>
                    	</tr>

                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Referencia:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Referencia'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorFact'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Fecha:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Fecha'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>

						








						
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Moneda:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Moneda'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Valor'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Gasto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['NombreGasto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Info:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Info1'] . '</h1>
	                            <p></p>
	                        </td>

                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Impuesto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Impuesto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Tipo doc:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">'.$lineaTemp['TipoDoc'].'</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Documento:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Documento'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Nota:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Notas'] . '</h1>
	                            <p></p>
	                        </td>
						</tr>
						
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>

                </tbody></table>
					';
	            } else {
					if ($lineaTemp['Adjunto']!==''&&$lineaTemp['Adjunto']!==NULL&&$lineaTemp['Adjunto']!==null&&!empty($lineaTemp['Adjunto'])&&strlen($lineaTemp['Adjunto'])>10) {
						define('UPLOAD_DIR', '../app/model/Adjuntos/');
						$img = $lineaTemp['Adjunto'];
						$img = str_replace('data:image/jpeg;base64,', '', $img);
						$img = str_replace(' ', '+', $img);
						$data7 = base64_decode($img);
						$file = UPLOAD_DIR .$lineaTemp['Referencia']. '.jpeg';
						$success = file_put_contents($file, $data7);
						array_push($files2,$file);
					}
	                $cuerpo = $cuerpo . '
				<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>			
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Moneda:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Moneda'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Valor'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Gasto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['NombreGasto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Info:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Info1'] . '</h1>
	                            <p></p>
	                        </td>

                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Impuesto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Impuesto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Tipo doc:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">'.$lineaTemp['TipoDoc'].'</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Documento:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Documento'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Nota:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Notas'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>


                </tbody></table>';
            }
        }


       // $cuerpo2 = $cuerpo;
        $cuerpo = $cuerpo . '
				

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>


<td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                	<p style="color: #656565;
											    font-family: Helvetica;
											    font-size: 12px;
											    line-height: 150%;
											    text-align: center;font-weight: bold;">
                                		CODIGO DE VERIFICACION:
                                	</p>
                                	<p style="color: #202020;
											    font-family: Helvetica;
											    font-size: 18px"><strong>' . $lineaTemp['NoAprobacion'] . '</strong></p>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
';

      



        /*$cabecera = "MIME-Version: 1.0\r\n";
		$cabecera .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$mail->addCustomHeader($cabecera);*/
		$mail2->Body = $cuerpo;

		
		if (!empty($files2)) {
			foreach ($files2 as $fil2) {
				$mail2->addAttachment($fil2);	
			}
		}
		//$mail->addAttachment('../app/model/Adjuntos/Red prueba.jpeg');
		//$mail->send();
		if(!$mail2->send()) {
		  echo 'Message was not sent.';
		  echo 'Mailer error: ' . $mail2->ErrorInfo;
		} else {
		  //echo 'Message has been sent.';
		}


        /*if ($lineaTemp['Dimension2'] === '1' || $lineaTemp['Dimension2'] === 1) {
            @mail($email_to, $email_subject, $cuerpo, $cabecera);
        }
        @mail($email_from, $email_subject, $cuerpo2, $cabecera);*/
	}

    
	
    /*public function enviarEmail($data) {
        $lineaTemp = (array) $data[0];
        $factAnt = $lineaTemp['EntryFactWeb'];
        $factAux = $lineaTemp['EntryFactWeb'];

        $email_to = $lineaTemp['Aprobador'];
        $email_from = $lineaTemp['EmailPerfil'];
        $email_subject = "Informacion Legalizacion";
        $cuerpo2 = '';
        $cuerpo = '


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
		
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit ;
			text-decoration:none ;
			font-size:inherit ;
			font-family:inherit ;
			font-weight:inherit ;
			line-height:inherit ;
		}
		#bodyCell{
			padding:10px;
			border-top:0;
		}
		.templateContainer{
			max-width:600px ;
			border:0;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto ;
		}
		.mcnDividerBlock{
			table-layout:fixed ;
		}

		body,#bodyTable{
			background-color:#ebebeb;
		}

		#bodyCell{
			border-top:0;
		}

		.templateContainer{
			border:0;
		}

		h1{
			color:#202020;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h2{
			color:#202020;
			font-family:Helvetica;
			font-size:22px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h3{
			color:#202020;
			font-family:Helvetica;
			font-size:20px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}

		h4{
			color:#202020;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			text-align:left;
		}
		#templatePreheader{
			background-color:#FAFAFA;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:9px;
		}
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			color:#656565;
			font-family:Helvetica;
			font-size:12px;
			line-height:150%;
			text-align:left;
		}
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			color:#656565;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateHeader{
			background-color:#ffffff;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:0;
		}
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:16px;
			line-height:150%;
			text-align:left;
		}
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			color:#2BAADF;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateBody{
			background-color:#FFFFFF;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:2px solid #EAEAEA;
			padding-top:0;
			padding-bottom:9px;
		}
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			color:#202020;
			font-family:Helvetica;
			font-size:16px;
			line-height:150%;
			text-align:left;
		}
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			color:#2BAADF;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateFooter{
			background-color:#FAFAFA;
			background-image:none;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
			border-top:0;
			border-bottom:0;
			padding-top:9px;
			padding-bottom:9px;
		}
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			color:#656565;
			font-family:Helvetica;
			font-size:12px;
			line-height:150%;
			text-align:center;
		}
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			color:#656565;
			font-weight:normal;
			text-decoration:underline;
		}

		table#miyazaki { 
		  margin: 0 auto;
		  border-collapse: collapse;
		  font-family:Helvetica;
		  font-size:11px;
		  font-weight: 100; 
		  background: #202020; 
		  color: #fff;
		  text-rendering: optimizeLegibility;
		}
		table#miyazaki thead th { font-weight: 600; }
		table#miyazaki thead th, table#miyazaki tbody td { 
		  padding: .8rem; font-size:11px;
		}
		table#miyazaki tbody td { 
		  padding: .8rem; 
		  font-size:11px;
		  color: #202020; 
		  background: #eee; 
		}
		table#miyazaki tbody tr:not(:last-child) { 
		  border-top: 1px solid #ddd;
		  border-bottom: 1px solid #ddd;  
		}

		@media screen and (max-width: 650px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 310px;
		    overflow-y: hidden;
		    overflow-x: auto;

		  }
		}

		@media screen and (max-width: 650px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 100%;
		    overflow-y: hidden;
		    overflow-x: auto;

		  }
		}

		@media screen and (max-width: 485px) {
		  table#miyazaki tbody { 
		    padding-bottom: .4rem; 
		    padding-top: 0px;

		    width: 300px;
		    overflow-y: hidden;
		    overflow-x: auto;
			display: block;
		  }
		}


			@media only screen and (min-width:768px){
				.templateContainer{
					width:600px ;
				}

		}	@media only screen and (max-width: 480px){
				body,table,td,p,a,li,blockquote{
					-webkit-text-size-adjust:none ;
				}

		}	@media only screen and (max-width: 480px){
				body{
					width:100% ;
					min-width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				#bodyCell{
					padding-top:10px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImage{
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer{
					max-width:100% ;
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnBoxedTextContentContainer{
					min-width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupContent{
					padding:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
					padding-top:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardTopImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
					padding-top:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardBottomImageContent{
					padding-bottom:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupBlockInner{
					padding-top:0 ;
					padding-bottom:0 ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageGroupBlockOuter{
					padding-top:9px ;
					padding-bottom:9px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnTextContent,.mcnBoxedTextContentColumn{
					padding-right:18px ;
					padding-left:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
					padding-right:18px ;
					padding-bottom:0 ;
					padding-left:18px ;
				}

		}	@media only screen and (max-width: 480px){
				.mcpreview-image-uploader{
					display:none ;
					width:100% ;
				}

		}	@media only screen and (max-width: 480px){
				h1{
					font-size:14px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h2{
					font-size:20px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h3{
					font-size:18px ;
					line-height:125% ;
				}

		}	@media only screen and (max-width: 480px){
				h4{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templatePreheader{
					display:block ;
				}

		}	@media only screen and (max-width: 480px){
				#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
					font-size:16px ;
					line-height:150% ;
				}

		}	@media only screen and (max-width: 480px){
				#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
					font-size:14px ;
					line-height:150% ;
				}

		}

</style>
	</head>
    <body>
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templatePreheader"  style="background-color: #043f7d"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">

</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:390px;" width="100%" class="mcnTextContentContainer">
                    <tbody>
                        
                        <tr>
                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px; color: #fff">
                                Recuerde revisar las facturas correspondientes a la legalizacion:	
                            </td>																				
                        </tr>
                </tbody></table>
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:210px;" width="100%" class="mcnTextContentContainer">
                    <tbody>
						<tr>
							<td valign="top" class="mcnTextContent" style="padding-top: 0; padding-left: 5px; padding-right: 10px;
    color: #fff;
    float: right;">
                                ' . $lineaTemp['EntryLegMovil'] . '
                            </td>
						</tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader"></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">





















		<tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">

            <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>
						<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Descripcion:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:5px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['DescripcionLega'] . '</h1>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:5px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorLega'] . '</h1>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Perfil:</h1>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:15px; padding-left:0px; float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['NombrePerfil'] . '</h1>
	                        </td>
	                    </tr>



                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
	                            <h1 style="font-size: 18px;">INFORME DE LA FACTURA</h1>
	                        </td>
                    	</tr>

                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Referencia:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Referencia'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorFact'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Fecha:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Fecha'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>

					 </tbody></table>


        
			';
			for ($i = 0; $i < (count($data)); $i++) {
            $lineaTemp = (array) $data[$i];
            $factAnt = $factAux;
            $factAux = $lineaTemp['EntryFactWeb'];

            $info = $lineaTemp['Info1'];
            if ($lineaTemp['Info2'] !== null && $lineaTemp['Info2'] !== '' && $lineaTemp['Info2'] !== 'null') {
                $info = $info . " - " . $lineaTemp['Info2'];
            }
            if ($lineaTemp['Info3'] !== null && $lineaTemp['Info3'] !== '' && $lineaTemp['Info3'] !== 'null') {
                $info = $info . " - " . $lineaTemp['Info3'];
            }

            if ($factAnt !== $factAux) {
                $cuerpo = $cuerpo . '

                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
	                            <h1 style="font-size: 18px;">INFORME DE LA FACTURA</h1>
	                        </td>
                    	</tr>

                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Referencia:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Referencia'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['ValorFact'] . '</h1>
	                            <p></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: red;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">Fecha:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #000;font-family: Helvetica; font-size: 14px; line-height: 150%;
    									   font-weight: bold;">' . $lineaTemp['Fecha'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>










						
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Moneda:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Moneda'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Valor'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Gasto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['NombreGasto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Info:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $info . '</h1>
	                            <p></p>
	                        </td>

                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Impuesto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Impuesto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Tipo doc:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">'.$lineaTemp['TipoDoc'].'</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Documento:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Documento'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Nota:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Notas'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>

                </tbody></table>
					';
	            } else {
	                $cuerpo = $cuerpo . '
				<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">


                    <tbody>			
                    	<tr>
							<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:10px; padding-left:18px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;">
	                            <div style="border-top: 1px solid #EEEEEE;"></div>
	                        </td>
						</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Moneda:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Moneda'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Valor:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Valor'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Gasto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['NombreGasto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Info:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $info . '</h1>
	                            <p></p>
	                        </td>

                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Impuesto:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Impuesto'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Tipo doc:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">'.$lineaTemp['TipoDoc'].'</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Documento:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Documento'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>
                    	
                    	<tr>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:18px;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: bold;">Nota:</h1>
	                            <p></p>
	                        </td>
	                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:5px; padding-bottom:0px; padding-left:0px;float: right;">
	                            <h1 style="color: #656565;font-family: Helvetica; font-size: 12px; line-height: 150%;
    									   font-weight: initial;">' . $lineaTemp['Notas'] . '</h1>
	                            <p></p>
	                        </td>
                    	</tr>


                </tbody></table>';
            }
        }


        $cuerpo2 = $cuerpo;
        $cuerpo = $cuerpo . '
				

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>


<td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center" valign="top">
                                	<p style="color: #656565;
											    font-family: Helvetica;
											    font-size: 12px;
											    line-height: 150%;
											    text-align: center;font-weight: bold;">
                                		CODIGO DE VERIFICACION:
                                	</p>
                                	<p style="color: #202020;
											    font-family: Helvetica;
											    font-size: 18px"><strong>' . $lineaTemp['NoAprobacion'] . '</strong></p>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
';

        $cuerpo2 = $cuerpo2 . '

            </td>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 10px 18px 25px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #EEEEEE;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">          
						Crea y Autoriza Legalizaciones de manera Offline<br>
					    Mas informacion <a href="http://www.consensussa.com/">www.consensussa.com</a></a>
						<br><br>
						<em>Copyright  |  2016  |  Consensus s.a.s<br> Todos los derechos reservados.</em>
					                        </td>
					                    </tr>
					                    
					                </tbody></table>
					            </td>
					        </tr>
					    </tbody>
					    
					</table></td>

                            </tr>

                        </table>

                    </td>

                </tr>
                
            </table>

        </center>

    </body>
</html>

';



        $cabecera = "MIME-Version: 1.0\r\n";
        $cabecera .= "Content-type: text/html; charset=iso-8859-1\r\n";

        if ($lineaTemp['Dimension2'] === '1' || $lineaTemp['Dimension2'] === 1) {
            @mail($email_to, $email_subject, $cuerpo, $cabecera);
        }
        @mail($email_from, $email_subject, $cuerpo2, $cabecera);
    }*/





}