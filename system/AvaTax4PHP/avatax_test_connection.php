<?php

	if(isset($_GET["from"]) && $_GET["from"]=="AvaTaxConnectionTest")
	{		
		require_once('AvaTax.php');
		
		$successMsg = "";
		
		$development_url = $_GET["serviceurl"];
		$account = $_GET["acc"];
		$license = $_GET["license"];
		$environment = $_GET["environment"];
		$client = $_GET["client"];

		//new ATConfig($environment, array('url'=>$development_url, 'account'=>$account,'license'=>$license, 'trace'=> TRUE));
		new ATConfig($environment, array('url'=>$development_url, 'account'=>$account,'license'=>$license,'client'=>$client, 'trace'=> TRUE));

		$client = new TaxServiceSoap($environment);

		try
		{
			$result = $client->isAuthorized("");
			
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
			echo "<div style='text-align:center;padding-top:10px;'>".$successMsg."</div>"; 
			//$successMsg .= $client->__getLastRequest()."<br/>";
			//$successMsg .= $client->__getLastResponse()."<br/>"; 
		}		
	}
?>