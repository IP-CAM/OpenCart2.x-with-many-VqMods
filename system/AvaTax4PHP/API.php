<?php
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

/**********************************************************************************************************************
*   Last Updated On		:	08/05/2015			                            									*
*   Description        	:   Created CallRESTAPI function to call REST services. It will accept parameters as environment value(production 
							or development), Method Name(PUT/POST etc) , Service parameters & data to be passed	*
****************************************************************************************************************/

function CallRESTAPI($environment, $method, $data = false)
{
	if($environment == "Development")
		$serviceURL = "https://sandbox.onboarding.api.avalara.com";
	else
		$serviceURL = "https://production.onboarding.api.avalara.com";

    switch ($method)
    {
        case "POST":
			$curl = curl_init($serviceURL);
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;

		case "PUT":
			$curl = curl_init($serviceURL);
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;

		default:
			$url = $serviceURL.$data;
			//echo "<br>URL: ".$url;
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, 0);
    }

    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	//CURLOPT_SSL_VERIFYPEER - verify the peer's SSL certificate. This option determines whether curl verifies the authenticity of the peer's certificate. A value of 1 means curl verifies; 0 (zero) means it doesn't. 
	if($environment == "Development")
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	else
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);

	//If you enable CURLOPT_RETURNTRANSFER to true/1 then your return value from curl_exec will be the actual result from your successful operation
	//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
	//echo "<br>Result: ";
	//print_r($result);
	return $result;

    curl_close($curl);
}

//CallRESTAPI("Development","GET","/v1/help");
?>