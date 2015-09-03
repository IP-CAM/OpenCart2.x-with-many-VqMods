<?php
require_once("avatax_config.php");

//print_r($_REQUEST);
$effective_date = date("Y-m-d");
$end_date = date('Y-m-d', strtotime("+30 days"));
$countryCode = $countryArray[$_REQUEST['country']];
$stateCode = $stateArray[$_REQUEST['state']];

$json='{
	"ProductRatePlan":'.FREE_PLANS_JSON.',
	"ConnectorName":"QuickBooks Online",
	"CampaignId":"'.CAMPAIGNID.'",
	"LeadSourceMostRecent":"'.LEADSOURCEMOSTRECENT.'",
	"PaymentMethodId":"",
	"EffDate":"'.$effective_date.'",
	"EndDate":"'.$end_date.'",
	"Company":{
		"BIN":"'.$_REQUEST['bin'].'",
		"CompanyAddr":{
			"City":"'.$_REQUEST['city'].'",
			"Country":"'.$countryCode.'",
			"Line1":"'.$_REQUEST['line1'].'",
			"Line2":"'.$_REQUEST['line2'].'",
			"Line3":"'.$_REQUEST['line3'].'",
			"State":"'.$stateCode.'",
			"Zip":"'.$_REQUEST['zip'].'"
		},
		"CompanyCode":"'.COMPANY_CODE.'",
		"CompanyContact":{
			"Email":"'.$_REQUEST['email'].'",
			"Fax":"'.$_REQUEST['fax'].'",
			"FirstName":"'.$_REQUEST['firstname'].'",
			"LastName":"'.$_REQUEST['lastname'].'",
			"MobileNumber":"'.$_REQUEST['mobile'].'",
			"PhoneNumber":"'.$_REQUEST['phone'].'",
			"Title":"'.$_REQUEST['contact_title'].'"
		},
		"CompanyName":"'.$_REQUEST['company'].'",
		"TIN":"'.$_REQUEST['tin'].'"
	}
}';

//print_r($json);
//exit;
$url = 'https://sandbox.onboarding.api.avalara.com/v1/Accounts';

$authentication = base64_encode("TEST/vijay.nalawade@avalara.com:Vijay@123");

$ch = curl_init($url);
$options = array(
		CURLOPT_RETURNTRANSFER => true,         // return web page
		CURLOPT_HEADER         => false,        // don't return headers
		CURLOPT_FOLLOWLOCATION => false,         // follow redirects
	   // CURLOPT_ENCODING       => "utf-8",           // handle all encodings
		CURLOPT_AUTOREFERER    => true,         // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 20,          // timeout on connect
		CURLOPT_TIMEOUT        => 20,          // timeout on response
		CURLOPT_POST            => 1,            // i am sending post data
		CURLOPT_POSTFIELDS     => $json,    // this are my post vars
		CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
		CURLOPT_SSL_VERIFYPEER => false,        //
		CURLOPT_VERBOSE        => 1,
		CURLOPT_HTTPHEADER     => array(
			"Authorization: Basic $authentication",
			"Content-Type: application/json"
		)
);

curl_setopt_array($ch,$options);
$data = curl_exec($ch);
$curl_errno = curl_errno($ch);
$curl_error = curl_error($ch);
//echo $curl_errno;
//echo $curl_error;
curl_close($ch);
//echo "<p>CURL Response</p>";
print_r($data);


/*$data = '{"Message":"Account created successfully!\u000a\u000dUser created successfully!\u000a\u000dCompany created successfully!\u000a\u000dLocation created successfully!\u000a\u000dNexus created successfully!\u000a\u000d","Result":{"__type":"AccountSubscription:#AvaTaxSelfProcLib.Models","AccountId":"2000000334","CampaignId":"Test","Company":{"BIN":"","CompanyAddr":{"City":"Seattle","Country":"US","Line1":"ADDRESS LINE 2","Line2":"1000 2nd Ave","Line3":"","State":"WA","Zip":"98104-1094"},"CompanyCode":"default","CompanyContact":{"Email":"vijay@vijay1.com","Fax":"","FirstName":"My Name","LastName":"N","MobileNumber":"","PhoneNumber":"123","Title":""},"CompanyName":"My Store","TIN":"123456789"},"ConnectorName":"QuickBooks Online","EffDate":"2015-08-25","EndDate":"2015-09-24","LeadSourceMostRecent":"Test","LicenseKey":"ADECA7FB01A67F94","ProductRatePlans":["ZT - Free - Pro"],"User":{"TempPwd":"ydYD91-!","UserName":"vijay@vijay1.com"}},"Status":"Success"}';*/

//print_r($data);
/*$json = json_decode($data);

if($json->Status=="Error")
{
	echo "Error in Creating Account - ".$json->Message;
}*/

//Invalid response
//CURL Response</p>{"Message":"ConnectorName could not be found!","Result":"Validation error","Status":"Error"} - If we send OpenCart in connector name
//CURL Response</p>{"Message":"Account created successfully!\u000a\u000dUser created successfully!\u000a\u000dCompany created successfully!\u000a\u000dLocation created successfully!\u000a\u000dNexus created successfully!\u000a\u000d","Result":{"__type":"AccountSubscription:#AvaTaxSelfProcLib.Models","AccountId":"2000000185","CampaignId":"Test","Company":{"BIN":"124","CompanyAddr":{"City":"Seattle","Country":"US","Line1":"1000 2nd Ave","Line2":"","Line3":"","State":"WA","Zip":"98104-1094"},"CompanyCode":"default","CompanyContact":{"Email":"vijay@vijay.com","Fax":"","FirstName":"Vijay","LastName":"Nalawade","MobileNumber":"","PhoneNumber":"7276888868","Title":"Mr"},"CompanyName":"Vijay Store","TIN":"123456789"},"ConnectorName":"QuickBooks Online","EffDate":"2015-08-13","EndDate":"2015-09-12","LeadSourceMostRecent":"Test","LicenseKey":"E7772D30BD1DBBB5","ProductRatePlans":["ZT - Free - Pro"],"User":{"TempPwd":"viVJ83_$","UserName":"vijay@vijay.com"}},"Status":"Success"}
?>