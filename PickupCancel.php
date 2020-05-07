<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');	
	$soapClient = new SoapClient('https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc?wsdl');
	echo '<pre>';
	print_r($soapClient->__getFunctions());
	$params = array(
				'ClientInfo' => array(
					'AccountCountryCode' => 'AE',
					'AccountEntity' => 'DXB',
					'AccountNumber' => '45796',
					'AccountPin' => '116216',
					'UserName' => 'dxbit@aramex.com',
					'Password' => 'Ar@m3x$h1pp1ng',
					'Version' => 'v1.0'
				) ,
				'Transaction' => array(
					'Reference1' => '001',
					'Reference2' => '',
					'Reference3' => '',
					'Reference4' => '',
					'Reference5' => '',
				) ,
				'Comments' => 'Shipments not ready for Pick up',
                'PickupGUID' => '11ECD593-F623-4151-A171-E9C68961CE8F',
            );

		print_r($params);
	
	try {
		$auth_call = $soapClient->CancelPickup($params);
		echo '<pre>';
		print_r($auth_call);
		die();
	} catch (SoapFault $fault) {
		die('Error : ' . $fault->faultstring);
	}
?>