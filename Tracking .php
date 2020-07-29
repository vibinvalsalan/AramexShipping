<?php
$soapClient = new SoapClient('https://ws.aramex.net/ShippingAPI.V2/Tracking/Service_1_0.svc?wsdl');
echo '<pre>';
// shows the methods coming from the service 
echo 'Available Methods';
echo "<br>";
print_r($soapClient->__getFunctions());
/*
parameters needed for the trackShipments method , client info, Transaction, and Shipments' Numbers.
Note: Shipments array can be more than one shipment.
*/
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
    'Transaction' => array(
        'Reference1' => '001'
    ),
    'GetLastTrackingUpdateOnly' => false,
    'Shipments' => array(
        '45496732256'
    )
);
// calling the method and printing results
try {
    $resAramex = $soapClient->TrackShipments($params);
    if (is_object($resAramex) && !$resAramex->HasErrors) {
        $response['type'] = 'success';
        if (!empty($resAramex->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult)) {
            $HAWBHistory = $resAramex->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult;
            $checkArray  = is_array($HAWBHistory);
            $resultTable = '<table summary="Item Tracking"  class="data-table">';
            $resultTable .= "<col width='1'>
                            <col width='1'>
                            <col width='1'>
                            <col width='1'>
                            <thead>
                            <tr class='first last'>
                            <th>Location</th>
                            <th>Action Date/Time</th>
                            <th class='a-right'>Tracking Description</th>
                            <th class='a-center'>Comments</th>
                            </tr>
                            </thead><tbody>";
            if ($checkArray) {
                foreach ($HAWBHistory as $HAWBUpdate) {
                    $resultTable .= '<tr>
                      <td>' . $HAWBUpdate->UpdateLocation . '</td>
                      <td>' . $HAWBUpdate->UpdateDateTime . '</td>
                      <td>' . $HAWBUpdate->UpdateDescription . '</td>
                      <td>' . $HAWBUpdate->Comments . '</td>
                      </tr>';
                }
            } else {
                $resultTable .= '<tr>
                      <td>' . $HAWBHistory->UpdateLocation . '</td>
                      <td>' . $HAWBHistory->UpdateDateTime . '</td>
                      <td>' . $HAWBHistory->UpdateDescription . '</td>
                      <td>' . $HAWBHistory->Comments . '</td>
                      </tr>';
            }
            $resultTable .= '</tbody></table>';
            echo $resultTable;
        } else {
            $NONExistingAWBS = $resAramex->NonExistingWaybills;
            $result          = 'Please check if the Tracking Number is valid or contact your administrator.';
            foreach ($NONExistingAWBS as $AWBS) {
                $checkArray = is_array($AWBS);
                if ($checkArray) {
                    foreach ($AWBS as $AWB => $value) {
                        $result .= 'AWB : ' . $value . '        ';
                    }
                } else {
                    $result .= 'AWB : ' . $AWBS . '        ';
                }
            }
            echo $result;
        }
    } else {
        $response['type'] = 'error';
        foreach ($resAramex->Notifications as $notification) {
            $response['html'] .= '<b>' . $notification->Code . '</b>' . $notification->Message;
        }
    }
    print json_encode($response);
    die();
}
catch (SoapFault $fault) {
    die('Error : ' . $fault->faultstring);
}
?>