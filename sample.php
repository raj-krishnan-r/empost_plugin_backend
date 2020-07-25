<?php
class Country {
    public function __construct($id) 
    {
        $this->CountryId = $id;
    }
}
try {
    $opts = array(
'http' => array(
'user_agent' => 'PHPSoapClient',
'Content-Type'=>'text/xml',
'Accept-Encoding'=> 'gzip,deflate',
'Content-Type'=>'text/xml;charset=UTF-8',
'Content-Length'=> '304',
'Host'=> 'osbtest.epg.gov.ae',
'Connection'=> 'Keep-Alive',
'User-Agent'=>'Apache-HttpClient/4.1.1 (java 1.5)'));
    $context = stream_context_create($opts);

    $wsdlUrl = 'https://osbtest.epg.gov.ae/ebs/genericapi/lookups?wsdl';
    $soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE
    );

    $country = new Country($_GET['countryID']);
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

    $checkVatParameters = array('CitiesByCountryIdRequest'=>$country);

    $result = $client->GetCitiesByCountryId($checkVatParameters);
    echo json_encode($result->CitiesByCountryIdResponse->Cities->City);
}
catch(Exception $e) {
    echo $e->getMessage();
}	
?>