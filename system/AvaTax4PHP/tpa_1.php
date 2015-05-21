<?php
session_start();

if(!isset($_SESSION['token']))
{
	header('Location: ../../admin/index.php');
}

// Configuration
if (is_file('../../config.php')) {
	require_once('../../config.php');
}
else
{
	die("Configuration file is not available");
}	

//VirtualQMOD
require_once('../../vqmod/vqmod.php');
VQMod::bootup();

// VQMODDED Startup
require_once(VQMod::modCheck(DIR_SYSTEM . 'startup.php'));

// Registry
$registry = new Registry();

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

echo "In tpa1";
echo "<br>Database: ".DB_DRIVER." - ".DB_HOSTNAME." - ".DB_USERNAME." - ".DB_PASSWORD." - ".DB_DATABASE." - ".DB_PREFIX;

//Started creating XML file
//header("Content-type: application/xml");
$xml= "<?xml version=\"1.0\"?>";
/*$xml.= "<TPA>
  <AccountCredentials>
    <AccountNumber>".$_REQUEST['acc']."</AccountNumber>
    <LicenseKey>".$_REQUEST['license']."</LicenseKey>
    <UserName>".$_REQUEST['username']."</UserName>
    <Password>".$_REQUEST['password']."</Password>
    <WebService>".$_REQUEST['serviceurl']."</WebService>
    <CompanyCode>".$_REQUEST['companyCode']."</CompanyCode>";*/

//Fetch Company details
$companyQuery="SELECT `key`,value from " . DB_PREFIX . "setting where `key` in('config_name','config_address_line2','config_address' ";

foreach ($companyQuery->rows as $result) {
	print_r($result);
}

exit;	
while($companyData=mysql_fetch_array($companyRes))
{
	$companyName=$companyData['company'];
	$companyAddress=$companyData['address'];
	$companyCity=$companyData['city'];
	$companyState=$companyData['state'];
	$companyCountry=$companyData['country'];
	$companyZip=$companyData['zipcode'];
	$companyEmail=$companyData['email'];
	$companyPhone=$companyData['phone'];

	$xml.="
	<ERPName>CSCart</ERPName>
	</AccountCredentials>
	<Company>
    <CompanyName>".$companyName."</CompanyName>
    <TIN>TinAva</TIN>
    <BIN>BinAva</BIN>
    <Address>
	<Line1>".$companyAddress."</Line1>
      <Line2></Line2>
      <Line3>".$companyState." ".$companyZip."</Line3>
      <City>".$companyCity."</City>
      <StateProvince>".$companyState."</StateProvince>
      <Country>".$companyCountry."</Country>
		<ZipPostalCode>".$companyZip."</ZipPostalCode>
    </Address>
    <PrimaryContact>
      <FirstName>".$companyEmail."</FirstName>
      <LastName>".$companyEmail."</LastName>
      <Email>".$companyEmail."</Email>
      <PhoneNumber>".$companyPhone."</PhoneNumber>
      <Title></Title>
      <MobileNumber>".$companyPhone."</MobileNumber>
      <Fax />
    </PrimaryContact>";
}

$xml.="</Company>
	<Nexus>
    <CompanyLocations>
      <CompanyLocation>
        <Country>".$companyCountry."</Country>
        <States>".$companyState."</States>
      </CompanyLocation>
	</CompanyLocations>
    <WareHouseLocations>
		<WareHouseLocation>
			<Country>".$companyCountry."</Country>
			<States>".$companyState."</States>
		</WareHouseLocation>
	</WareHouseLocations>
	<PreviousCustomerLocations>";

//Fetch all order count to calculate average
$today=date("Y-m-d");
$oneYearBack=date("Y-m-d",strtotime("$today -1 year"));
$date_difference="FROM_UNIXTIME(" . DB_PREFIX . "orders.timestamp) BETWEEN '".$oneYearBack."' and '".$today."'";//.$today;
$orderCntQuery="SELECT count(order_id) as 'Count' FROM " . DB_PREFIX . "orders where ".$date_difference;
//echo $orderCntQuery;
//exit;
$orderCntQueryRes=mysql_query($orderCntQuery);
$orderCntQueryData=mysql_fetch_array($orderCntQueryRes);
$orderCntQueryRows=$orderCntQueryData['Count'];

//Fetch all order delivery information of unique addresses
$addressQuery="SELECT DISTINCT b_country,b_state,count(*) as 'Count' FROM " . DB_PREFIX . "orders where ".$date_difference." GROUP BY b_country,b_state";
//echo "<br>Address: ".$addressQuery;
$addressRes=mysql_query($addressQuery);
while($addressData=mysql_fetch_array($addressRes))
{
	if($orderCntQueryRows<>0)
	{
		$avgOrder=round(($addressData['Count']/$orderCntQueryRows)*100);
		if($avgOrder<1)	$avgOrder=1;
	}
	
    $xml.="<PreviousCustomerLocation>
			<Country>".trim($addressData['b_country'])."</Country>
			<States>".trim($addressData['b_state'])."</States>
			<InvoicesCharged>".$avgOrder."</InvoicesCharged>
			<TotalInvoices>".$orderCntQueryRows."</TotalInvoices>
		</PreviousCustomerLocation>";
}
$xml.="</PreviousCustomerLocations></Nexus>";

//Check Tax exempt user count
$exemptCustQry="SELECT tax_exempt, COUNT(*) as 'Count' FROM " . DB_PREFIX . "users where user_type='C' GROUP BY tax_exempt";
$exemptCustRes=mysql_query($exemptCustQry);
$totalCustCnt=0;
$exemptCustCnt=0;
while($exemptCustData=mysql_fetch_array($exemptCustRes))
{
	if($exemptCustData['tax_exempt']=='Y')
		$exemptCustCnt=$exemptCustData['Count'];
	
	$totalCustCnt=$totalCustCnt+$exemptCustData['Count'];
}

$xml.="<AvaERPSettings>
    <TaxSchedule>
      <IsTaxScheduleMapped>true</IsTaxScheduleMapped>
      <TaxScheduleID />
    </TaxSchedule>
    <MapCustomer>
      <IsCustomerMappedToAvaTax>true</IsCustomerMappedToAvaTax>
      <MappedCustomers />
	  <ExemptCustomers>
        <Total>".$totalCustCnt."</Total>
        <Exempted>".$exemptCustCnt."</Exempted>
        <Customers>";

//Check Tax exempt user details
if($exemptCustCnt>0)
{
	$exemptCustQry="SELECT firstname,lastname,user_id FROM " . DB_PREFIX . "users where user_type='C' and tax_exempt='Y'";
	$exemptCustRes=mysql_query($exemptCustQry);
	while($exemptCustData=mysql_fetch_array($exemptCustRes))
	{
          $xml.="<EntityNameCode>
            <Name>Enabled</Name>
            <Code>".$exemptCustData['user_id']."</Code>
          </EntityNameCode>";
	}
}
else
{
    $xml.="<EntityNameCode>
          <Name></Name>
          <Code></Code>
          </EntityNameCode>";
}

$xml.="</Customers>
      </ExemptCustomers>
    </MapCustomer>
    <MapItemCodes>
      <MappedItemsCount>0</MappedItemsCount>
	  <MappedItems>
		<EntityNameCode>
			<Name></Name>
			<Code></Code>
        </EntityNameCode>
	  </MappedItems>
      <NonTaxableItems>
        <Total>0</Total>
        <NonTaxable>0</NonTaxable>
        <Items>
          <EntityNameCode>
            <Name></Name>
            <Code></Code>
          </EntityNameCode>
          <EntityNameCode>
            <Name></Name>
            <Code></Code>
          </EntityNameCode>
        </Items>
      </NonTaxableItems>
    </MapItemCodes>
    <AddressValidation>
      <IsAddressValidationEnabled>true</IsAddressValidationEnabled>
      <CountryNamesMapped>false</CountryNamesMapped>
      <MappedCountries>
        <MappedCountry>
          <ERPCountry></ERPCountry>
          <AvaCountry></AvaCountry>
        </MappedCountry>
		<MappedCountry>
          <ERPCountry></ERPCountry>
          <AvaCountry></AvaCountry>
        </MappedCountry>
      </MappedCountries>
    </AddressValidation>
  </AvaERPSettings>
</TPA>";

$xmlFileName="xml\\".date("d-m-YH-i").".xml";
$fp=fopen($xmlFileName,"w");
fwrite($fp, $xml);
fclose($fp);

//Pass XML data to API through file method
$url = 'http://54.148.32.35/TaxProfileAssistant/Post';

$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_MUTE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);

echo "<br>Output<pre>";
print_r($output);
echo "<br>Output end";
exit;
if(curl_errno($ch))
{
	echo "In error";
    print curl_error($ch);
	curl_close($ch);
}
else
{
	curl_close($ch);
	//If output contains error message, it means output is invalid & show error message else user should be redirected to TPA.
	if(strtolower(substr($output,0,5))=="error")
	{
		echo "<br>Please resolve following errors in order to proceed to Tax Profile Assistance Mapping - <br><br> <font style='color:#FF0000;'>";
		print_r($output);
		echo "</font>";
	}
	else
	{
		echo "<script>window.location='$output';</script>";
	}
	//echo "In success";
}
?>