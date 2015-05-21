<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }


require_once("TPAConfiguration.php");	//Fetch connection details from CSCart config file
$conn=mysql_connect($connection,$user,$password);
$db=mysql_select_db($database);

//Started creating XML file
//header("Content-type: application/xml");
$xml= "<?xml version=\"1.0\"?>";
$AccountCredentials= "<TPA>
  <AccountCredentials>
		<AccountNumber>".$_REQUEST['acc']."</AccountNumber>
		<LicenseKey>".$_REQUEST['license']."</LicenseKey>
		<UserName>".$_REQUEST['username']."</UserName>
		<Password>".$_REQUEST['password']."</Password>
		<WebService>".$_REQUEST['serviceurl']."</WebService>
		<CompanyCode>".$_REQUEST['companyCode']."</CompanyCode>
		<ERPName>CSCart</ERPName>
	</AccountCredentials>";

//Fetch Company details
$companyQuery="SELECT distinct company,address,city,state,country,zipcode,email,phone from ".$tablePrefix."companies LIMIT 0,1";

$companyRes=mysql_query($companyQuery);
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
	$companyFax = $companyData['fax'];

	$CompanyDetails="
	<Company>
		<CompanyName>".$companyName."</CompanyName>
		<TIN></TIN>
		<BIN></BIN>
		<Address>
			<Line1>".$companyAddress."</Line1>
			<Line2></Line2>
			<Line3></Line3>
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
			<Fax>".$companyFax."</Fax>
		</PrimaryContact>
	";
}

$NexusDetails="
</Company>
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
	<PreviousCustomerLocations>
	";

//Fetch all order count to calculate average
$orderAvgQuery="SELECT count(order_id) as 'Count' FROM ".$tablePrefix."orders where s_country='US'";
$orderAvgQueryRes=mysql_query($orderAvgQuery);
$orderAvgQueryData=mysql_fetch_array($orderAvgQueryRes);
$orderAvgQueryRows=$orderAvgQueryData['Count'];

//Fetch all order delivery information of unique addresses
$addressQuery="SELECT DISTINCT s_country,s_state,count(*) as 'Count' FROM ".$tablePrefix."orders where s_country='US'";

$addressRes=mysql_query($addressQuery);
while($addressData=mysql_fetch_array($addressRes))
{
	$InvoicesCharged = "SELECT count(*) as count FROM " .$tablePrefix."orders WHERE `avatax_paytax_error_message` ='success'";
	$InvoicesCharged = db_get_row($InvoicesCharged);
	$TotalInvoices = "SELECT count(*) as count FROM " .$tablePrefix."orders WHERE 1";
	$TotalInvoices = db_get_row($TotalInvoices);
    $NexusDetails.="<PreviousCustomerLocation>
			<Country>".trim($addressData['s_country'])."</Country>
			<States>".trim($addressData['s_state'])."</States>
			<InvoicesCharged>".$InvoicesCharged['count']."</InvoicesCharged>
			<TotalInvoices>".$TotalInvoices['count']."</TotalInvoices>
		</PreviousCustomerLocation>";
}
$NexusDetails.="</PreviousCustomerLocations></Nexus>";

//Check Tax exempt user count
$exemptCustQry="SELECT tax_exempt, COUNT(*) as 'Count' FROM ".$tablePrefix."users where user_type='C' GROUP BY tax_exempt";
$exemptCustRes=db_get_row($exemptCustQry);
$totalCustCnt=0;
$exemptCustCnt=0;
while($exemptCustData=mysql_fetch_array($exemptCustRes))
{
	if($exemptCustData['tax_exempt']=='Y')
		$exemptCustCnt=$exemptCustData['Count'];
	$totalCustCnt=$totalCustCnt+$exemptCustData['Count'];
}

$AvaERPSettings="<AvaERPSettings>
    <TaxSchedule>
      <IsTaxScheduleMapped>true</IsTaxScheduleMapped>
      <TaxScheduleID />
    </TaxSchedule>
	<MapItemCodes>
		<MappedItemsCount></MappedItemsCount>";
	//$MappedItems = "SELECT product_code,tax_code FROM " .$tablePrefix."products WHERE NOT (tax_code = 'none')";
   // $MappedItems = "SELECT * FROM ?:products WHERE `tax_code` LIKE 'none'";
    $MappedItems = db_get_array('SELECT * FROM ?:products');
   // $CountItems = mysql_num_rows($MappedItems);
    $i =0;
    foreach($MappedItems as $products)
    {
        $i = $products;
        $i++;
    }
	
	
	
	
    "<MapCustomer>
      <IsCustomerMappedToAvaTax>true</IsCustomerMappedToAvaTax>
      <MappedCustomers />
	  <ExemptCustomers>
        <Total>".$totalCustCnt."</Total>
        <Exempted>".$exemptCustCnt."</Exempted>
        <Customers>";

//Check Tax exempt user details
if($exemptCustCnt>0)
{
	$exemptCustQry="SELECT firstname,lastname,user_id FROM ".$tablePrefix."users where user_type='C' and tax_exempt='Y'";
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

//echo $xml;
//exit;
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

//print_r($output);

if(curl_errno($ch))
{
	echo "In error";
    print curl_error($ch);
	curl_close($ch);
}
else
{
	curl_close($ch);
	echo "<script>window.location='$output';</script>";
	//echo "In success";
}
?>