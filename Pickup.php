
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
                'Pickup' => array(
                    'PickupContact' => array(
                        'PersonName' => 'Vibin',
                        'CompanyName' => 'Aramex Emirates LLC',
                        'PhoneNumber1' => '971556800000',
                        'PhoneNumber1Ext' => '',
                        'CellPhone' => '971556800000',
                        'EmailAddress' => 'test@aramex.com'
                    ),
                    'PickupAddress' => array(
						'Line1' => 'Aramex Umm Ramool Air Port Road',//Mandatory
						'Line2' => '',
						'Line3' => '',
						'City' => 'Dubai',//Mandatory
						'StateOrProvinceCode' => '',
						'PostCode' => '',
						'CountryCode' => 'AE'//Mandatory
                    ),
                    'PickupLocation' => 'Reception',
                    'PickupDate' => mktime(0,0,0,05,10,2020)-7200,
                    'ReadyTime' => mktime(9,0,0,05,10,2020)-7200,
                    'LastPickupTime' => mktime(13,0,0,05,10,2020)-7200,
                    'ClosingTime' => mktime(13,0,0,05,10,2020)-7200,
                    'Comments' => 'Heavy Items',
                    'Reference1' => 'Ref1',
                    'Reference2' => '',
                    'Vehicle' => 'Car',
                    'Shipments' => array(
                        'Shipment' => array()
                    ),
                    'PickupItems' => array(
                        'PickupItemDetail' => array(
                            'ProductGroup' => 'DOM',
							'ProductType' => 'CDS',
							'Payment' => 'P',
                            'NumberOfShipments' => '1',//Fill Number of Shipment
                            'NumberOfPieces' => '2',//Fill Total Number of Pieces
                            'ShipmentWeight' => array(
                                'Value' => '1',
                                'Unit' => 'KG'
                            ),
							'ShipmentDimensions' => array(
								'Length'=> 10.0,
								'Width'=> 10.0,
								'Height'=> 10.0,
								'Unit' => 'CM'
							),
                        ),
                    ),
                    'Status' => 'Ready',
					'ExistingShipments' => array(
						'ExistingShipment' => array()
					),
                )
            );

		print_r($params);
	
	try {
		$auth_call = $soapClient->CreatePickup($params);
		echo '<pre>';
		print_r($auth_call);
		die();
	} catch (SoapFault $fault) {
		die('Error : ' . $fault->faultstring);
	}
?>
