<?php

function AddressValidation($address_data)
{
	require_once('AvaTax.php');
	
	//new ATConfig($address_data["environment"], array('url'=>$address_data["service_url"], 'account'=>$address_data["account"],'license'=>$address_data["license"], 'trace'=> TRUE));
	new ATConfig($address_data["environment"], array('url'=>$address_data["service_url"], 'account'=>$address_data["account"],'license'=>$address_data["license"],'client'=>$address_data["client"], 'trace'=> TRUE));

	$client = new AddressServiceSoap($address_data["environment"]);
	
	$return_message = "";
	
	try
	{
		$address = new Address();
		$address->setLine1($address_data["line1"]);
		$address->setLine2($address_data["line2"]);
		$address->setLine3($address_data["line3"]);
		$address->setCity($address_data["city"]);
		$address->setRegion($address_data["region"]);
		$address->setPostalCode($address_data["postalcode"]);


		$textCase = TextCase::$Mixed;
		$coordinates = 1;

		$request = new ValidateRequest($address, ($textCase ? $textCase : TextCase::$Default), $coordinates);
		//echo "<br/>";
		$result = $client->Validate($request);
                $response= array();
		//echo "\n".'Validate ResultCode is: '. $result->getResultCode()."\n";
		if($result->getResultCode() != SeverityLevel::$Success)
		{
			$return_message .= "Error - AvaTax Address Validation Mesasge\n";
			
			foreach($result->getMessages() as $msg)
			{
				//$return_message .= $msg->getName().": ".$msg->getSummary()."<br/>";
				$return_message .= $msg->getSummary();
			}	
                        $response["msg"]=$return_message;
                        $response["address"]="";
		}
		else if($result->getResultCode() == SeverityLevel::$Success && $result->getValidAddresses() != "")
		{
                       $arr=array();
                       $validatedAddresses=array();
                       $validatedAddresses=$result->getValidAddresses();
                       foreach ($validatedAddresses as $obj) {
                        $arr["Line1"]=$obj->getLine1();
                        $arr["Line2"]=$obj->getLine2();
                        $arr["Line3"]=$obj->getLine3();
                        $arr["AddressCode"]=$obj->getAddressCode();
                        $arr["City"]=$obj->getCity();
                        $arrCountryCode=getFieldValue('country','country_id','iso_code_2',$obj->getCountry());
                        $arr["Country"]=$arrCountryCode[0];
                        $arr["Country_txt"]=$obj->getCountry();

                        $arrRegion=getFieldValue('zone','zone_id','code',$obj->getRegion(),"and country_id=" .$arrCountryCode[0]);
                        $arr["Region"]=$arrRegion[0];
                        $arr["Region_txt"]=$obj->getRegion();
                        $arr["PostalCode"]=$obj->getPostalCode();
}
			$return_message .= "Success";
			$return_message .= json_encode($arr);
                        $response["msg"]="Success";
                        $response["address"]=json_encode($arr);

                        
		}   
               else {
                        $return_message .= "Success";
                        $response["msg"]="Success";
                        $response["address"]="";
                    }
		//return $return_message;
		return json_encode($response);
	}
	catch(SoapFault $exception)
	{
		$return_message .= "Exception: ";
		if($exception)
			$return_message .= $exception->faultstring;

			$return_message .= $msg . "<br/>";
			$return_message .= $client->__getLastRequest() . "<br/>";
			$return_message .= $client->__getLastResponse() . "<br/>";
			
		return $return_message;
	} 
}  

/*Function to fetch  in numeric format*/
function getFieldValue($table,$fieldName,$conditionField,$conditionValue,$condition=NULL){
if (file_exists('../../config.php')) {
	require_once('../../config.php');
}
    $resArr=array();
    $dbpreFix=DB_PREFIX;
    
     $qry="select $fieldName from $dbpreFix$table where $conditionField='$conditionValue' $condition";
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if(!$con) echo "Failed to connect : " . mysqli_connect_error();
    
   $result=mysqli_query($con,$qry);
    return $resArr=getSimpleArray($result,$fieldName);
    
    
}
 function getSimpleArray($result,$field){
                $arr=array();
		while($row=mysqli_fetch_array($result))
		{
			$arr[]=$row["$field"];
			
		}
		return $arr; 
	}
//}
?>