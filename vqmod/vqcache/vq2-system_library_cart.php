<?php
class Cart {
	private $config;
	private $db;
	private $data = array();

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->tax = $registry->get('tax');
		$this->weight = $registry->get('weight');

		if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
			$this->session->data['cart'] = array();
		}
	}

	public function getProducts() {
		if (!$this->data) {
			foreach ($this->session->data['cart'] as $key => $quantity) {
				$product = unserialize(base64_decode($key));

				$product_id = $product['product_id'];

				$stock = true;

				// Options
				if (!empty($product['option'])) {
					$options = $product['option'];
				} else {
					$options = array();
				}

				// Profile
				if (!empty($product['recurring_id'])) {
					$recurring_id = $product['recurring_id'];
				} else {
					$recurring_id = 0;
				}

				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");


					if($product_query->row["tax_class_id"] > 0)
					{
						$TaxClasses = $this->db->query("SELECT title FROM " . DB_PREFIX . "tax_class  WHERE tax_class_id ='" . $product_query->row["tax_class_id"] . "'");
					}
				
				if ($product_query->num_rows) {
					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;

					$option_data = array();

					foreach ($options as $product_option_id => $value) {
						$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

						if ($option_query->num_rows) {
							if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
								$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

								if ($option_value_query->num_rows) {
									if ($option_value_query->row['price_prefix'] == '+') {
										$option_price += $option_value_query->row['price'];
									} elseif ($option_value_query->row['price_prefix'] == '-') {
										$option_price -= $option_value_query->row['price'];
									}

									if ($option_value_query->row['points_prefix'] == '+') {
										$option_points += $option_value_query->row['points'];
									} elseif ($option_value_query->row['points_prefix'] == '-') {
										$option_points -= $option_value_query->row['points'];
									}

									if ($option_value_query->row['weight_prefix'] == '+') {
										$option_weight += $option_value_query->row['weight'];
									} elseif ($option_value_query->row['weight_prefix'] == '-') {
										$option_weight -= $option_value_query->row['weight'];
									}

									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => $value,
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => $option_value_query->row['option_value_id'],
										'name'                    => $option_query->row['name'],
										'value'                   => $option_value_query->row['name'],
										'type'                    => $option_query->row['type'],
										'quantity'                => $option_value_query->row['quantity'],
										'subtract'                => $option_value_query->row['subtract'],
										'price'                   => $option_value_query->row['price'],
										'price_prefix'            => $option_value_query->row['price_prefix'],
										'points'                  => $option_value_query->row['points'],
										'points_prefix'           => $option_value_query->row['points_prefix'],
										'weight'                  => $option_value_query->row['weight'],
										'weight_prefix'           => $option_value_query->row['weight_prefix']
									);
								}
							} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
								foreach ($value as $product_option_value_id) {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

									if ($option_value_query->num_rows) {
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}

										if ($option_value_query->row['points_prefix'] == '+') {
											$option_points += $option_value_query->row['points'];
										} elseif ($option_value_query->row['points_prefix'] == '-') {
											$option_points -= $option_value_query->row['points'];
										}

										if ($option_value_query->row['weight_prefix'] == '+') {
											$option_weight += $option_value_query->row['weight'];
										} elseif ($option_value_query->row['weight_prefix'] == '-') {
											$option_weight -= $option_value_query->row['weight'];
										}

										if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
											$stock = false;
										}

										$option_data[] = array(
											'product_option_id'       => $product_option_id,
											'product_option_value_id' => $product_option_value_id,
											'option_id'               => $option_query->row['option_id'],
											'option_value_id'         => $option_value_query->row['option_value_id'],
											'name'                    => $option_query->row['name'],
											'value'                   => $option_value_query->row['name'],
											'type'                    => $option_query->row['type'],
											'quantity'                => $option_value_query->row['quantity'],
											'subtract'                => $option_value_query->row['subtract'],
											'price'                   => $option_value_query->row['price'],
											'price_prefix'            => $option_value_query->row['price_prefix'],
											'points'                  => $option_value_query->row['points'],
											'points_prefix'           => $option_value_query->row['points_prefix'],
											'weight'                  => $option_value_query->row['weight'],
											'weight_prefix'           => $option_value_query->row['weight_prefix']
										);
									}
								}
							} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
								$option_data[] = array(
									'product_option_id'       => $product_option_id,
									'product_option_value_id' => '',
									'option_id'               => $option_query->row['option_id'],
									'option_value_id'         => '',
									'name'                    => $option_query->row['name'],
									'value'                   => $value,
									'type'                    => $option_query->row['type'],
									'quantity'                => '',
									'subtract'                => '',
									'price'                   => '',
									'price_prefix'            => '',
									'points'                  => '',
									'points_prefix'           => '',
									'weight'                  => '',
									'weight_prefix'           => ''
								);
							}
						}
					}

					$price = $product_query->row['price'];

					// Product Discounts
					$discount_quantity = 0;

					foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
						$product_2 = (array)unserialize(base64_decode($key_2));

						if ($product_2['product_id'] == $product_id) {
							$discount_quantity += $quantity_2;
						}
					}

					$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

					if ($product_discount_query->num_rows) {
						$price = $product_discount_query->row['price'];
					}

					// Product Specials
					$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

					if ($product_special_query->num_rows) {
						$price = $product_special_query->row['price'];
					}

					// Reward Points
					$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

					if ($product_reward_query->num_rows) {
						$reward = $product_reward_query->row['points'];
					} else {
						$reward = 0;
					}

					// Downloads
					$download_data = array();

					$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$product_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

					foreach ($download_query->rows as $download) {
						$download_data[] = array(
							'download_id' => $download['download_id'],
							'name'        => $download['name'],
							'filename'    => $download['filename'],
							'mask'        => $download['mask']
						);
					}

					// Stock
					if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
						$stock = false;
					}

					$recurring_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "product_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`product_id` = " . (int)$product_query->row['product_id'] . " JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`recurring_id` = `p`.`recurring_id` AND `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$this->config->get('config_customer_group_id'));

					if ($recurring_query->num_rows) {
						$recurring = array(
							'recurring_id'      => $recurring_id,
							'name'            => $recurring_query->row['name'],
							'frequency'       => $recurring_query->row['frequency'],
							'price'           => $recurring_query->row['price'],
							'cycle'           => $recurring_query->row['cycle'],
							'duration'        => $recurring_query->row['duration'],
							'trial'           => $recurring_query->row['trial_status'],
							'trial_frequency' => $recurring_query->row['trial_frequency'],
							'trial_price'     => $recurring_query->row['trial_price'],
							'trial_cycle'     => $recurring_query->row['trial_cycle'],
							'trial_duration'  => $recurring_query->row['trial_duration']
						);
					} else {
						$recurring = false;
					}


						if($product_query->row["tax_class_id"] > 0)
						{
							$taxcode = $TaxClasses->row['title'];
						}
						else
						{
							$taxcode = '';
						}
				
					$this->data[$key] = array(
						'key'             => $key,
						'product_id'      => $product_query->row['product_id'],
						'name'            => $product_query->row['name'],
						'model'           => $product_query->row['model'],
'upc'                     => $product_query->row['upc'],
				'sku'                     => $product_query->row['sku'],
						'shipping'        => $product_query->row['shipping'],
						'image'           => $product_query->row['image'],
						'option'          => $option_data,
						'download'        => $download_data,
						'quantity'        => $quantity,
						'minimum'         => $product_query->row['minimum'],
						'subtract'        => $product_query->row['subtract'],
						'stock'           => $stock,
						'price'           => ($price + $option_price),
						'total'           => ($price + $option_price) * $quantity,
						'reward'          => $reward * $quantity,
						'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
						'tax_class_id'    => $product_query->row['tax_class_id'],

				'tax_class_title'           => $taxcode,
				
						'weight'          => ($product_query->row['weight'] + $option_weight) * $quantity,
						'weight_class_id' => $product_query->row['weight_class_id'],
						'length'          => $product_query->row['length'],
						'width'           => $product_query->row['width'],
						'height'          => $product_query->row['height'],
						'length_class_id' => $product_query->row['length_class_id'],
						'recurring'       => $recurring
					);
				} else {
					$this->remove($key);
				}
			}
		}

		return $this->data;
	}

	public function getRecurringProducts() {
		$recurring_products = array();

		foreach ($this->getProducts() as $key => $value) {
			if ($value['recurring']) {
				$recurring_products[$key] = $value;
			}
		}

		return $recurring_products;
	}


		public function getProductForQuantity($product_id, $quantity) {
			if ($this->customer->isLogged()) {
				$customer_group_id = $this->customer->getGroupId();
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}	
			
			//UPC/SKU Code Added by Vijay on 10th Dec 2014. If UPC/SKU code is selected & it is available for that product, it will be passed else Model number. Added p.upc & p.sku in select field & return array.
			$query = $this->db->query("SELECT pd.*, p.model, p.upc, p.sku, pdes.name FROM " . DB_PREFIX . "product_discount pd LEFT JOIN " . DB_PREFIX . "product p on p.product_id = '" . (int)$product_id . "' LEFT JOIN " . DB_PREFIX . "product_description pdes ON pdes.product_id = '" . (int)$product_id . "' WHERE pd.product_id = '" . (int)$product_id . "' AND pd.customer_group_id = '" . (int)$customer_group_id . "' AND pd.quantity <= '" . (int)$quantity . "' AND ((pd.date_start = '0000-00-00' OR pd.date_start < NOW()) AND (pd.date_end = '0000-00-00' OR pd.date_end > NOW())) ORDER BY pd.quantity ASC, pd.priority ASC, pd.price ASC");
			
			if ($query->num_rows) {
				return array(
					'product_id'       => $query->row['product_id'],
					'name'             => $query->row['name'],
					'model'            => $query->row['model'],
					'upc'              => $query->row['upc'],
					'sku'              => $query->row['sku'],
					'quantity'         => $query->row['quantity'],				
					'price'            => $query->row['price']
				);
			} else {
				return false;
			}
			
			return $query->rows;		
		}
		
		public function getProduct($product_id) {
			if ($this->customer->isLogged()) {
				$customer_group_id = $this->customer->getGroupId();
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}	

			//UPC/SKU Code Added by Vijay on 10th Dec 2014. If UPC/SKU code is selected & it is available for that product, it will be passed else Model number. Added p.upc & p.sku code in select field & return array
			$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, p.upc, p.sku, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
			
			if ($query->num_rows) {
				return array(
					'product_id'       => $query->row['product_id'],
					'name'             => $query->row['name'],
					'model'            => $query->row['model'],
					'upc'              => $query->row['upc'],
					'sku'              => $query->row['sku'],
					'quantity'         => $query->row['quantity'],
					'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price'])
				);
			} else {
				return false;
			}
		}	
		
		public function getCountry($country_id) {
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "'");
			
			return $query->row;
		}

		public function getZone($zone_id) {
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$zone_id . "'");
			
			return $query->row;
		}
		
		public function AvaTaxAmount($price) {				
			$time_start = round(microtime(true) * 1000);
			//echo "In PHP AvaTaxAmount1 function";
			require_once(VQMod::modCheck(DIR_SYSTEM . 'AvaTax4PHP/AvaTax.php'));	
			
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
			if ($this->customer->isLogged()) {			
				
				$customer_address = $this->customer->getAddress($this->customer->getAddressId());
				
				$CustomerCode = $customer_address["customer_id"];
				$OrigAddress = $customer_address["address_1"];
				$OrigCity = $customer_address["city"];
				$OrigRegion = $customer_address["zone_code"];
				$OrigPostalCode = $customer_address["postcode"];
				$OrigCountry = $customer_address["iso_code_2"];
				
				$DestAddress = $customer_address["address_1"];
				$DestCity = $customer_address["city"];
				$DestRegion = $customer_address["zone_code"];
				$DestPostalCode = $customer_address["postcode"];
				$DestCountry = $customer_address["iso_code_2"];
				
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
				
				$country_details = $this->getCountry($this->config->get('config_country_id'));		
				$zone_details = $this->getZone($this->config->get('config_zone_id'));
				
				$CustomerCode = $this->config->get('config_account_id');
				$OrigAddress = $this->config->get('config_address');
				$OrigCity = $this->config->get('config_city');
				$OrigRegion = $zone_details["code"];
				$OrigPostalCode = $this->config->get('config_postal_code');
				$OrigCountry = $country_details["iso_code_2"];
				
				$DestAddress = $this->config->get('config_address');
				$DestCity = $this->config->get('config_city');
				$DestRegion = $zone_details["code"];
				$DestPostalCode = $this->config->get('config_postal_code');
				$DestCountry = $country_details["iso_code_2"];
			}
			
			$CompanyCode = $this->config->get('config_avatax_company_code');
			$DocType = "SalesOrder";
			//$DocCode = $this->config->get('config_invoice_prefix').$this->config->get('config_account_id'); 
			$a = session_id();
			if(empty($a)) session_start();
			
			//$DocCode = session_id(); 
			$DocCode = "cartphp"; 
			$SalesPersonCode = "";		
			$EntityUseCode = "";
			$Discount = 0;
			$PurchaseOrderNo = '';
			$ExemptionNo = "";
			$LocationCode = '';		
			$LineNo = 1;
			
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
			$destination = new Address();                 
			$destination->setLine1($DestAddress);         
			$destination->setLine2("");                   
			$destination->setCity($DestCity);             
			$destination->setRegion($DestRegion);         
			$destination->setPostalCode($DestPostalCode); 
			$destination->setCountry($DestCountry);       
			$request->setDestinationAddress($destination);
			
			//
			// Line level processing		
			$Ref1 = '';
			$Ref2 = '';
			$ExemptionNo = '';
			$RevAcct = '';		
			$EntityUseCode = '';
			
			$lines = array();		
			$product_total = 0;			
			$i = 0;
			//$products = $this->cart->getProducts();	
			//foreach ($products as $product) {
			
				//$TaxCode = $product["model"];
				$TaxCode = "Product1";
				$line1 = new Line();                                
				$line1->setNo(1);//$product["product_id"]
				$line1->setItemCode("Product1");
				$line1->setDescription("ProductName1");
				$line1->setTaxCode($TaxCode);
				$line1->setQty(1);
				$line1->setAmount($price);
				$line1->setDiscounted(true);
				$line1->setRevAcct($RevAcct);
				$line1->setRef1($Ref1);
				$line1->setRef2($Ref2);
				$line1->setExemptionNo($ExemptionNo);
				$line1->setCustomerUsageType($EntityUseCode);

				$lines[0] = $line1;
				$i++;
				//$product_total += $product['quantity'];
			//}
			
			//$request->setLines(array($lines));
			$request->setLines($lines);
			//print_r($request);
			$returnMessage = "";
			try {
			if (!empty($DestAddress)) {
            $connectortime = round(microtime(true) * 1000)-$time_start;
            $latency = round(microtime(true) * 1000);
                $getTaxResult = $client->getTax($request);
            $latency = round(microtime(true) * 1000)-$latency;
				
				
				// Error Trapping
				if ($getTaxResult->getResultCode() == SeverityLevel::$Success) {
				
				
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

                    $application_log->metric('GetTax
					'.$getTaxResult->getDocType(),count($getTaxResult->getTaxLines()),$getTaxResult->getDocCode(),$connectortime,$latency);

                    //	$application_log->WriteSystemLogToDB();							// Log info goes to DB
                    // 	System Logger ends here
                    //	Logging code snippet (optional) ends here
                }
                else{}
				
					return $getTaxResult;
					
					// If NOT success - display error messages to console
					// it is important to itterate through the entire message class        
							  
				} else {
					foreach ($getTaxResult->getMessages() as $msg) {
						$returnMessage .= $msg->getName() . ": " . $msg->getSummary() . "\n";
					}
					return 0;
				}
				}
			} catch (SoapFault $exception) {
				$returnMessage = "Exception: ";
				if ($exception)
					$returnMessage .= $exception->faultstring;
				return 0;
					
			}   //Comment this line to return SOAP XML		
		}	
				
	public function add($product_id, $qty = 1, $option = array(), $recurring_id = 0) {
		$this->data = array();

		$product['product_id'] = (int)$product_id;

		if ($option) {
			$product['option'] = $option;
		}

		if ($recurring_id) {
			$product['recurring_id'] = (int)$recurring_id;
		}

		$key = base64_encode(serialize($product));

		if ((int)$qty && ((int)$qty > 0)) {
			if (!isset($this->session->data['cart'][$key])) {
				$this->session->data['cart'][$key] = (int)$qty;
			} else {
				$this->session->data['cart'][$key] += (int)$qty;
			}
		}
	}

	public function update($key, $qty) {
		$this->data = array();

		if ((int)$qty && ((int)$qty > 0) && isset($this->session->data['cart'][$key])) {
			$this->session->data['cart'][$key] = (int)$qty;
		} else {
			$this->remove($key);
		}
	}

	public function remove($key) {
		$this->data = array();

		unset($this->session->data['cart'][$key]);
	}

	public function clear() {
		$this->data = array();

		$this->session->data['cart'] = array();
	}

	public function getWeight() {
		$weight = 0;

$this->session->data['ava_taxrate'] = 'F';
		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
		}

		return $weight;
	}

	public function getSubTotal() {
		$total = 0;

$this->session->data['ava_taxrate'] = 'F';
		foreach ($this->getProducts() as $product) {
			$total += $product['total'];
		}

		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

$this->session->data['ava_taxrate'] = 'F';
		foreach ($this->getProducts() as $product) {
			if ($product['tax_class_id'] || $product['tax_class_id'] >= 0) {
				$tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[0])) {
						$tax_data[0] = ($tax_rate['amount'] * 1);
					} else {
						$tax_data[0] += ($tax_rate['amount'] * 1);
					}
				}
			}
		}


				if(($this->session->data['ava_taxrate']) == 'T')
				{
					$tax_data[0] = '0';
					$this->session->data['ava_taxrate'] = 'F';
				}
				
		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

$this->session->data['ava_taxrate'] = 'F';
		foreach ($this->getProducts() as $product) {
			$total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
		}

		return $total;
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
		}

		return $product_total;
	}

	public function hasProducts() {
		return count($this->session->data['cart']);
	}

	public function hasRecurringProducts() {
		return count($this->getRecurringProducts());
	}

	public function hasStock() {
		$stock = true;

$this->session->data['ava_taxrate'] = 'F';
		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				$stock = false;
			}
		}

		return $stock;
	}

	public function hasShipping() {
		$shipping = false;

$this->session->data['ava_taxrate'] = 'F';
		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$shipping = true;

				break;
			}
		}

		return $shipping;
	}

	public function hasDownload() {
		$download = false;

$this->session->data['ava_taxrate'] = 'F';
		foreach ($this->getProducts() as $product) {
			if ($product['download']) {
				$download = true;

				break;
			}
		}

		return $download;
	}
}