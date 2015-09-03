<?php
if(isset($_GET["from"]) && $_GET["from"]=="AvaTaxConnectionTest")
{		
	require_once('AvaTax.php');
	
	$successMsg = "";
	
	$account = $_GET["acc"];
	$license = $_GET["license"];
	$environment = $_GET["environment"];
	$client = $_GET["client"];

	if($environment == "Development")
		$serviceURL = "https://development.avalara.net";
	else
		$serviceURL = "https://avatax.avalara.net";


	/****************************************************************************************************
	*   Last Updated On	:	07/28/2015			                            							*
	*   Description     :   Enter AvaTax admin console company code here.
	* 	Removed URL from query string. Now defining URL in testC_onnection.php page as per environment  	*
	******************************************************************************************************/

	new ATConfig($environment, array('url'=>$serviceURL, 'account'=>$account,'license'=>$license,'client'=>$client, 'trace'=> TRUE));

	$client = new TaxServiceSoap($environment);

	try
	{
		$result = $client->isAuthorized("");
		
		/*************************************************************************************************
		*   Last Updated On	:	07/07/2015			                            							*
		*   Description        :   Added Ok button to test connection window	  	*
		**************************************************************************************************/

		 if($result->getResultCode() != SeverityLevel::$Success)	// call failed
		{
			foreach($result->Messages() as $msg)
			{					
				$successMsg .= $msg->Name().": ".$msg->Summary()."<br/>\n";
			}

		} 
		else // successful calll
		{
			$dateTime = new DateTime();
			$dateTime = strtotime($result->getExpires());
			$dateTime = date ("Y-m-d", $dateTime);
			$type = gettype ($dateTime);
			$successMsg .= "Welcome to the Ava Tax Service.<br/>";
			$successMsg .= "Connection Test Status: <span style='color:green;'>".$result->getResultCode()."</span><br/>";
			$successMsg .= "Expiry Date : <span style='color:green;'>".$dateTime."</span><br/>";
			$successMsg .= "<p style='text-align:center;padding-top:10px;'><input type='button'  onClick='closeTestConnection()' value='OK' ></p>";
		}
		echo "<div style='text-align:center;padding-top:10px;'>".$successMsg."</div>"; 
		//echo $successMsg; 
	}
	catch(SoapFault $exception)
	{
		$msg = "Reason: ";
		if($exception)
			$msg .= $exception->faultstring;

		$successMsg .= "Welcome to the Ava Tax Service.<br/>";
		$successMsg .= "Connection Test Status: <span style='color:red;'>Failed</span><br/>";
		$successMsg .= $msg."<br/>";
		$successMsg .= "<p style='text-align:center;padding-top:20px;'><input type='button'  onClick='closeTestConnection()' value='OK' ></p>";
		echo "<div style='text-align:center;padding-top:10px;'>".$successMsg."</div>"; 
	}		
}
?>