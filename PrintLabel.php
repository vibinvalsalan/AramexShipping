<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$soapClient = new SoapClient('https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc?wsdl');
echo '<pre>';
print_r($soapClient->__getFunctions());
$params = array(    
    'ClientInfo' => array(
        'AccountCountryCode' => '',	//Identification Code for the Account Country Code for the Aramex Business Account Number. Eg: AE,SA,BH,OM 
        'AccountEntity' => '',		//Identification Code for the Account Entity for the Aramex Business Account Number. Eg:DXB,AUH,RUH,MCT,BAH
        'AccountNumber' => '',	//Aramex Business Account Number provided when contract is signed.
        'AccountPin' => '',		//Account Pin associated with Aramex Business Account Number provided when contract is signed
        'UserName' => '',		//Registered Username on www.aramex.com
        'Password' => '',		//Registered Password on www.aramex.com
        'Version' => 'v1.0'
    ) ,
    'Transaction' => array(
        'Reference1' => '001',
        'Reference2' => '',
        'Reference3' => '',
        'Reference4' => '',
        'Reference5' => '',
    ) ,
    'LabelInfo' => array(
        'ReportID' => 9729,
        'ReportType' => 'URL',
    ) ,
	'OriginEntity' =>  'DXB',
    'ProductGroup' =>  'DOM',								//EXP for International Shipment
    'ShipmentNumber' =>  '46032800516'	,					//Pass Airwaybill Here
);
print_r($params);
try
{
    $auth_call = $soapClient->PrintLabel($params);
    echo '<pre>';
    print_r($auth_call);
    die();
}
catch(SoapFault $fault)
{
    die('Error : ' . $fault->faultstring);
}
?>
