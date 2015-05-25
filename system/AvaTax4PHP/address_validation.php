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
		echo "<br>Address Validation Response: ";
		print_r($result);
		   
		//echo "\n".'Validate ResultCode is: '. $result->getResultCode()."\n";
		if($result->getResultCode() != SeverityLevel::$Success)
		{
			$return_message .= "<b>AvaTax - Address Validation - Error Mesasge</b><br/>";
			
			$cnt=0;
			foreach($result->getMessages() as $msg)
			{
				//$return_message .= $msg->getName().": ".$msg->getSummary()."<br/>";
				//$return_message .= $msg->getSummary()."<br/>";
				//$return_message .= $msg."<br/>";
				$cnt++;
				echo "<br>Cnt: ".$cnt;
				print_r($msg);
			}
		}
		else
		{
			$return_message .= "Success";
		}   
		return $return_message;
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
//}
?>