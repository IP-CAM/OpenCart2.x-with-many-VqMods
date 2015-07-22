<?php
/**
 * AccountServiceSoap.class.php
 */
 
/**
 * Proxy interface for the Avalara Accounts Web Service. 
 *
 * AccountServiceSoap reads its configuration values from static variables defined
 * in ATConfig.class.php. This file must be properly configured with your security credentials.
 *
 * <p>
 * <b>Example:</b>
 * <pre>
 *  $accountService = new AccountServiceSoap();
 * </pre>
 *
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Address
 * 
 */

class AccountServiceSoap extends AvalaraSoapClient
{
    static private $servicePath = '/Account/AccountSvc.asmx';
    static protected $classmap = array(
        							'UserFetch' => 'UserFetch',
                                    'BaseRequest' => 'BaseRequest',
                                    'ValidateRequest' => 'ValidateRequest',
                                    'BaseAddress' => 'BaseAddress',
                                    'URL' => 'URL',                                    
                                    'UserName' => 'UserName',                                    
                                    'Password' => 'Password',                                    
                                    'BaseResult' => 'BaseResult',
                                    'SeverityLevel' => 'SeverityLevel',
                                    'Message' => 'Message',
                                    'Profile' => 'Profile',
                                    'Ping' => 'Ping',                                    
                                    'PingResult' => 'PingResult',
                                    'IsAuthorized' => 'IsAuthorized',                                    
                                    'IsAuthorizedResult' => 'IsAuthorizedResult');
        
    /**
     * Construct a proxy for Avalara's Address Web Service using the default URL as coded in the class or programatically set.
     * 
     * <b>Example:</b>
     * <pre>
     *  $port = new AccountServiceSoap();
     *  $port->ping();
     * </pre>
     *
     * @see AvalaraSoapClient
     * @see TaxServiceSoap
     */

    public function __construct($configurationName = 'Default')
    {
        $config = new ATConfig($configurationName);
        $this->client = new DynamicSoapClient   (
            $config->accountWSDL,
            array
            (
                'location' => $config->url.$config->accountService, 
                'trace' => $config->trace,
                'classmap' => AccountServiceSoap::$classmap
            ), 
            $config
        );
    }

    /**
     * Checks authentication of and authorization to one or more
     * operations on the service.
     * 
     * This operation allows pre-authorization checking of any
     * or all operations. It will return a comma delimited set of
     * operation names which will be all or a subset of the requested
     * operation names.  For security, it will never return operation
     * names other than those requested (no phishing allowed).
     * 
     * <b>Example:</b><br>
     * <code> isAuthorized("GetTax,PostTax")</code>
     *
     * @param string $operations  a comma-delimited list of operation names
     *
     * @return IsAuthorizedResult
     * @throws SoapFault
     */

    /*public function isAuthorized123($operations)
    {
        return $this->client->IsAuthorized123(array('Operations' => $operations))->IsAuthorizedResult;
    }*/
    
    /**
     * Verifies connectivity to the web service and returns version
     * information about the service.
     *
     * <b>NOTE:</b>This replaces TestConnection and is available on
     * every service.
     *
     * @param string $message for future use
     * @return PingResult
     * @throws SoapFault
     */

    public function ping($message = '')
    {
        return $this->client->Ping(array('Message' => $message))->PingResult;
    }
    
    /**
     * Validates an account and returns a normalized account or error.
     * {@link ValidAddress} objects in a {@link ValidateResult} object.
     *
     * Takes an {@link Address}, an optional {@link TextCase}
     * property that determines the casing applied to a validated
     * address. It defaults to TextCase::$Default.
     * <b>Example:</b><br>
     * <pre>
     * $port = new AccountServiceSoap();
     *
     * $address = new Address();
     * $address->setLine1("900 Winslow Way");
     * $address->setLine2("Suite 130");
     * $address->setCity("Bainbridge Is");
     * $address->setRegion("WA");
     * $address->setPostalCode("98110-2450");
     *
     * $result = $port->validate(new ValidateRequest($address,TextCase::$Upper));
     * </pre>
     *
     * @param ValidateRequest
     * @return ValidateResult
     *
     * @throws SoapFault
     */
    public function isAuthorized123($operations)
    {
		echo "<br>In isAuthorized123: ";
		print_r($operations);
		echo " --- <br>";
        return $this->client->IsAuthorized123(array('Operations' => $operations))->IsAuthorizedResult;
    }

	public function CompanyFetch($validateRequest)
    {
        return $this->client->CompanyFetch(array('FetchRequest' => $validateRequest))->CompanyFetchResult;
    }     

    /*public function getValidCompanyCodes() 
	{ 
		return EnsureIsArray($this->ValidAddresses->ValidAddress); 
	}*/
	
}
?>
