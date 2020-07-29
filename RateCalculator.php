<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$soapClient = new SoapClient('https://ws.aramex.net/ShippingAPI.V2/RateCalculator/Service_1_0.svc?wsdl');
echo '<pre>';
print_r($soapClient->__getFunctions());
$OriginAddress      = array(
    'City' => 'Dubai', //Mandatory
    'StateOrProvinceCode' => '',
    'PostCode' => '',
    'CountryCode' => 'AE' //Mandatory
);
$DestinationAddress = array(
    'City' => 'Dubai', //Mandatory
    'StateOrProvinceCode' => '',
    'PostCode' => '',
    'CountryCode' => 'AE' //Mandatory
);
$ShipmentDetails    = array(
    'ProductGroup' => 'DOM',
    'ProductType' => 'ONP', //Use ONP or CDS , based on your requirement
    'PaymentType' => 'P', //Dont Change
    'Dimensions' => array(
        'Length' => 0,
        'Width' => 0,
        'Height' => 0,
        'Unit' => 'cm'
    ),
    'ActualWeight' => array(
        'Value' => 0.5, //Mandatory
        'Unit' => 'Kg'
    ),
    'ChargeableWeight' => array(
        'Value' => 0.5,
        'Unit' => 'Kg'
    ),
    'NumberOfPieces' => 1
);

$params = array(
    'ClientInfo' => array(
        'AccountCountryCode' => '',	//Identification Code for the Account Country Code for the Aramex Business Account Number. Eg: AE,SA,BH,OM 
        'AccountEntity' => '',		//Identification Code for the Account Entity for the Aramex Business Account Number. Eg:DXB,AUH,RUH,MCT,BAH
        'AccountNumber' => '',	//Aramex Business Account Number provided when contract is signed.
        'AccountPin' => '',		//Account Pin associated with Aramex Business Account Number provided when contract is signed
        'UserName' => '',		//Registered Username on www.aramex.com
        'Password' => '',		//Registered Password on www.aramex.com
        'Version' => 'v1.0'
    ),
    'OriginAddress' => $OriginAddress,
    'DestinationAddress' => $DestinationAddress,
    'ShipmentDetails' => $ShipmentDetails,
    'PreferredCurrencyCode' => 'AED'
);

print_r($params);
try {
    $auth_call = $soapClient->CalculateRate($params);
    echo '<pre>';
    print_r($auth_call);
    die();
}
catch (SoapFault $fault) {
    die('Error : ' . $fault->faultstring);
}
?>

