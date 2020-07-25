<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Recieves and creates SOAP request

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
class Message{

}
class CustomDeclaration{

}
class BookRequest{

}
class CustomRequest
{
    
}
class Result{
    
}



//$income = json_decode($_POST['datum']);

   // echo json_encode($message);
$xml = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:epg=\"http://epg.generic.booking/\">
   <soapenv:Header>
      <epg:AuthHeader>
         <epg:AccountNo>C175120</epg:AccountNo>
         <epg:Password>C175120</epg:Password>
      </epg:AuthHeader>
   </soapenv:Header>
   <soapenv:Body>
      <epg:PrintLabelRequest>
         <epg:LabelRequest>
            <epg:AWBNo>1000003700678</epg:AWBNo>
            <!--Optional:-->
            <epg:ShipmentType>Standard</epg:ShipmentType>
         </epg:LabelRequest>
      </epg:PrintLabelRequest>
   </soapenv:Body>
</soapenv:Envelope>";
//echo $xml;
sendSOAP($xml);
   


function sendSOAP($xml)
{
    $soapUrl = "https://osbtest.epg.gov.ae/ebs/genericapi/booking"; // asmx URL of WSDL

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Accept-Encoding: gzip,deflate",
                        "Cache-Control: no-cache",
                        "Connection: Keep-Alive",
                        "Host: osbtest.epg.gov.ae",
                        "User-Agent: Apache-HttpClient/4.1.1 (java 1.5)",
                        "SOAPAction: http://epg.generic.booking/PrintLabel", 
                        "Content-length: ".strlen($xml),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 
            $status = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $response);

            //echo $response;
            curl_close($ch);
                    //echo $response;
            // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);
            // convertingc to XML
            $parser = simplexml_load_string($status);
		//var_dump($parser);
var_dump($parser);
		if($parser!=false)
		{
$bin=($parser->soapenvBody->ns2PrintLabelResponse->ns2LabelResponse->ns2AWBLabel);
echo $bin;
//$binConvertion = base64_decode($bin);
//base64_decode(strval($parser->soapenvBody->ns2CreateBookingResponse->ns2BookingResponse->ns2AWBLabel['0']));
//var_dump($parser);
//header('Content-Type:application/pdf');
//echo base64_decode($bin);
}
}
		




?>
