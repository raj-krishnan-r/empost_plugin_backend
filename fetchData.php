<?php
$url = "https://osbtest.epg.gov.ae/ebs/genericapi/lookups";
$headers = array('Content-Type: text/xml',
'Accept-Encoding: gzip,deflate',
'Content-Type: text/xml;charset=UTF-8',
'SOAPAction: "http://epg.generic.masterdata/GetEmiratesDetails"',
'Content-Length: 304',
'Host: osbtest.epg.gov.ae',
'Connection: Keep-Alive',
'User-Agent: Apache-HttpClient/4.1.1 (java 1.5)');

$datum = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:epg="http://epg.generic.masterdata/"><soapenv:Header/><soapenv:Body><epg:GetEmiratesDetailsRequest><!--Optional:--><epg:EmiratesDetailsRequest/></epg:GetEmiratesDetailsRequest></soapenv:Body></soapenv:Envelope>';

$response = soapBox($url,$datum,$headers);
echo $response;

function soapBox($url,$data,$headers)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,            $url );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST,           1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,     $data ); 
//curl_setopt($ch, CURLOPT_HTTPHEADER,     $headers); 

$result=curl_exec ($ch);
return $result;
}
?>