<?php
/**
 * CompanyFetchResult.class.php
 */
 
/**
 * @see ValidAddress
 * 
 * @author    Avalara
 * @copyright © 2004 - 2011 Avalara, Inc.  All rights reserved.
 * @package   Address
 */


class CompanyFetchResult// extends BaseResult
{
/**
 * Array of matching {@link ValidAddress}'s.
 * @var array
 */
    private $Companies;
    
/**
 * Method returning array of matching {@link ValidAddress}'s.
 * @return array
 */


	/**
 * @var string
 */
    private $TransactionId;
/**
 * @var string must be one of the values defined in {@link SeverityLevel}.
 */
    private $ResultCode = 'Success';
/**
 * @var array of Message.
 */
    private $Messages = array();

/**
 * Accessor
 * @return string
 */
    public function getTransactionId() { return $this->TransactionId; }
/**
 * Accessor
 * @return string
 */
    public function getResultCode() { return $this->ResultCode; }
/**
 * Accessor
 * @return array
 */
    public function getMessages() { return EnsureIsArray($this->Messages->Message); }
    
    //@author:swetal
    
    public function isTaxable()
    {
        return $this->Taxable;
    }

}

?>