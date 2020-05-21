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
    'ProductType' => 'ONP',
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
        'AccountCountryCode' => 'AE',
        'AccountEntity' => 'DXB',
        'AccountNumber' => '45796',
        'AccountPin' => '116216',
        'UserName' => 'dxbit@aramex.com',
        'Password' => 'Ar@m3x$h1pp1ng',
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

