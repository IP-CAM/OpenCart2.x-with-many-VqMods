<?php
final class Tax {
	private $tax_rates = array();
public $tax_address_error;
						  private $payment_address;
						  private $store_address;
			

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');

		if (isset($this->session->data['shipping_address'])) {
			$this->setShippingAddress($this->session->data['shipping_address']['country_id'], $this->session->data['shipping_address']['zone_id']);
		} elseif ($this->config->get('config_tax_default') == 'shipping') {
			$this->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
		}

		if (isset($this->session->data['payment_address'])) {
			$this->setPaymentAddress($this->session->data['payment_address']['country_id'], $this->session->data['payment_address']['zone_id']);
		} elseif ($this->config->get('config_tax_default') == 'payment') {
			$this->setPaymentAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
		}

		$this->setStoreAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
	}

	public function setShippingAddress($country_id, $zone_id) {
$this->shipping_address = array(
							'country_id' => $country_id,
							'zone_id'    => $zone_id
					);		
			
		$tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.name, tr2.rate, tr2.type, tr1.priority FROM " . DB_PREFIX . "tax_rule tr1 LEFT JOIN " . DB_PREFIX . "tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN " . DB_PREFIX . "geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'shipping' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND z2gz.country_id = '" . (int)$country_id . "' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '" . (int)$zone_id . "') ORDER BY tr1.priority ASC");

		foreach ($tax_query->rows as $result) {
			$this->tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = array(
				'tax_rate_id' => $result['tax_rate_id'],
				'name'        => $result['name'],
				'rate'        => $result['rate'],
				'type'        => $result['type'],
				'priority'    => $result['priority']
			);
		}
	}

	public function setPaymentAddress($country_id, $zone_id) {
	$this->payment_address = array(
							'country_id' => $country_id,
							'zone_id'    => $zone_id
					);				
			
		$tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.name, tr2.rate, tr2.type, tr1.priority FROM " . DB_PREFIX . "tax_rule tr1 LEFT JOIN " . DB_PREFIX . "tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN " . DB_PREFIX . "geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'payment' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND z2gz.country_id = '" . (int)$country_id . "' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '" . (int)$zone_id . "') ORDER BY tr1.priority ASC");

		foreach ($tax_query->rows as $result) {
			$this->tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = array(
				'tax_rate_id' => $result['tax_rate_id'],
				'name'        => $result['name'],
				'rate'        => $result['rate'],
				'type'        => $result['type'],
				'priority'    => $result['priority']
			);
		}
	}

	public function setStoreAddress($country_id, $zone_id) {
	$this->store_address = array(
							'country_id' => $country_id,
							'zone_id'    => $zone_id
		);
		
		$tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.name, tr2.rate, tr2.type, tr1.priority FROM " . DB_PREFIX . "tax_rule tr1 LEFT JOIN " . DB_PREFIX . "tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN " . DB_PREFIX . "geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'store' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND z2gz.country_id = '" . (int)$country_id . "' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '" . (int)$zone_id . "') ORDER BY tr1.priority ASC");

		foreach ($tax_query->rows as $result) {
			$this->tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = array(
				'tax_rate_id' => $result['tax_rate_id'],
				'name'        => $result['name'],
				'rate'        => $result['rate'],
				'type'        => $result['type'],
				'priority'    => $result['priority']
			);
		}
	}

	public function calculate($value, $tax_class_id, $calculate = true) {
		if ($tax_class_id && $calculate) {
			$amount = 0;

			$tax_rates = $this->getRates($value, $tax_class_id);

			foreach ($tax_rates as $tax_rate) {
				if ($calculate != 'P' && $calculate != 'F') {
					$amount += $tax_rate['amount'];
				} elseif ($tax_rate['type'] == $calculate) {
					$amount += $tax_rate['amount'];
				}
			}

			return $value + $amount;
		} else {
			return $value;
		}
	}

	public function getTax($value, $tax_class_id) {
		$amount = 0;

		$tax_rates = $this->getRates($value, $tax_class_id);

		foreach ($tax_rates as $tax_rate) {
			$amount += $tax_rate['amount'];
		}

		return $amount;
	}


				public function getCountry($country_id) {
					$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "'");

					return $query->row;
				}

				public function getZone($zone_id) {
					$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$zone_id . "'");

					return $query->row;
				}

				public function getCategories($product_id) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "category_description cd ON (pc.category_id = cd.category_id) WHERE pc.product_id = '" . (int)$product_id . "'");

					$product_categories = "";
					foreach($query->rows as $row)
					{
						$product_categories .= $row["name"].", ";
					}
					return $product_categories;
				}

				
			 /***************************************************************************
			 *   Last Updated On	:	05/14/2015			                            *
			 *   Description        :   This function returns the original price of		* 
			 *							product by product ID							*
			 ***************************************************************************/
			 
				public function getProductOriginalPrice($product_id) {
					$product_price_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

					if ($product_price_query->num_rows) {
						$price = $product_price_query->row['price'];
					}

					return $price;
				}

			/****************************************************************************
			*   Last Updated On		:	05/14/2015			                           	*
			*   Description			:  	This function calculate the Taxable Amount		*
			****************************************************************************/
				
				public function AvaTaxAmount($price) {
				
					require_once(VQMod::modCheck(VQMod::modCheck(DIR_SYSTEM . 'AvaTax4PHP/AvaTax.php')));

					global $registry;
					$this->cart = $registry->get('cart');

					$environment = 'Development';

					$service_url = $this->config->get('config_avatax_service_url');
					$account = $this->config->get('config_avatax_account');
					$license = $this->config->get('config_avatax_license_key');
					$client = $this->config->get('config_avatax_client');

					if($this->config->get('config_avatax_service_url')=='https://development.avalara.net')
						$environment = "Development";
					else 
						$environment = "Production";

					new ATConfig($environment, array('url'=>$service_url, 'account'=>$account,'license'=>$license, 'client'=>$client, 'trace'=> TRUE));
				
					//Variable Mapping
					if(!isset($this->session->data['guest']))
					{
						$country_details = $this->getCountry($this->store_address['country_id']);
						$zone_details = $this->getZone($this->store_address['zone_id']);
						if(isset($this->shipping_address['country_id']))
						{
							$dest_country_details = $this->getCountry($this->shipping_address['country_id']);
							$dest_zone_details = $this->getZone($this->shipping_address['zone_id']);
						}
						else
						{
							$dest_country_details = $this->getCountry($this->payment_address['country_id']);
							$dest_zone_details = $this->getZone($this->payment_address['zone_id']);
						}
					}
					else
					{
						$guest = $this->session->data['guest'];
						$customer_group_id = $guest['customer_group_id'];
						$country_details = $this->getCountry($this->store_address['country_id']);
						$zone_details = $this->getZone($this->store_address['zone_id']);
						if(isset($guest['shipping']['country_id']))
						{
							$guest_address = $this->session->data['shipping_address'];
							 $dest_country_details = $this->getCountry($guest_address['country_id']);
							$dest_zone_details = $this->getZone($guest_address['zone_id']);
						}
						else
						{
							$guest_address = $this->session->data['payment_address'];
							$dest_country_details = $this->getCountry($guest_address['country_id']);
							$dest_zone_details = $this->getZone($guest_address['zone_id']);
						}
					}

					$CustomerCode = $this->config->get('config_account_id');
					$OrigAddress = $this->config->get('config_address');
					$OrigCity = $this->config->get('config_city');
					$OrigRegion = $zone_details["code"];
					$OrigPostalCode = $this->config->get('config_postal_code');
					$OrigCountry = $country_details["iso_code_2"];

					 if (($this->customer->isLogged()) && (isset($this->session->data['payment_address']['address_id']) || isset($this->session->data['shipping_address']['address_id']) || isset($this->customer->request->request['shipping_address_1']) || isset($this->customer->request->request['payment_address_1'])))  {

						//we will get shipping address only on admin side. during client side we will directly read the address
						if(!isset($this->customer->request->request['shipping_address']) || !isset($this->customer->request->request['payment_address']))
						{

							if(isset($this->session->data['shipping_address']['address_id']))
							{
								$customer_address = $this->customer->getAddress($this->session->data['shipping_address']['address_id']);
							}
							else
							{
								if(isset($this->session->data['payment_address']['address_id']))
								{
									$customer_address = $this->customer->getAddress($this->session->data['payment_address']['address_id']);
								}
							}
							
							if(isset($customer_address))
							{
								$DestAddress = $customer_address["address_1"];
								$DestCity = $customer_address["city"];
								$DestRegion = $customer_address["zone_code"];
								$DestPostalCode = $customer_address["postcode"];
								$DestCountry = $customer_address["iso_code_2"];
							}
						}
						else
						{
							if(isset($this->customer->request->request['shipping_address_1']) && $this->customer->request->request['shipping_address_1']!="")
							{
								$DestAddress = $this->customer->request->request['shipping_address_1'];
								$DestCity = $this->customer->request->request['shipping_city'];
								$DestPostalCode = $this->customer->request->request['shipping_postcode'];
							}
							else
							{
								$DestAddress = $this->customer->request->request['payment_address_1'];
								$DestCity = $this->customer->request->request['payment_city'];
								$DestPostalCode = $this->customer->request->request['payment_postcode'];
							}

							$DestRegion = $dest_zone_details["code"];
							$DestCountry = $dest_country_details["iso_code_2"];
						}

					} else {
						// this shipping address for post is used in else part when the tax is calculated from admin (update Total)
						//and if when the tax is calculated from customer side.
						if(!isset($this->customer->request->post['shipping_address']) || !isset($this->customer->request->post['payment_address']))
						{
							if(isset($this->session->data['shipping_address']))
							{
							  $guest_address = $this->session->data['shipping_address'];
							   $DestAddress = $guest_address['address_1'];
								$DestCity = $guest_address['city'];
								$DestPostalCode = $guest_address['postcode'];
							}
							else
							{
							if(isset($this->session->data['payment_address']))
							{
								$guest_address = $this->session->data['payment_address'];
							   $DestAddress = $guest_address['address_1'];
								$DestCity = $guest_address['city'];
								$DestPostalCode = $guest_address['postcode'];
								}
							}
							$DestRegion = $dest_zone_details["code"];
							$DestCountry = $country_details["iso_code_2"];
						}
						else
						{
							if(isset($this->customer->request->post['shipping_address_1']))
							{
								$DestAddress = $this->customer->request->post['shipping_address_1'];
								$DestCity = $this->customer->request->post['shipping_city'];
								$DestPostalCode = $this->customer->request->post['shipping_postcode'];
							}
							else
							{
							if(isset($this->session->data['payment_address']))
							{
								
								$DestAddress = $this->customer->request->post['payment_address_1'];
								$DestCity = $this->customer->request->post['payment_city'];
								$DestPostalCode = $this->customer->request->post['payment_postcode'];
							  }  
							}

							$DestRegion = $dest_zone_details["code"];

							$DestCountry = $dest_country_details["iso_code_2"];
						}
					}

					$CompanyCode = $this->config->get('config_avatax_company_code');
					$DocType = "SalesOrder";
					//$DocCode = $this->config->get('config_invoice_prefix').$this->config->get('config_account_id');
					$a = session_id();
					if(empty($a)) session_start();

					//$DocCode = session_id();
					$DocCode = "taxphp";
					$SalesPersonCode = "";
					$EntityUseCode = "";
					$Discount = 0;

					//Added for discount calculation and coupon amount is taken from store front. Ticket # - CLOUDERP-3480
					if(isset($this->session->data['coupon_amount']) && !empty($this->session->data['coupon_amount']))
					{
						$Discount = $this->session->data['coupon_amount'];
					}

					$PurchaseOrderNo = '';
					$ExemptionNo = "";
					$LocationCode = '';
					$LineNo = 1;
					$order_total = 0;
					$status = false;

					$client = new TaxServiceSoap($environment);
					$request = new GetTaxRequest();
					$dateTime = new DateTime();
					//$request->setDocDate($DocDate);
					$request->setCompanyCode($CompanyCode);
					$request->setDocType($DocType);
					$request->setDocCode($DocCode);
					$request->setDocDate(date_format($dateTime, "Y-m-d"));
					$request->setSalespersonCode($SalesPersonCode);
					$request->setCustomerCode($CustomerCode);
					$request->setCustomerUsageType($EntityUseCode);
					$request->setDiscount($Discount);
					$request->setPurchaseOrderNo($PurchaseOrderNo);
					$request->setExemptionNo($ExemptionNo);
					$request->setDetailLevel(DetailLevel::$Tax);
					$request->setLocationCode($LocationCode);
					$request->setCommit(FALSE);

					//Add Origin Address
					$origin = new Address();
					$origin->setLine1($OrigAddress);
					$origin->setLine2("");
					$origin->setCity($OrigCity);
					$origin->setRegion($OrigRegion);
					$origin->setPostalCode($OrigPostalCode);
					$origin->setCountry($OrigCountry);
					$request->setOriginAddress($origin);

					// Add Destination Address
					if(isset($DestAddress)) {
						$destination = new Address();
						$destination->setLine1($DestAddress);
						$destination->setLine2("");
						$destination->setCity($DestCity);
						$destination->setRegion($DestRegion);
						$destination->setPostalCode($DestPostalCode);
						$destination->setCountry($DestCountry);
						$request->setDestinationAddress($destination);
					}
					// Line level processing
					$Ref1 = '';
					$Ref2 = '';
					$ExemptionNo = '';
					$RevAcct = '';
					$EntityUseCode = '';

					$lines = array();
					$product_total = 0;
					$i = 0;

					$products = $this->cart->getProducts();		//getProducts function is executed from cart.php page
					$lineCount = count($products);
					
					foreach ($products as $product)
					{
						$total_amount = $product["total"];
						$Description = $this->getCategories($product["product_id"]);

						if(isset($product["tax_class_id"]) && $product["tax_class_id"] > 0)
						{
							if($product["tax_class_title"] == 'Non Taxable')
							{
								$TaxCode = 'NT';
							}
							else
							{
								$TaxCode = $product["tax_class_title"];
							}
						}
						else
						{
							$TaxCode = '';
						}

						$line1 = new Line();
						$line1->setNo($product["product_id"]);

						//UPC/SKU Code Added by Vijay on 10th Dec 2014. If UPC/SKU code is selected & it is available for that product, it will be passed else Model number
						//Changed by Vijay on 26 Dec 2014. Added 50 Characters limitation for Model number & SKU, as CALC service doesn't accept more than 50 characters Item Code.
						if(($this->config->get('config_avatax_product_code')=='UPC') && trim($product["upc"])<>"")
						{
							$line1->setItemCode("UPC:".$product["upc"]);
						}
						elseif(($this->config->get('config_avatax_product_code')=='SKU') && trim($product["sku"])<>"")
						{
							$line1->setItemCode(substr($product["sku"],0,50));
						}
						else
						{
							$line1->setItemCode(substr($product["model"],0,50));
						}

						$line1->setDescription($Description);
						$line1->setTaxCode($TaxCode);
						$line1->setQty($product["quantity"]);
						$line1->setAmount($total_amount);

						//Added to handle coupon scenario regarding multiple products or order
						if(isset($this->session->data['coupon_amount']) && !empty($this->session->data['coupon_amount']))
						{
							if(isset($this->session->data['coupon_info']) && !empty($this->session->data['coupon_info']))
							{
								$coupon_info = $this->session->data['coupon_info'];
							}
							else
							{
								$coupon_info = array('product'=>'');
							}
							if (!$coupon_info['product'] && empty($coupon_info['product'])) {
								$status = true;
							}
							else {
								if (in_array($product['product_id'], $coupon_info['product'])) {
									$status = true;
								} else {
									$status = false;
								}
							}
						}
						else
						{
							$status = false;
						}

						$line1->setDiscounted($status);

						$line1->setRevAcct($RevAcct);
						$line1->setRef1($Ref1);
						$line1->setRef2($Ref2);
						$line1->setExemptionNo($ExemptionNo);
						$line1->setCustomerUsageType($EntityUseCode);
						$line1->setOriginAddress($origin);
						$line1->setDestinationAddress($destination);

						$lines[$i] = $line1;
						$i++;
						$order_total += $total_amount;
						//if($discount_count>0) $avatax_discount_amount += (($product_original_amount - $discount_amount) * $product["quantity"]);
						$product_total += $product['quantity'];
					}
					//Shipping Line Item
					// Order Total
					 if(isset($this->session->data['shipping_method']))
					 {
						 $shipping_method = $this->session->data['shipping_method'];
						 if(isset($shipping_method["tax_class_id"]) && $shipping_method["tax_class_id"] > 0)
						 {
							 $TaxClasses = $this->db->query("SELECT title FROM " . DB_PREFIX . "tax_class  WHERE tax_class_id ='" . $shipping_method["tax_class_id"] . "'");
							 if($TaxClasses->row['title'] == 'Non Taxable')
							 {
								 $TaxCode = 'NT';
							 }
							 else
							 {
								 $TaxCode = $TaxClasses->row['title'];
							 }
						 }
						 else
						 {
							 //$TaxCode = 'FR';
							 $TaxCode = '';
						 }

						$line1 = new Line();
						$line1->setNo($i+1);
						$line1->setItemCode($shipping_method['code']);
						$line1->setDescription($shipping_method['title']);
						$line1->setTaxCode($TaxCode);
						$line1->setQty(1);
						
						//If Coupon is applied & free shipping is enabled, we'll pass 0 to free shipping - https://avalara.atlassian.net/wiki/display/CONNECTOR/Free+Shipping+option+in+Coupons
						$cost = $shipping_method['cost'];
						if(isset($this->session->data['coupon_info']) && !empty($this->session->data['coupon_info']))
						{
							$coupon_info = $this->session->data['coupon_info'];
							if($coupon_info['shipping'])
							{
								$cost = 0;
							}
						}
						$line1->setAmount($cost);

						$line1->setDiscounted(false);	//Changed to true to not consider discount amount
						$line1->setRevAcct($RevAcct);
						$line1->setRef1($Ref1);
						$line1->setRef2($Ref2);
						$line1->setExemptionNo($ExemptionNo);
						$line1->setCustomerUsageType($EntityUseCode);
						$line1->setOriginAddress($origin);
						$line1->setDestinationAddress($destination);

						$lines[$i] = $line1;
						$i++;
					 }

					//Code added for handling fee
					$hadling_total = $this->config->get('handling_total');
					$hadling_tax_class_id = $this->config->get('handling_tax_class_id');
					$hadling_fee = $this->config->get('handling_fee');

					//Added Handling Status in if condition by Vijay Nalawade on 13 Jan 2015. To check if Handling Fee status is enabled or not
					$handling_status = $this->config->get('handling_status');

					if((!empty($hadling_total)) && ($handling_status==1))
					{
						if($order_total <= $hadling_total){
							if($hadling_tax_class_id > 0)
							{
								$TaxClasses = $this->db->query("SELECT title FROM " . DB_PREFIX . "tax_class  WHERE tax_class_id ='" . $hadling_tax_class_id . "'");
								if($TaxClasses->row['title'] == 'Non Taxable')
								{
									$TaxCode = 'NT';
								}
								else
								{
									$TaxCode = $TaxClasses->row['title'];
								}
							}
							else
							{
								//$TaxCode = 'HNLD';
								$TaxCode = '';
							}
							$line1 = new Line();
							$line1->setNo($i+1);
							$line1->setItemCode('handling');
							$line1->setDescription('Handling Fee');
							//$line1->setTaxCode($TaxCode);
							$line1->setQty(1);
							$line1->setAmount($hadling_fee);
							$line1->setDiscounted(false);
							$line1->setRevAcct($RevAcct);
							$line1->setRef1($Ref1);
							$line1->setRef2($Ref2);
							$line1->setExemptionNo($ExemptionNo);
							$line1->setCustomerUsageType($EntityUseCode);
							$line1->setOriginAddress($origin);
							$line1->setDestinationAddress($destination);

							$lines[$i] = $line1;
							$i++;
						}
					}

					//$request->setLines(array($lines));
					$request->setLines($lines);
					$returnMessage = "";

					try {
					
					//if (!empty($DestAddress)) {
					
					$latency = round(microtime(true) * 1000);
					$getTaxResult = $client->getTax($request);
					$latency = round(microtime(true) * 1000)-$latency;
					$this->session->data['latency'] = "" ;
					$this->session->data['latency'] = $latency ;
						
						
					/************* Logging code snippet (optional) starts here *******************/
						// System Logger starts here:
						
						$log_mode = $this->config->get('config_avatax_log');
					
						if($log_mode==1){
							$timeStamp 			= 	new DateTime();						// Create Time Stamp
							$params				=   '[Input: ' . ']';		// Create Param List
							$u_name				=	'';							// Eventually will come from $_SESSION[] object

							// Creating the System Logger Object
							$application_log 	= 	new SystemLogger;

							$application_log->AddSystemLog($timeStamp->format('Y-m-d H:i:s'), __FUNCTION__, __CLASS__, __METHOD__, __FILE__, $u_name, $params, $client->__getLastRequest());		// Create System Log
							$application_log->WriteSystemLogToFile();			// Log info goes to log file

							$application_log->AddSystemLog($timeStamp->format('Y-m-d H:i:s'), __FUNCTION__, __CLASS__, __METHOD__, __FILE__, $u_name, $params, $client->__getLastResponse());		// Create System Log
							$application_log->WriteSystemLogToFile();			// Log info goes to log file

							//	$application_log->WriteSystemLogToDB();							// Log info goes to DB
							// 	System Logger ends here
							//	Logging code snippet (optional) ends here
						}
					
						// Error Trapping
						if ($getTaxResult->getResultCode() == SeverityLevel::$Success) {
						
							return $getTaxResult;

							// If NOT success - display error messages to console
							// it is important to itterate through the entire message class

						} else {
							foreach ($getTaxResult->getMessages() as $msg) {
								$returnMessage .= $msg->getName() . ": " . $msg->getSummary() . "\n";
							}
							return $getTaxResult;
						}
						//}
					} catch (SoapFault $exception) {
						$returnMessage = "Exception: ";
						if ($exception)
							$returnMessage .= $exception->faultstring;
						return 0;

					}   //Comment this line to return SOAP XML
				}
				
	public function getRateName($tax_rate_id) {
		$tax_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "tax_rate WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");

		if ($tax_query->num_rows) {
			return $tax_query->row['name'];
		} else {
			return false;
		}
	}

	public function getRates($value, $tax_class_id) {
		$tax_rate_data = array();

					//Variable Mapping
					if ($this->customer->isLogged()) {
						$customer_address = $this->customer->getAddress($this->customer->getAddressId());
						$CountryCode = $customer_address["iso_code_2"];

					} else {
						
						$country_details = $this->getCountry($this->config->get('config_country_id'));
						$CountryCode = $country_details["iso_code_2"];
					
					}

					$amount = 0;
					//if($this->config->get('config_avatax_tax_calculation') && ($avatax_tax_country_pos!==false))
					if($this->config->get('config_avatax_tax_calculation'))
					{
						if($this->config->get('config_avatax_taxcall_flag')== 1)
						{
							$time_start = round(microtime(true) * 1000);
							unset($this->session->data['avatax_tax']);
							if(isset($this->session->data['avatax_tax'][number_format($value, 4, '.', '')]))
							{
								//$tax_result = (object) $this->session->data['avatax_tax'][number_format($value, 4, '.', '')];
								$tax_rate_data = $this->session->data['avatax_tax'][number_format($value, 4, '.', '')];
								$this->config->set('avataxname', $tax_rate_data);
							}
							else
							{
								//$amount = $this->AvaTaxAmount($value);

								
								$tax_result = $this->AvaTaxAmount($value);
							
								
					
								$tax_rate_data = array();
								$tax_rate_count = 0;

								if ($tax_result->getResultCode() == SeverityLevel::$Success)
								{
									foreach($tax_result->getTaxLines() as $tax_line)
									{
										foreach($tax_line->getTaxDetails() as $tax_details)
										{
											$tax_rate_data[$tax_rate_count] = array(
												'tax_rate_id' => $tax_rate_count,
												'name'        => $tax_details->getTaxName(),
												'rate'        => $tax_details->getRate(),
												'type'        => $tax_details->getTaxType(),
												'amount'      => $tax_details->getTax()
											);
											$tax_rate_count++;
										}
										$this->config->set('avataxname', $tax_rate_data);
									}
									$this->session->data['avatax_tax'][number_format($value, 4, '.', '')] = $tax_rate_data;
									$this->session->data['previous_error_status'] = "Success";
								}
								else
								{
									$errormsg = "";
									/*foreach ($tax_result->getMessages() as $msg) {
										//$this->session->data['previous_error_status'].= $msg->getName() . ": " . $msg->getSummary() . "\n";
										$errormsg .= $msg->getName() . ": " . $msg->getSummary() . "\n";

									}*/
									$msg = $tax_result->getMessages();
									$errormsg .= $msg[0]->getName() . ": " . $msg[0]->getSummary();
									$this->session->data['previous_error_status'] = '<div class="warning" style="padding: 10px 10px 10px 33px;margin-bottom: 15px;color: #555555;background: #FFD1D1 url("../image/warning.png") 10px center no-repeat;border: 1px solid #F8ACAC;		-webkit-border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-khtml-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;">
									<b>Avatax - Address Validation Error Message: </b>' . $errormsg .'<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>';
									$this->session->data['ava_taxrate']= 'T';
								}
								$this->config->set('config_avatax_taxcall_flag','0');
								
								/************* Logging code snippet (optional) starts here *******************/
								// System Logger starts here:
								
								$log_mode = $this->config->get('config_avatax_log');
								
								if($log_mode==1){
								   
									require_once(VQMod::modCheck(VQMod::modCheck(VQMod::modCheck(DIR_SYSTEM . 'AvaTax4PHP/classes/SystemLogger.class.php'))));			
									$timeStamp 			= 	new DateTime();						// Create Time Stamp
									$params				=   '[Input: ' . ']';		// Create Param List
									$u_name				=	'';							// Eventually will come from $_SESSION[] object

									// Creating the System Logger Object
									$application_log 	= 	new SystemLogger;
									$connectortime = round(microtime(true) * 1000)-$time_start;
									$latency = $this->session->data['latency']  ;
									$connectortime= $connectortime- $latency;
									
									if(isset($errormsg))
									{
										$lineCount = 0;
									}
									else
									{
										$lineCount = count($tax_result->getTaxLines());
									}
									
									$application_log->metric('GetTax '.$tax_result->getDocType(),$lineCount,$tax_result->getDocCode(),$connectortime,$latency);
									
									$latency =""  ;
									$this->session->data['latency'] ="";
									//	$application_log->WriteSystemLogToDB();							// Log info goes to DB
									// 	System Logger ends here
									//	Logging code snippet (optional) ends here
								
								}
							}
						}
					}
					else
					{
						$this->session->data['previous_error_status'] = "Success";
						

		if (isset($this->tax_rates[$tax_class_id])) {
			foreach ($this->tax_rates[$tax_class_id] as $tax_rate) {
				if (isset($tax_rate_data[$tax_rate['tax_rate_id']])) {
					$amount = $tax_rate_data[$tax_rate['tax_rate_id']]['amount'];
				} else {
					$amount = 0;
				}

				if ($tax_rate['type'] == 'F') {
					$amount += $tax_rate['rate'];
				} elseif ($tax_rate['type'] == 'P') {
					$amount += ($value / 100 * $tax_rate['rate']);
				}

				$tax_rate_data[$tax_rate['tax_rate_id']] = array(
					'tax_rate_id' => $tax_rate['tax_rate_id'],
					'name'        => $tax_rate['name'],
					'rate'        => $tax_rate['rate'],
					'type'        => $tax_rate['type'],
					'amount'      => $amount
				);
			}
		}

		}
			

		return $tax_rate_data;
	}

	public function has($tax_class_id) {
		return isset($this->taxes[$tax_class_id]);
	}
}