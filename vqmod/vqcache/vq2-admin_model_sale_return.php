<?php
class ModelSaleReturn extends Model {
	public function addReturn($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "return` SET order_id = '" . (int)$data['order_id'] . "', product_id = '" . (int)$data['product_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', product = '" . $this->db->escape($data['product']) . "', model = '" . $this->db->escape($data['model']) . "', quantity = '" . (int)$data['quantity'] . "', opened = '" . (int)$data['opened'] . "', return_reason_id = '" . (int)$data['return_reason_id'] . "', return_action_id = '" . (int)$data['return_action_id'] . "', return_status_id = '" . (int)$data['return_status_id'] . "', comment = '" . $this->db->escape($data['comment']) . "', date_ordered = '" . $this->db->escape($data['date_ordered']) . "', date_added = NOW(), date_modified = NOW()");
	}

	public function editReturn($return_id, $data) {


			$return_details = $this->getReturn($return_id);
	
			if(!($return_details["avatax_return_document_code"] == "" || is_null($return_details["avatax_return_document_code"])))
			{       

			if($this->config->get('config_avatax_tax_calculation')&& $this->config->get('config_avatax_transaction_calculation'))
			{
				$time_start = round(microtime(true) * 1000);
				$return_details = $this->getReturn($return_id);

				if(count($return_details) > 0)
				{
					$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int)$return_details["order_id"] . "'");
					if($order_query->row['avatax_paytax_error_message'] == 'Success')
					{
						$order_products = array();
						if ($order_query->num_rows) {
							$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product LEFT JOIN " . DB_PREFIX . "product ON(" . DB_PREFIX . "order_product.product_id=" . DB_PREFIX . "product.product_id) WHERE order_id = '" . (int)$return_details["order_id"] . "'");

							$order_products = $product_query->rows;
						}

						$data["product"] = $return_details["product"];
						$data["quantity"] = $return_details["quantity"];
						$data["return_reason_id"] = $return_details["return_reason_id"];
						$data["avatax_return_document_code"] = $return_details["avatax_return_document_code"];
						
						$connectortime = round(microtime(true) * 1000)-$time_start;
						
						if($return_details["return_status_id"] == 3){
							$cancelCode = "DocDeleted";
							$CancelTaxValue = $this->AvaTaxCancelTax($return_details["avatax_return_document_code"],$cancelCode);
							$CancelTaxValue = $this->AvaTaxCancelTax($return_details["avatax_return_document_code"],$cancelCode);
							if($CancelTaxValue === 'Success')
							{
								$this->session->data['avatax_return_error_message'] = 'Success';
							}
							else
							{
								$this->session->data['avatax_return_error_message'] = '<b>Avatax Error5 : </b>'.$CancelTaxValue;
							}
						}

						$TaxHistoryReturnValue = $this->AvaTaxGetTaxHistory($order_query);
						
						$time_start = round(microtime(true) * 1000);
						$time_start = $time_start + $connectortime;
						
						require_once(DIR_SYSTEM . 'AvaTax4PHP/classes/SystemLogger.class.php');	
						$ReturnsReturnValue = $this->AvaTaxReturnInvoice($order_query, $order_products, $data, $TaxHistoryReturnValue);
						if(is_array($ReturnsReturnValue))
						{
							$this->session->data['avatax_return_error_message'] = 'Success';
							/************* Logging code snippet (optional) starts here *******************/
					// System Logger starts here:
					
					$log_mode = $this->config->get('config_avatax_log');
					
					
					if($log_mode==1){
					   
								
						$timeStamp 			= 	new DateTime();						// Create Time Stamp
						$params				=   '[Input: ' . ']';		// Create Param List
						$u_name				=	'';							// Eventually will come from $_SESSION[] object
					
					
					// Creating the System Logger Object
					$application_log 	= 	new SystemLogger;
					$connectortime = round(microtime(true) * 1000)-$time_start;
					$latency = $this->session->data['latency'];
					$connectortime= $connectortime- $latency;
					
					$application_log->metric('GetTax '.$this->session->data['getDocType'],count($this->session->data['getTaxLines']),$this->session->data['getDocCode'],$connectortime,$latency);
					
					
						$latency =""  ;
						$this->session->data['latency'] ="";							
						$this->session->data['getTaxLines'] ="";							
						$this->session->data['getDocType'] ="";							
						$this->session->data['getDocCode'] ="";

						//	$application_log->WriteSystemLogToDB();							// Log info goes to DB
						// 	System Logger ends here
						//	Logging code snippet (optional) ends here
		
				}
		
						}
						else
						{
						   $this->session->data['avatax_return_error_message'] = '<b>Avatax Error6 : </b>'.$ReturnsReturnValue;
						}
					}
					else
					{
						$this->session->data['avatax_return_error_message'] = '<b>Avatax Error7 : </b>'.$order_query->row['avatax_paytax_error_message'];
					}
				}
			}
			else
			{
				$this->session->data['previous_error_status'] = "Success";
			}
			$this->db->query("UPDATE `" . DB_PREFIX . "return` SET return_status_id = '" . (int)$data['return_status_id'] . "', date_modified = NOW() WHERE return_id = '" . (int)$return_id . "'");

			$this->db->query("INSERT INTO " . DB_PREFIX . "return_history SET return_id = '" . (int)$return_id . "', return_status_id = '" . (int)$data['return_status_id'] . "', notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");

		}
	
			
		$this->db->query("UPDATE `" . DB_PREFIX . "return` SET order_id = '" . (int)$data['order_id'] . "', product_id = '" . (int)$data['product_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', product = '" . $this->db->escape($data['product']) . "', model = '" . $this->db->escape($data['model']) . "', quantity = '" . (int)$data['quantity'] . "', opened = '" . (int)$data['opened'] . "', return_reason_id = '" . (int)$data['return_reason_id'] . "', return_action_id = '" . (int)$data['return_action_id'] . "', comment = '" . $this->db->escape($data['comment']) . "', date_ordered = '" . $this->db->escape($data['date_ordered']) . "', date_modified = NOW() WHERE return_id = '" . (int)$return_id . "'");
	}

	public function deleteReturn($return_id) {

				

				if($this->config->get('config_avatax_tax_calculation')&& $this->config->get('config_avatax_transaction_calculation'))
				{
					$avatax_return_document_code = $this->db->query("SELECT `avatax_return_document_code` FROM `" . DB_PREFIX . "return` WHERE return_id = '" . (int)$return_id . "'");
					$avatax_return_document_code = $avatax_return_document_code->row;
					$avatax_return_document_code = $avatax_return_document_code['avatax_return_document_code'];
					$cancelCode = "DocVoided";
					$CancelTaxValue = $this->AvaTaxCancelTax($avatax_return_document_code,$cancelCode);
					if($CancelTaxValue === 'Success')
					{
						$this->session->data['avatax_return_error_message'] = 'Success';
					}
					else
					{
						$this->session->data['avatax_return_error_message'] = '<b>Avatax Error : </b>'.$CancelTaxValue;
					}
				}
				
			
		$this->db->query("DELETE FROM `" . DB_PREFIX . "return` WHERE return_id = '" . (int)$return_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "return_history WHERE return_id = '" . (int)$return_id . "'");
	}

	public function getReturn($return_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = r.customer_id) AS customer FROM `" . DB_PREFIX . "return` r WHERE r.return_id = '" . (int)$return_id . "'");

		return $query->row;
	}

	public function getReturns($data = array()) {
		$sql = "SELECT *, CONCAT(r.firstname, ' ', r.lastname) AS customer, (SELECT rs.name FROM " . DB_PREFIX . "return_status rs WHERE rs.return_status_id = r.return_status_id AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status FROM `" . DB_PREFIX . "return` r";

		$implode = array();

		if (!empty($data['filter_return_id'])) {
			$implode[] = "r.return_id = '" . (int)$data['filter_return_id'] . "'";
		}

		if (!empty($data['filter_order_id'])) {
			$implode[] = "r.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$implode[] = "CONCAT(r.firstname, ' ', r.lastname) LIKE '" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_product'])) {
			$implode[] = "r.product = '" . $this->db->escape($data['filter_product']) . "'";
		}

		if (!empty($data['filter_model'])) {
			$implode[] = "r.model = '" . $this->db->escape($data['filter_model']) . "'";
		}

		if (!empty($data['filter_return_status_id'])) {
			$implode[] = "r.return_status_id = '" . (int)$data['filter_return_status_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$implode[] = "DATE(r.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'r.return_id',
			'r.order_id',
			'customer',
			'r.product',
			'r.model',
			'status',
			'r.date_added',
			'r.date_modified'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.return_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalReturns($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return`r";

		$implode = array();

		if (!empty($data['filter_return_id'])) {
			$implode[] = "r.return_id = '" . (int)$data['filter_return_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$implode[] = "CONCAT(r.firstname, ' ', r.lastname) LIKE '" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_order_id'])) {
			$implode[] = "r.order_id = '" . $this->db->escape($data['filter_order_id']) . "'";
		}

		if (!empty($data['filter_product'])) {
			$implode[] = "r.product = '" . $this->db->escape($data['filter_product']) . "'";
		}

		if (!empty($data['filter_model'])) {
			$implode[] = "r.model = '" . $this->db->escape($data['filter_model']) . "'";
		}

		if (!empty($data['filter_return_status_id'])) {
			$implode[] = "r.return_status_id = '" . (int)$data['filter_return_status_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$implode[] = "DATE(r.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalReturnsByReturnStatusId($return_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return` WHERE return_status_id = '" . (int)$return_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalReturnsByReturnReasonId($return_reason_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return` WHERE return_reason_id = '" . (int)$return_reason_id . "'");

		return $query->row['total'];
	}

	public function getTotalReturnsByReturnActionId($return_action_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return` WHERE return_action_id = '" . (int)$return_action_id . "'");

		return $query->row['total'];
	}

	public function addReturnHistory($return_id, $data) {

			if($this->config->get('config_avatax_tax_calculation')&& $this->config->get('config_avatax_transaction_calculation'))
			{
				$time_start = round(microtime(true) * 1000);
				$return_details = $this->getReturn($return_id);

				if(count($return_details) > 0)
				{
					$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int)$return_details["order_id"] . "'");
					if($order_query->row['avatax_paytax_error_message'] == 'Success')
					{
						$order_products = array();
						if ($order_query->num_rows) {
							$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product LEFT JOIN " . DB_PREFIX . "product ON(" . DB_PREFIX . "order_product.product_id=" . DB_PREFIX . "product.product_id) WHERE order_id = '" . (int)$return_details["order_id"] . "'");

							$order_products = $product_query->rows;
						}

						$data["product"] = $return_details["product"];
						$data["quantity"] = $return_details["quantity"];
						$data["return_reason_id"] = $return_details["return_reason_id"];
						$data["avatax_return_document_code"] = $return_details["avatax_return_document_code"];
						
						$connectortime = round(microtime(true) * 1000)-$time_start;
						
						if($return_details["return_status_id"] == 3){
							$cancelCode = "DocDeleted";
							$CancelTaxValue = $this->AvaTaxCancelTax($return_details["avatax_return_document_code"],$cancelCode);
							$CancelTaxValue = $this->AvaTaxCancelTax($return_details["avatax_return_document_code"],$cancelCode);
							if($CancelTaxValue === 'Success')
							{
								$this->session->data['avatax_return_error_message'] = 'Success';
							}
							else
							{
								$this->session->data['avatax_return_error_message'] = '<b>Avatax Error : </b>'.$CancelTaxValue;
							}
						}

						$TaxHistoryReturnValue = $this->AvaTaxGetTaxHistory($order_query);
						
						$time_start = round(microtime(true) * 1000);
						$time_start = $time_start + $connectortime;
						require_once(DIR_SYSTEM . 'AvaTax4PHP/classes/SystemLogger.class.php');	
						
						$ReturnsReturnValue = $this->AvaTaxReturnInvoice($order_query, $order_products, $data, $TaxHistoryReturnValue);
						if(is_array($ReturnsReturnValue))
						{
							$this->session->data['avatax_return_error_message'] = 'Success';
							
							/************* Logging code snippet (optional) starts here *******************/
							// System Logger starts here:
					
							$log_mode = $this->config->get('config_avatax_log');
					
					
							if($log_mode==1){
					   
								
							$timeStamp 			= 	new DateTime();						// Create Time Stamp
							$params				=   '[Input: ' . ']';		// Create Param List
							$u_name				=	'';							// Eventually will come from $_SESSION[] object
						
					
							// Creating the System Logger Object
							$application_log 	= 	new SystemLogger;
							$connectortime = round(microtime(true) * 1000)-$time_start;
							$latency = $this->session->data['latency'];
							$connectortime= $connectortime- $latency;
					
							$application_log->metric('GetTax '.$this->session->data['getDocType'],count($this->session->data['getTaxLines']),$this->session->data['getDocCode'],$connectortime,$latency);
					
					
							$latency =""  ;
							$this->session->data['latency'] ="";							
							$this->session->data['getTaxLines'] ="";							
							$this->session->data['getDocType'] ="";							
							$this->session->data['getDocCode'] ="";

							//	$application_log->WriteSystemLogToDB();							// Log info goes to DB
							// 	System Logger ends here
							//	Logging code snippet (optional) ends here
		
							}
		
							
						}
						else
						{
							$this->session->data['avatax_return_error_message'] = '<b>Avatax Error : </b>'.$ReturnsReturnValue;
						}
					}
					else
					{
						$this->session->data['avatax_return_error_message'] = '<b>Avatax Error : </b>'.$order_query->row['avatax_paytax_error_message'];
					}
				}
			}
			else{
				$this->session->data['previous_error_status'] = "Success";
			}
			
		$this->db->query("UPDATE `" . DB_PREFIX . "return` SET return_status_id = '" . (int)$data['return_status_id'] . "', date_modified = NOW() WHERE return_id = '" . (int)$return_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "return_history SET return_id = '" . (int)$return_id . "', return_status_id = '" . (int)$data['return_status_id'] . "', notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");

		if ($data['notify']) {
			$return_query = $this->db->query("SELECT *, rs.name AS status FROM `" . DB_PREFIX . "return` r LEFT JOIN " . DB_PREFIX . "return_status rs ON (r.return_status_id = rs.return_status_id) WHERE r.return_id = '" . (int)$return_id . "' AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "'");

			if ($return_query->num_rows) {
				$this->load->language('mail/return');

				$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'), $return_id);

				$message  = $this->language->get('text_return_id') . ' ' . $return_id . "\n";
				$message .= $this->language->get('text_date_added') . ' ' . date($this->language->get('date_format_short'), strtotime($return_query->row['date_added'])) . "\n\n";
				$message .= $this->language->get('text_return_status') . "\n";
				$message .= $return_query->row['status'] . "\n\n";

				if ($data['comment']) {
					$message .= $this->language->get('text_comment') . "\n\n";
					$message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
				}

				$message .= $this->language->get('text_footer');

				$mail = new Mail($this->config->get('config_mail'));
				$mail->setTo($return_query->row['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject($subject);
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();
			}
		}
	}

	public function getReturnHistories($return_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT rh.date_added, rs.name AS status, rh.comment, rh.notify FROM " . DB_PREFIX . "return_history rh LEFT JOIN " . DB_PREFIX . "return_status rs ON rh.return_status_id = rs.return_status_id WHERE rh.return_id = '" . (int)$return_id . "' AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY rh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalReturnHistories($return_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "return_history WHERE return_id = '" . (int)$return_id . "'");

		return $query->row['total'];
	}


			
			 /***************************************************************************
			 *   Last Updated On	:	05/14/2015			                            *
			 *   Description        :   This function returns the original price of		* 
			 *							product by product ID							*
			 ***************************************************************************/
						
			public function getProductOriginalPrice($product_id) {
				$product_price_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
				if($product_price_query->row["tax_class_id"] > 0)
				{
					$Taxcodetitle = $this->db->query("SELECT title FROM " . DB_PREFIX . "tax_class WHERE tax_class_id = '" . (int)$product_price_query->row["tax_class_id"] . "'");
					$taxcode = $Taxcodetitle->row['title'];
				}
				else
				{
					$taxcode = '';
				}
				if ($product_price_query->num_rows) {
					//$price = $product_price_query->row['price'];
					 $Product_price_taxcode = array(
						 'product_price'                => $product_price_query->row['price'],
						 'tax_class_title'              => $taxcode,
				 );
			 }
			 return $Product_price_taxcode;
		  }

		  
			/****************************************************************************
			*   Last Updated On		:	05/14/2015			                           	*
			*   Description			:  	This function fetches gettax history for the	*
			*   						sent order details								*
			****************************************************************************/
					  
			public function AvaTaxGetTaxHistory($OrderInformation) {

				$environment = 'Development';
				if($this->config->get('config_avatax_service_url')=='https://development.avalara.net')
					$environment = "Development";
				else 
					$environment = "Production";

				$order_data = array();
				$dateTime = new DateTime();
				$order_data["service_url"] = $this->config->get('config_avatax_service_url');
				$order_data["account"] = $this->config->get('config_avatax_account');
				$order_data["license"] = $this->config->get('config_avatax_license_key');
				$order_data["client"] = $this->config->get('config_avatax_client');
				$order_data["environment"] = $environment;
				$order_data["CompanyCode"] = $this->config->get('config_avatax_company_code');
				$order_data["DocType"] = "SalesInvoice";
				$order_data["DocCode"] = $OrderInformation->row['avatax_paytax_document_code'];

				include_once(DIR_SYSTEM . 'AvaTax4PHP/get_tax_history.php');
				$return_message = GetTaxHistory($order_data);

				return $return_message;
			}

			/****************************************************************************
			*   Last Updated On		:	05/14/2015			                           	*
			*   Description			:  	This function serves as the wrapper function	*
			*   						for AvaTax CancelTax() Call						*
			****************************************************************************/
									
			public function AvaTaxCancelTax($AvaTaxDocumentCode, $CancelCode) {

				$environment = 'Development';
				if($this->config->get('config_avatax_service_url')=='https://development.avalara.net')
					$environment = "Development";
				else 
					$environment = "Production";
				$order_data = array();
				$dateTime = new DateTime();
				$order_data["service_url"] = $this->config->get('config_avatax_service_url');
				$order_data["account"] = $this->config->get('config_avatax_account');
				$order_data["license"] = $this->config->get('config_avatax_license_key');
				$order_data["client"] = $this->config->get('config_avatax_client');
				$order_data["environment"] = $environment;
				$order_data["CompanyCode"] = $this->config->get('config_avatax_company_code');
				$order_data["DocType"] = "ReturnInvoice";
				$order_data["DocCode"] = $AvaTaxDocumentCode;
				$order_data["CancelCode"] = $CancelCode;

				include_once(DIR_SYSTEM . 'AvaTax4PHP/cancel_tax.php');
				$return_message = CancelTax($order_data);

				return $return_message;
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

			/****************************************************************************
			*   Last Updated On		:	05/14/2015			                           	*
			*   Description			:  	This function does tax computation on			*
			*   						sent return invoice details						*
			****************************************************************************/
						
			public function AvaTaxReturnInvoice($order_query, $products, $data, $tax_history_data) {

				if ($order_query->num_rows) {

					include_once(DIR_SYSTEM . 'AvaTax4PHP/AvaTax.php');

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

					if($order_query->row["customer_id"]>0) {
						$CustomerCode = $order_query->row["customer_id"];
					}
					else {
						$CustomerCode = $order_query->row["customer_group_id"];
					}

					$origin_country_details = $this->getCountry($this->config->get('config_country_id'));
					$origin_zone_details = $this->getZone($this->config->get('config_zone_id'));

					$OrigAddress = $this->config->get('config_address');
					$OrigCity = $this->config->get('config_city');
					$OrigRegion = $origin_zone_details["code"];
					$OrigPostalCode = $this->config->get('config_postal_code');
					$OrigCountry = $origin_country_details["iso_code_2"];

					if(!empty($order_query->row["shipping_country_id"]))
					{
						$dest_country_details = $this->getCountry($order_query->row["shipping_country_id"]);
						$dest_zone_details = $this->getZone($order_query->row["shipping_zone_id"]);

						$DestAddress = $order_query->row["shipping_address_1"];
						$DestCity = $order_query->row["shipping_city"];
						$DestRegion = $dest_zone_details["code"];
						$DestPostalCode = $order_query->row["shipping_postcode"];
						$DestCountry = $dest_country_details["iso_code_2"];
					}
					else
					{
						$dest_country_details = $this->getCountry($order_query->row["payment_country_id"]);
						$dest_zone_details = $this->getZone($order_query->row["payment_zone_id"]);

						$DestAddress = $order_query->row["payment_address_1"];
						$DestCity = $order_query->row["payment_city"];
						$DestRegion = $dest_zone_details["code"];
						$DestPostalCode = $order_query->row["payment_postcode"];
						$DestCountry = $dest_country_details["iso_code_2"];
					}

					$CompanyCode = $this->config->get('config_avatax_company_code');
					$DocType = $this->config->get('config_avatax_transaction_calculation');
					if($DocType == 1){
						$DocType = "ReturnInvoice";
					}else{
						$DocType = "ReturnOrder";
					}
					//$DocCode = $order_query->row['avatax_paytax_document_code'];
					$DocCode = $data['avatax_return_document_code'];

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

					//Return Status = Complete then Committed else Uncommitted
					if($data['return_status_id']==3) $request->setCommit(TRUE);
					else $request->setCommit(FALSE);

					//Add Origin Address
					$origin = new Address();
					$origin->setAddressCode(0);
					$origin->setLine1($OrigAddress);
					$origin->setLine2("");
					$origin->setCity($OrigCity);
					$origin->setRegion($OrigRegion);
					$origin->setPostalCode($OrigPostalCode);
					$origin->setCountry($OrigCountry);
					$request->setOriginAddress($origin);

					// Add Destination Address
					$destination = new Address();
					$destination->setAddressCode(1);
					$destination->setLine1($DestAddress);
					$destination->setLine2("");
					$destination->setCity($DestCity);
					$destination->setRegion($DestRegion);
					$destination->setPostalCode($DestPostalCode);
					$destination->setCountry($DestCountry);
					$request->setDestinationAddress($destination);

					// Line level processing
					$Ref1 = '';
					$Ref2 = '';
					$ExemptionNo = '';
					$RevAcct = '';
					$EntityUseCode = '';

					$lines = array();
					$product_total = 0;
					$i = 0;
					$discount_amount = 0;

					$avatax_discount_amount = 0;
					$TaxCode = 0;

					foreach($products as $product) {

						if(trim($data['product']) == trim($product["name"]))
						{
							$Product_detail = $this->getProductOriginalPrice($product["product_id"]);

							$total_amount = $product["price"]*$data["quantity"];
							$Description = $this->getCategories($product["product_id"]);
							//$TaxCode = substr($product["name"], 0, 24);
							if(isset($Product_detail['tax_class_title']) || $Product_detail['tax_class_title']!= null)
							{
								if($Product_detail["tax_class_title"] == 'Non Taxable')
								{
									$TaxCode = 'NT';
								}
								else
								{
									$TaxCode = $Product_detail["tax_class_title"];
								}
							}
							else
							{
								 $TaxCode = '';
							}

							//Product Discount
							$this->load->model('catalog/product');
							//$product_discount = $this->model_catalog_product->getProductDiscounts($product["product_id"]);
							$product_discount = $this->model_catalog_product->getProductDiscountsForGivenRange($product["product_id"], $product["quantity"],$order_query->row["date_added"], $order_query->row["customer_group_id"]);

							$discount_count = 0;
							$discount_amount = 0;
							foreach($product_discount as $discount) {
								$discount_amount += $discount["price"];
								$discount_count++;
							}

							$line1 = new Line();
							$line1->setNo(1);

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
							//$line1->setQty($product["quantity"]);
							$line1->setQty($data["quantity"]);
							//$line1->setAmount(-$product["total"]);
							$line1->setAmount(-$total_amount);

							$line1->setDiscounted(true);
							$line1->setRevAcct($RevAcct);
							$line1->setRef1($Ref1);
							$line1->setRef2($Ref2);
							$line1->setExemptionNo($ExemptionNo);
							$line1->setCustomerUsageType($EntityUseCode);
							$line1->setOriginAddress($origin);
							$line1->setDestinationAddress($destination);

							$lines[$i] = $line1;
							$i++;
							//if($discount_count>0) $avatax_discount_amount += (($product_original_amount - $discount_amount) * $product["quantity"]);
							if($discount_count>0) $avatax_discount_amount += (($product_original_amount - $discount_amount) * $data["quantity"]);
							$product_total += $product['quantity'];
						}
					}

					//$request->setLines(array($lines));
					$request->setLines($lines);
					$request->setDiscount('0');

					$this->load->model('localisation/return_reason');
					$return_reason = $this->model_localisation_return_reason->getReturnReason($data["return_reason_id"]);

					$TaxOverride = new TaxOverride();
					//$TaxOverride->setTaxOverrideType($tax_history_data["TaxDate"]);
					$TaxOverride->setTaxOverrideType("TaxDate");
					$TaxOverride->setTaxDate($tax_history_data["DocDate"]);
					$TaxOverride->setReason($return_reason["name"]);
					$request->setTaxOverride($TaxOverride);

					$GetTaxData = array();
					$returnMessage = "";

					try {
		
					if (!empty($DestAddress)) {
					
					//$connectortime = round(microtime(true) * 1000)-$time_start;
					$latency = round(microtime(true) * 1000);
						$getTaxResult = $client->getTax($request);
					$latency = round(microtime(true) * 1000)-$latency;
					$this->session->data['latency'] = "" ;
					$this->session->data['getTaxLines'] = "" ;
					$this->session->data['getDocType'] = "" ;
					$this->session->data['getDocCode'] = "" ;
					$this->session->data['latency'] = $latency ;
					$this->session->data['getTaxLines'] = $getTaxResult->getTaxLines() ;
					$this->session->data['getDocType'] = $getTaxResult->getDocType() ;
					$this->session->data['getDocCode'] = $getTaxResult->getDocCode();
					
						//Added for connector metrics
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
						else{}
						
						// Error Trapping
						if ($getTaxResult->getResultCode() == SeverityLevel::$Success) {

							$GetTaxData['GetTaxDocCode'] = $getTaxResult->getDocCode();
							$GetTaxData['GetTaxDocDate'] = $getTaxResult->getDocDate();
							$GetTaxData['GetTaxTotalAmount'] = $getTaxResult->getTotalAmount();
							$GetTaxData['GetTaxTotalTax'] = $getTaxResult->getTotalTax();

							return $GetTaxData;

						} else {

							foreach ($getTaxResult->getMessages() as $msg) {
								//echo $msg->getName() . ": " . $msg->getSummary() . "\n";
								$returnMessage .= $msg->getName() . ": " . $msg->getSummary() . "\n";
							}
							return $returnMessage;
						}
						} 
					}catch (SoapFault $exception) {
						$msg = "Exception: ";
						if ($exception)
							$msg .= $exception->faultstring;

							// If you desire to retrieve SOAP IN / OUT XML
							//  - Follow directions below
							//  - if not, leave as is

							//echo $msg . "\n";
							return $msg;
							//    }   //UN-comment this line to return SOAP XML
					}   //Comment this line to return SOAP XML
				}
			}
			
	public function getTotalReturnHistoriesByReturnStatusId($return_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "return_history WHERE return_status_id = '" . (int)$return_status_id . "' GROUP BY return_id");

		return $query->row['total'];
	}
}