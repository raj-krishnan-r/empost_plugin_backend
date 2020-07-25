<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
if($_GET['countryCode']=="AE")
{
getEmirates();
}
else
{
$country =getCountryId($_GET['countryCode']);
getCitiesById($country);
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
function getEmirates()
{
	class emirate{
}
$result=[];
    $myfile = fopen("emirates.xml","r") or die("Unable to open file");
    $emiratesData = fread($myfile,filesize("emirates.xml"));
    fclose($myfile);
    $emiratesData = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $emiratesData);
    $realEmiratesData = simplexml_load_string($emiratesData);
    $emirates_collection = json_encode($realEmiratesData->soapenvBody->ns2GetEmiratesDetailsResponse->ns2GetEmiratesDetailsResult);
    $js = json_decode($emirates_collection);
    
    foreach(($js->ns2EmirateBO) as $emirate)
    {

 	$em = new emirate();
	$em->Cityid=($emirate->ns2EmirateID);
	$em->CityName=($emirate->ns2EmirateName);    
	array_push($result,$em);
    }
echo json_encode($result);
}


function getCitiesById($countryId)
{
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

    $country = new Country($countryId);
    $client = new SoapClient($wsdlUrl, $soapClientOptions);

    $checkVatParameters = array('CitiesByCountryIdRequest'=>$country);

    $result = $client->GetCitiesByCountryId($checkVatParameters);
    echo json_encode($result->CitiesByCountryIdResponse);
}
catch(Exception $e) {
    echo $e->getMessage();
}
}
?>
