<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*mysql*/

$servername = "localhost";
$username = "id14351568_raj";
$password = "8Countries@world";
$dbname = "id14351568_essentials";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

/**/

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

$responses=array();

$income = json_decode($_POST['datum']);
foreach($income->items as $item)
{
   //special routine
   $currency = $item->totalPriceSet->shopMoney->currencyCode;
   if($currency=='')
   {
      $currency="AED";
   }

    $booking = new BookRequest();
    $message = new Message();
    $customs = new CustomDeclaration();
    $customRequest = new CustomRequest();
    $message->SenderContactName=$income->sContactName;
    $message->SenderCompanyName=$income->sCompanyName;
    $message->SenderAddress=str_replace(array("\r", "\n"), '', $income->sAddress);
    $message->SenderCity=$income->sCity;
    $message->SenderContactMobile=$income->sContactMobile;
    $message->SenderContactPhone=$income->sContactMobile;
    $message->SenderEmail=$income->sEmail;
    $message->SenderZipCode=$income->sZip;
    $message->SenderState=$income->sState;
    $message->SenderCountry=$income->sCountry;
    $message->ReceiverContactName=$item->shippingAddress->firstName.' '.$item->shippingAddress->lastName;
    $message->ReceiverCompanyName=$item->shippingAddress->firstName;
    $message->ReceiverAddress=$item->receiverAddress;
    $message->ReceiverCity=$item->rCity;
    //$message->ReceiverCityName=$item->customer->addresses[0]->city;
    $message->ReceiverContactMobile=$item->shippingAddress->phone;
    $message->ReceiverContactPhone=$item->shippingAddress->phone;
    $message->ReceiverEmail=$item->customer->email;
    $message->ReceiverZipCode=$item->globalPIN;
    $message->ReceiverState=$item->shippingAddress->province;
    $message->ReceiverCountry=getCountryId($item->shippingAddress->countryCodeV2);
    //$message->ReceiverCountry='971';
    $message->ReferenceNo=$item->name;
    $message->ReferenceNo1=$item->invoice;
    $message->ReferenceNo2=NULL;
    $message->ReferenceNo3=NULL;
    $message->ContentTypeCode=$income->contentType;
    $message->NatureType=$income->natureType;
    $message->Service=$income->serviceType;
    $message->ShipmentType=$income->shipmentType;
    $message->DeleiveryType=$income->deliveryType;
    $message->Registered=$income->registered;
    $message->PaymentType=$item->PaymentType;
    $message->CODAmount=$item->totalPriceSet->shopMoney->amount;
    $message->CODCurrency=$currency;
    $message->CommodityDescription='Packagings';
    $message->Pieces=$item->pieces;
    $message->Weight = $item->totalWeight;
    $message->WeightUnit='Grams';
    $message->Length='1';
    $message->Width='1';
    $message->Height='1';
    $message->DimensionUnit='Meter';
    $message->ItemValue=$item->totalPriceSet->shopMoney->amount;
    $message->ValueCurrency=$currency;
    $message->ProductCode=NULL;
    $message->SpecialInstructionsID=NULL;
    $message->DeliveryInstructionsID=NULL;
    $message->LabelType='RPT';
    $message->RequestSource='api';
    $message->isReturnItem='No';
    $message->SendMailToSender='No';
    $message->SendMailToReceiver='No';

     //Customs object
     $customs->HSCode=NULL;
     $customs->TotalUnits=$item->pieces;
     $customs->Weight=$item->totalWeight;
     $customs->Value=$item->totalPriceSet->shopMoney->amount;
     $customs->DeclaredCurrency=$currency;
     $customs->FileName=NULL;
     $customs->FileType=NULL;
     $customs->FileContent=NULL;
     $customs->CreatedBy=NULL;
    
     //array_push($message->CustomDeclarations,$customRequest);

    $message->PreferredPickupDate=$income->formattedPickupDate;
    $message->PreferredPickupTimeFrom='12:00';
    $message->PreferredPickupTimeTo='17:00';

    $fixedTime = timeFixer($message->PreferredPickupDate);

   
   // echo json_encode($message);
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:epg=\"http://epg.generic.booking/\">
   <soapenv:Header>
      <epg:AuthHeader>
         <!--Optional:-->
         <epg:AccountNo>C372126</epg:AccountNo>
         <!--Optional:-->
         <epg:Password>C372126</epg:Password>
      </epg:AuthHeader>
   </soapenv:Header>
   <soapenv:Body>
      <epg:CreateBookingRequest>
         <epg:BookingRequest>
            <epg:SenderContactName>$message->SenderContactName</epg:SenderContactName>
            <epg:SenderCompanyName>$message->SenderCompanyName</epg:SenderCompanyName>
            <epg:SenderAddress>25/$message->SenderAddress</epg:SenderAddress>
            <epg:SenderCity>$message->SenderCity</epg:SenderCity>
            <epg:SenderContactMobile>$message->SenderContactMobile</epg:SenderContactMobile>
            <epg:SenderContactPhone>$message->SenderContactPhone</epg:SenderContactPhone>
            <epg:SenderEmail>$message->SenderEmail</epg:SenderEmail>
            <epg:SenderZipCode>$message->SenderZipCode</epg:SenderZipCode>
            <epg:SenderState>$message->SenderState</epg:SenderState>
            <epg:SenderCountry>$message->SenderCountry</epg:SenderCountry>
            <epg:ReceiverContactName>$message->ReceiverContactName</epg:ReceiverContactName>
            <epg:ReceiverCompanyName>$message->ReceiverCompanyName</epg:ReceiverCompanyName>
            <epg:ReceiverAddress>$message->ReceiverAddress</epg:ReceiverAddress>
            <epg:ReceiverCity>$message->ReceiverCity</epg:ReceiverCity>
            <epg:ReceiverContactMobile>$message->ReceiverContactMobile</epg:ReceiverContactMobile>
            <epg:ReceiverContactPhone>$message->ReceiverContactPhone</epg:ReceiverContactPhone>
            <epg:ReceiverEmail>$message->ReceiverEmail</epg:ReceiverEmail>
            <epg:ReceiverZipCode>$message->ReceiverZipCode</epg:ReceiverZipCode>
            <epg:ReceiverState>$message->ReceiverState</epg:ReceiverState>
            <epg:ReceiverCountry>$message->ReceiverCountry</epg:ReceiverCountry>
            <epg:ReferenceNo>$message->ReferenceNo</epg:ReferenceNo>
            <epg:ReferenceNo1>$message->ReferenceNo1</epg:ReferenceNo1>
            <epg:ReferenceNo2/>
            <epg:ReferenceNo3/>
            <epg:ContentTypeCode>$message->ContentTypeCode</epg:ContentTypeCode>
            <epg:NatureType>$message->NatureType</epg:NatureType>
            <epg:Service>$message->Service</epg:Service>
            <epg:ShipmentType>$message->ShipmentType</epg:ShipmentType>
            <epg:DeleiveryType>$message->DeleiveryType</epg:DeleiveryType>
            <epg:Registered>$message->Registered</epg:Registered>
            <epg:PaymentType>$message->PaymentType</epg:PaymentType>
            <epg:CODAmount>$message->CODAmount</epg:CODAmount>
            <epg:CODCurrency>$message->CODCurrency</epg:CODCurrency>
            <epg:CommodityDescription>Packagings</epg:CommodityDescription>
            <epg:Pieces>$message->Pieces</epg:Pieces>
            <epg:Weight>$message->Weight</epg:Weight>
            <epg:WeightUnit>Grams</epg:WeightUnit>
            <epg:Length>20</epg:Length>
            <epg:Width>5</epg:Width>
            <epg:Height>20</epg:Height>
            <epg:DimensionUnit>Centimetre</epg:DimensionUnit>
            <epg:ItemValue>$message->ItemValue</epg:ItemValue>
            <epg:ValueCurrency>$message->ValueCurrency</epg:ValueCurrency>
            <epg:ProductCode/>
            <epg:SpecialInstructionsID/>
            <epg:DeliveryInstructionsID/>
            <epg:LabelType>RPT</epg:LabelType>
            <epg:RequestSource>api</epg:RequestSource>
            <epg:isReturnItem>No</epg:isReturnItem>
            <epg:SendMailToSender>No</epg:SendMailToSender>
            <epg:SendMailToReceiver>No</epg:SendMailToReceiver>
            <epg:CustomDeclarations>
               <!--1 or more repetitions:-->
               <epg:CustomDeclarationRequest>
                  <epg:HSCode/>
                  <epg:TotalUnits>$customs->TotalUnits</epg:TotalUnits>
                  <epg:Weight>$customs->Weight</epg:Weight>
                  <epg:Value>$customs->Value</epg:Value>
                  <epg:DeclaredCurrency>$customs->DeclaredCurrency</epg:DeclaredCurrency>
                  <epg:FileName/>
                  <epg:FileType/>
                  <epg:FileContent/>
                  <!--Optional:-->
                  <epg:CreatedBy/>
               </epg:CustomDeclarationRequest>
            </epg:CustomDeclarations>
            <epg:PreferredPickupDate>$message->PreferredPickupDate</epg:PreferredPickupDate>
            <epg:PreferredPickupTimeFrom>$fixedTime</epg:PreferredPickupTimeFrom>
            <epg:PreferredPickupTimeTo>17:00</epg:PreferredPickupTimeTo>
            <epg:PrintType>LabelOnly</epg:PrintType>
            <epg:RequestType>Shipment</epg:RequestType>
         </epg:BookingRequest>
         
      </epg:CreateBookingRequest>
   </soapenv:Body>
</soapenv:Envelope>";
sendSOAP($xml,$item->name,$item->fulfillmentOrders->edges[0]->node->id,$conn);
//usleep(250000);
   
}
function getCountryId($countryCode)
{
$myfile = fopen("countries.xml","r") or die("Unable to open file");
$countriesData = fread($myfile,filesize("countries.xml"));
fclose($myfile);
$countriesData = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $countriesData);
$realCountriesData = simplexml_load_string($countriesData);


$country_collection = json_encode($realCountriesData->soapenvBody->ns2GetCountriesResponse->ns2CountriesResponse->ns2Countries);
$js = json_decode($country_collection);
foreach(($js->ns2Country) as $country)
{
    if($country->ns2CountryCode==$countryCode)
    {
    return $country->ns2CountryId;
    break;
    }
}
}
function sendSOAP($xml,$orderID,$fulfillmentOrderID,$conn)
{
   try{
      $dc=null;
    $soapUrl = "https://osb.epg.gov.ae/ebs/genericapi/booking"; // asmx URL of WSDL

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Accept-Encoding: gzip,deflate",
                        "Cache-Control: no-cache",
                        "Connection: Keep-Alive",
                        "Host: osb.epg.gov.ae",
                        "User-Agent: Apache-HttpClient/4.1.1 (java 1.5)",
                        "SOAPAction: http://epg.generic.booking/CreateBooking", 
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
       // echo json_encode($parser);
		if($parser==false||isset($parser->soapenvBody->soapFault))
		{
		$dc = '';
		$cd='';
		}
		else
		{
		$dc=strval($parser->soapenvBody->ns2CreateBookingResponse->ns2BookingResponse->ns2AWBNumber['0']);
		$cd=strval($parser->soapenvBody->ns2CreateBookingResponse->ns2BookingResponse->ns2AWBLabel);
		}

            $res = new Result();
            $res->orderID=$orderID;
            $res->awbNumber=$dc;
	         $res->fulfillmentOrderID=$fulfillmentOrderID;
/*insert into DB
*/
if($dc!=='')
{
$sql = "INSERT INTO awb (id, userid, billString,ordername)
VALUES (0, 1, '$cd','$orderID') ON DUPLICATE KEY UPDATE billString = '$cd'";

if ($conn->query($sql) === TRUE) {
$res->labelStored = true;
} else {
$res->labelStored=false;
}
}

array_push($GLOBALS['responses'],$res);

   }
   Catch(Exception $e)
   {
            $res = new Result();
            $res->orderID=$orderID;
            $res->awbNumber=$dc;
            $res->fulfillmentOrderID=$fulfillmentOrderID;
            $res->exception=$e->getMessage();
            array_push($GLOBALS['responses'],$res);

   }
}
function timeFixer($reference)
{
$d = date('H');
$tz = 'Asia/Dubai'; // your required location time zone.
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
//echo $dt->format('Y/m/d H:i:s');

$d1 = date_create($reference);
$d2 = date_create($dt->format('d-F-Y'));

$diff = date_diff($d1,$d2);

if(($diff->d)>0)
{
return "12:00";
}
else
{
$hour = $dt->format('H');
if(($hour+1)>18)
{
return "18:00";
}
else
{
return strval($hour+1).":00";
}
}
}           
echo json_encode($responses);
$conn->close();
?>
