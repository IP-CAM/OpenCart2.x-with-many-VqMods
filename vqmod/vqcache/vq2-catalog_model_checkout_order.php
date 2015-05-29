<?php
class ModelCheckoutOrder extends Model {
	public function addOrder($data) {
		$this->event->trigger('pre.order.add', $data);

		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(isset($data['payment_custom_field']) ? serialize($data['payment_custom_field']) : '') . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(isset($data['shipping_custom_field']) ? serialize($data['shipping_custom_field']) : '') . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', marketing_id = '" . (int)$data['marketing_id'] . "', tracking = '" . $this->db->escape($data['tracking']) . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");

		$order_id = $this->db->getLastId();

		// Products
		foreach ($data['products'] as $product) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");

			$order_product_id = $this->db->getLastId();

			foreach ($product['option'] as $option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
			}
		}

		// Gift Voucher
		$this->load->model('checkout/voucher');

		// Vouchers
		foreach ($data['vouchers'] as $voucher) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

			$order_voucher_id = $this->db->getLastId();

			$voucher_id = $this->model_checkout_voucher->addVoucher($order_id, $voucher);

			$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");
		}

		// Totals
		foreach ($data['totals'] as $total) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
		}

		$this->event->trigger('post.order.add', $order_id);

		return $order_id;
	}

	public function editOrder($order_id, $data) {
		
				$this->event->trigger('pre.order.edit', $data);
				if($this->config->get('config_avatax_tax_calculation'))
				{
					// Void the order first
					// $this->addOrderHistory($order_id, 0);
				}
				else
				{
					$this->addOrderHistory($order_id, 0);
				}
			




		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(serialize($data['custom_field'])) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(serialize($data['payment_custom_field'])) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(serialize($data['shipping_custom_field'])) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");

		// Products
		foreach ($data['products'] as $product) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");

			$order_product_id = $this->db->getLastId();

			foreach ($product['option'] as $option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
			}
		}

		// Gift Voucher
		$this->load->model('checkout/voucher');

		$this->model_checkout_voucher->disableVoucher($order_id);

		// Vouchers
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		foreach ($data['vouchers'] as $voucher) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

			$order_voucher_id = $this->db->getLastId();

			$voucher_id = $this->model_checkout_voucher->addVoucher($order_id, $voucher);

			$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");

		}

		// Totals
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");

		foreach ($data['totals'] as $total) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
		}

		$this->event->trigger('post.order.edit', $order_id);
	}


	public function getAvaTaxDocumentStatus() {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status");

		$avatax_document_status = array();
		foreach($query->rows as $row)
		{
			$avatax_document_status[$row["order_status_id"]] = $row["avatax_document_status"];
		}
		return $avatax_document_status;
	}

	public function DocumentStateVoided($order_query, $new_product_list)
	{
		$time_start = round(microtime(true) * 1000);
		
		//$AvaTaxDocumentStatus = array(1=>"Uncommitted", 2=>"Uncommitted", 3=>"Committed", 5=>"Committed", 7=>"Voided", 8=>"Voided", 9=>"Voided", 10=>"Voided", 11=>"Voided", 12=>"Voided", 13=>"Voided", 14=>"Voided", 15=>"Committed", 16=>"Voided");
		$AvaTaxDocumentStatus = $this->getAvaTaxDocumentStatus();

		if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Committed")
		{
			$connectortime = round(microtime(true) * 1000)-$time_start;
			//1. Call CancelTax with CancelCode = DocVoided
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocVoided");
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocDeleted");
			
			$time_start = round(microtime(true) * 1000);
			$time_start = $time_start + $connectortime;	
			//2. Call GetTax with Commit = False
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 0);
			
			$connectortime = round(microtime(true) * 1000)-$time_start;
			//3. Call CancelTax with CancelCode = DocVoided
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocVoided");
			
		}
		else if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Voided")
		{
			$connectortime = round(microtime(true) * 1000)-$time_start;
			//1. Call CancelTax with CancelCode = DocDeleted
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocDeleted");
			
			$time_start = round(microtime(true) * 1000);
			$time_start = $time_start + $connectortime;	
			//2. Call GetTax with Commit = False
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 0);

			$connectortime = round(microtime(true) * 1000)-$time_start;
			//3. Call CancelTax with CancelCode = DocVoided
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocVoided");
			
		}
		else if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Uncommitted")
		{
			$connectortime = round(microtime(true) * 1000)-$time_start;
			//1. Call CancelTax with CancelCode = DocVoided
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocVoided");
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocDeleted");
			
			$time_start = round(microtime(true) * 1000);
			$time_start = $time_start + $connectortime;
			//2. Call GetTax with Commit = False
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 0);

			$connectortime = round(microtime(true) * 1000)-$time_start;
			//3. Call CancelTax with CancelCode = DocVoided
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocVoided");
			
		}
		 if(is_array($DocCommittedReturn))
		{
		
		
		/************* Logging code snippet (optional) starts here *******************/
					// System Logger starts here:
					
					$log_mode = $this->config->get('config_avatax_log');
					
					
					if($log_mode==1){
					   
								
						$timeStamp 			= 	new DateTime();						// Create Time Stamp
						$params				=   '[Input: ' . ']';		// Create Param List
						$u_name				=	'';							// Eventually will come from $_SESSION[] object
					
					
					// Creating the System Logger Object
					$application_log 	= 	new SystemLogger;
					//$connectortime = round(microtime(true) * 1000)-$time_start;
					$latency = $this->session->data['latency'];
					$connectortime = $connectortime - $latency;
					
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
	}

	public function DocumentStateUncommitted($order_query, $new_product_list){

		$time_start = round(microtime(true) * 1000);
		$AvaTaxDocumentStatus = $this->getAvaTaxDocumentStatus();

		if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Committed")
		{
			$connectortime = round(microtime(true) * 1000)-$time_start;
			//1. Call CancelTax with CancelCode = Voided
			$DocVoidedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocVoided");
			//2. Call CancelTax with CancelCode = DocDeleted
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocDeleted");
			
			$time_start = round(microtime(true) * 1000);
			$time_start = $time_start + $connectortime;				
			//3. Call GetTax with Commit = False
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 0);
		}
		else if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Voided")
		{
			$connectortime = round(microtime(true) * 1000)-$time_start;
			//1. Call CancelTax with CancelCode = DocDeleted
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocDeleted");
			
			$time_start = round(microtime(true) * 1000);
			$time_start = $time_start + $connectortime;	
			//2. Call GetTax with Commit = False
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 0);
		}
		else if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Uncommitted")
		{
			//1. Call GetTax with Commit = False
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 0);
		}
		 if(is_array($DocCommittedReturn))
		{
			$this->updateOrderForAvaTaxFields(0, 0, $DocCommittedReturn["GetTaxDocCode"], "Success", $order_query->row['order_id']);
			
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
					$connectortime = $connectortime - $latency;
					
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
			$this->updateOrderForAvaTaxFields(0, 0, 0, $DocCommittedReturn, $order_query->row['order_id']);
		}
	}

	public function DocumentStateCommitted($order_query, $new_product_list){
		$time_start = round(microtime(true) * 1000);
		$AvaTaxDocumentStatus = $this->getAvaTaxDocumentStatus();

		if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Committed")
		{
			$connectortime = round(microtime(true) * 1000)-$time_start;
			//1. Call CancelTax with CancelCode = Voided
			$DocVoidedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocVoided");
			//2. Call CancelTax with CancelCode = DocDeleted
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocDeleted");
			//3. Call GetTax with Commit = False
			
			$time_start = round(microtime(true) * 1000);
			$time_start = $time_start + $connectortime;
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 1);
		}
		else if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Voided")
		{
			$connectortime = round(microtime(true) * 1000)-$time_start;
			//1. Call CancelTax with CancelCode = DocDeleted
			$DocDeletedReturn = $this->AvaTaxCancelTax($order_query->row["avatax_paytax_document_code"], "DocDeleted");
			
			$time_start = round(microtime(true) * 1000);
			$time_start = $time_start + $connectortime;
			//2. Call GetTax with Commit = False
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 1);
		}
		else if(trim($AvaTaxDocumentStatus[$order_query->row["order_status_id"]])=="Uncommitted")
		{
			//1. Call GetTax with Commit = True
			$DocCommittedReturn = $this->AvaTaxGetTax($order_query, $new_product_list, 1);
		}
		 if(is_array($DocCommittedReturn))
		{
			$this->updateOrderForAvaTaxFields(0, 0, $DocCommittedReturn["GetTaxDocCode"], "Success", $order_query->row['order_id']);
			
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
					$connectortime = $connectortime - $latency;
					
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
			$this->updateOrderForAvaTaxFields(0, 0, 0, $DocCommittedReturn, $order_query->row['order_id']);
		}
	}

		public function AvaTaxChangeDocumentStatus($order_query, $data, $new_product_list) {
			if($this->config->get('config_avatax_transaction_calculation')) {
				Switch($data["order_status_id"]) {
				case 0:
					break;
				case 1://Pending
					$this->DocumentStateUncommitted($order_query, $new_product_list);
					break;
				case 2://Processing
					$this->DocumentStateUncommitted($order_query, $new_product_list);
					break;
				case 3://Shipped
					$this->DocumentStateCommitted($order_query, $new_product_list);
					break;
				case 5://Complete
					$this->DocumentStateCommitted($order_query, $new_product_list);
					break;
				case 7://Cancelled
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				case 8://Denied
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				case 9://Canceled Reversal
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				case 10://Failed
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				case 11://Refunded
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				case 12://Reversed
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				case 13://Chargeback
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				case 14://Expired
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				case 15://Processed
					$this->DocumentStateCommitted($order_query, $new_product_list);
					break;
				case 16://Voided
					$this->DocumentStateVoided($order_query, $new_product_list);
					break;
				default://Default
					$this->DocumentStateCommitted($order_query, $new_product_list);
					break;
				}
			}
			else{
				$this->session->data['previous_error_status'] = "Success";
			}
		}

	public function AvaTaxGetTax($order_info, $products, $commit_status) {
		
		
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

		//Variable Mapping

		if($order_info->row["customer_id"]>0) {
			$CustomerCode = $order_info->row["customer_id"];
		}
		else {
			$CustomerCode = $order_info->row["customer_group_id"];
		}

		//$this->load->model('localisation/country');

		//$this->load->model('localisation/zone');

		//$country_details = $this->model_localisation_country->getCountry($data['shipping_country_id']);
		//$zone_details = $this->model_localisation_zone->getZone($this->config->get('config_zone_id'));

		$country_details = $this->getCountry($this->config->get('config_country_id'));
		$zone_details = $this->getZone($this->config->get('config_zone_id'));

		$OrigAddress = $this->config->get('config_address');
		$OrigCity = $this->config->get('config_city');
		$OrigRegion = $zone_details["code"];
		$OrigPostalCode = $this->config->get('config_postal_code');
		$OrigCountry = $country_details["iso_code_2"];

			if(isset($this->request->request["shipping_address_1"]))
			{
			$dest_country_details =  $this->getCountry($this->request->request["shipping_country_id"]);
			$dest_zone_details = $this->getZone($this->request->request["shipping_zone_id"]);

			$DestAddress = $this->request->request["shipping_address_1"];
			$DestCity =$this->request->request["shipping_city"];
			$DestPostalCode = $this->request->request["shipping_postcode"];
			$DestRegion = $dest_zone_details["code"];
			$DestCountry = $dest_country_details["iso_code_2"];
		}
		else{
		
		
		if(isset($order_info->row["shipping_address_1"]) && $order_info->row["shipping_address_1"]!="")
		{
	
			$DestAddress = $order_info->row["shipping_address_1"];
			$DestCity = $order_info->row["shipping_city"];
			$DestPostalCode = $order_info->row["shipping_postcode"];
			$DestRegion = $order_info->row["shipping_zone"];
			$DestCountry = $order_info->row["shipping_country"];
		}
			else
			{
			
			if(isset($this->request->request["payment_address_1"]))
			{
			
			$dest_country_details =  $this->getCountry($this->request->request["payment_country_id"]);
			$dest_zone_details = $this->getZone($this->request->request["payment_zone_id"]);

			$DestAddress = $this->request->request["payment_address_1"];
			$DestCity =$this->request->request["payment_city"];
			$DestPostalCode = $this->request->request["payment_postcode"];
			$DestRegion = $dest_zone_details["code"];
			$DestCountry = $dest_country_details["iso_code_2"];
		}
		else{
	
			$DestAddress = $order_info->row["payment_address_1"];
			$DestCity = $order_info->row["payment_city"];
			$DestPostalCode = $order_info->row["payment_postcode"];
			$DestRegion = $order_info->row["payment_zone"];
			$DestCountry = $order_info->row["payment_country"];
		}
			}
		}
		

	//	$dest_country_details =  $this->getCountry($this->request->request["shipping_country_id"]);
	//    $dest_zone_details = $this->getZone($this->request->request["shipping_zone_id"]);

	//    $DestAddress = $this->request->request["shipping_address_1"];
	 //   $DestCity =$this->request->request["shipping_city"];
	 //   $DestRegion = $dest_zone_details["code"];
	 //   $DestPostalCode = $this->request->request["shipping_postcode"];
	  //  $DestCountry = $dest_country_details["iso_code_2"];

		$CompanyCode = $this->config->get('config_avatax_company_code');
		$DocType = $this->config->get('config_avatax_transaction_calculation');
		if($DocType == 1){
			$DocType = "SalesInvoice";
		}else{
			$DocType = "SalesOrder";
		}
		//$DocType = "Any";
		$DocCode = $order_info->row['order_id'];
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
		//$request->setCommit(FALSE);
		if($commit_status == 0) $request->setCommit(FALSE);
		else $request->setCommit(TRUE);

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

		//
		// Line level processing
		$Ref1 = '';
		$Ref2 = '';
		$ExemptionNo = '';
		$RevAcct = '';
		$EntityUseCode = '';

		$lines = array();
		$product_total = 0;
		$ordertotal = 0;
		$i = 0;
		$status = false;

		//Shipping Line Item
		// Order Totals
		$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_info->row['order_id'] . "' ORDER BY sort_order ASC");

		$shipping_count = 0;

		//Added for discount/Coupon on 05/05/2015
		foreach ($order_total_query->rows as $order_total) {
			if($order_total['code']=="coupon") {
				$Discount = abs($order_total['value']);
				$coupon_code = $order_total['title'];
				$coupon_code = substr($coupon_code,8,-1);

				$coupon_id_res = $this->db->query("SELECT coupon_id FROM `" . DB_PREFIX . "coupon` WHERE code = '" . $coupon_code . "'");
				if($coupon_id_res->num_rows != 0){
					$coupon_id = $coupon_id_res->row['coupon_id'];
					//echo "<br>Code: ".$coupon_code." Dis: ".$Discount." Coupon Id: ".$coupon_id;
					$coupon_info_obj = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "coupon WHERE coupon_id = '" . (int)$coupon_id . "'");
					$coupon_info = $coupon_info_obj->row;
				
					$coupon_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon_product WHERE coupon_id = '" . (int)$coupon_id . "'");

					foreach ($coupon_product_query->rows as $result) {
						$coupon_product_data[] = $result['product_id'];
					}
				}
			}
		}
	
		foreach ($order_total_query->rows as $order_total) {
			if($order_total['code']=="shipping") {
				$code = $order_info->row['shipping_code'];
				$shipping_method = $this->config->get(substr($code,strpos($code, '.')+1,strlen($code)).'_tax_class_id');
				if(isset($shipping_method) && $shipping_method > 0)
				{
				   $TaxClasses = $this->db->query("SELECT title FROM " . DB_PREFIX . "tax_class  WHERE tax_class_id ='" . $shipping_method . "'");
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
				$line1->setItemCode($order_total['code']);
				$line1->setDescription($order_total['title']);
				$line1->setTaxCode($TaxCode);
				$line1->setQty(1);

				//Added for coupon/discount on 05/05/2015
				//If Coupon is applied & free shipping is enabled, we'll pass 0 to free shipping 
				$cost = $order_total['value'];
				//exit;
				if(isset($coupon_info) && !empty($coupon_info))
				{
					if($coupon_info['shipping'])
					{
						$Discount = $Discount - $cost;
						$cost = 0;
					}
				}
				
				$line1->setAmount($cost);
			
				//$line1->setAmount($order_total['value']);
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
				$shipping_count++;
			}

			if($order_total['code']=="handling") {
				$hadling_total = $this->config->get('handling_total');
				$hadling_tax_class_id = $this->config->get('handling_tax_class_id');
				$hadling_fee = $this->config->get('handling_fee');

				//Added Handling Status in if condition by Vijay Nalawade on 13 Jan 2015. To check if Handling Fee status is enabled or not
				$handling_status = $this->config->get('handling_status');

				if(($ordertotal <= $hadling_total) && ($handling_status==1))
				{
					if($hadling_tax_class_id > 0){
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
					else{
						//$TaxCode = 'HNLD';
						$TaxCode = '';
					}
				}
				//$TaxCode = $product["tax_class_id"];
				$line1 = new Line();
				$line1->setNo($i+1);
				$line1->setItemCode($order_total['code']);
				$line1->setDescription($order_total['title']);
				//$line1->setTaxCode($TaxCode);
				$line1->setQty(1);
				$line1->setAmount($order_total['value']);
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

		$avatax_discount_amount = 0;
		$TaxCode = 0;

		$lineCount = count($products);
		foreach ($products as $product) {
			//$product_original_amount = $this->getProductOriginalPrice($product["product_id"]);
			$Product_detail = $this->getProductOriginalPrice($product["product_id"]);
			//$product_original_amount = $Product_detail['product_price'];
			//$total_amount = ($product_original_amount * $product["quantity"]);
			$total_amount = $product["total"];
			$Description = $this->getCategories($product["product_id"]);
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
			$product_discount = $this->model_catalog_product->getProductDiscountsForGivenRange($product["product_id"], $product["quantity"], $order_info->row["date_added"], $order_info->row["customer_group_id"]);

			$discount_count = 0;
			$discount_amount = 0;
			foreach($product_discount as $discount) {
				$discount_amount += $discount["price"];
				$discount_count++;
			}

			$line1 = new Line();
			//$line1->setNo($i+1);//$product["product_id"]
			$line1->setNo($product["product_id"]);

			//UPC Code Added by Vijay as on 3rd Dec 2014. If enabled, UPC code will be passed instead of Model number
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
			//$line1->setAmount($product["price"]);
			//$line1->setAmount($product["total"]);
			$line1->setAmount($total_amount);
			
			//Added to handle coupon scenario regarding multiple products or order
			if(isset($coupon_id) && ($coupon_id<>""))
			{
				if (!isset($coupon_product_data)) 
				{
					$status = true;
				}
				else 
				{
					if (in_array($product['product_id'], $coupon_product_data)) {
						$status = true;
					} else {
						$status = false;
					}
				}
			}
			
			//echo "\nStatus: ".$status;
			//exit;
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
			$ordertotal += $total_amount;
			$product_total += $product['quantity'];
		}

		//$request->setLines(array($lines));
		$request->setLines($lines);
		$request->setDiscount($Discount);

		$GetTaxData = array();
		$returnMessage = "";

		

		try {
		
		if (!empty($DestAddress)) {
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

			// Error Trapping
			if ($getTaxResult->getResultCode() == SeverityLevel::$Success) {

				$GetTaxData['GetTaxDocCode'] = $getTaxResult->getDocCode();
				$GetTaxData['GetTaxDocDate'] = $getTaxResult->getDocDate();
				$GetTaxData['GetTaxTotalAmount'] = $getTaxResult->getTotalAmount();
				$GetTaxData['GetTaxTotalTax'] = $getTaxResult->getTotalTax();
				$this->session->data['previous_error_status'] = "Success";
				//return $getTaxResult->getTotalTax();

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
				
				return $GetTaxData;

			} else {

				/*foreach ($getTaxResult->getMessages() as $msg) {
					//echo $msg->getName() . ": " . $msg->getSummary() . "\n";
					$returnMessage .= $msg->getName() . ": " . $msg->getSummary() . "\n";
					$this->session->data['previous_error_status'] = '<b>' ."AvaTax Error :" . '</b>' . $returnMessage;
				}*/
				$msg = $getTaxResult->getMessages();
				$returnMessage .= $msg[0]->getName() . ": " . $msg[0]->getSummary() . "\n";
				$this->session->data['previous_error_status'] = '<b>' ."AvaTax Error :" . '</b>' . $returnMessage;
				return $returnMessage;
			}
			}
		} catch (SoapFault $exception) {
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
			
	public function deleteOrder($order_id) {
		
				$this->event->trigger('pre.order.delete', $order_id);
				if($this->config->get('config_avatax_tax_calculation'))
				{
					//$order_query_delete = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int)$order_id . "'");

					$this->addOrderHistory($order_id, 7);
				}
				else
				{
					$this->addOrderHistory($order_id, 0);
				}
			




		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_option` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_history` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_fraud` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE `or`, ort FROM `" . DB_PREFIX . "order_recurring` `or`, `" . DB_PREFIX . "order_recurring_transaction` `ort` WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "affiliate_transaction` WHERE order_id = '" . (int)$order_id . "'");

		// Gift Voucher
		$this->load->model('checkout/voucher');

		$this->model_checkout_voucher->disableVoucher($order_id);

		$this->event->trigger('post.order.delete', $order_id);
	}


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
				$order_data["DocType"] = "SalesInvoice";				
				//$order_data["DocCode"] = $OrderInformation->row['avatax_paytax_document_code'];
				$order_data["DocCode"] = $AvaTaxDocumentCode;
				//$order_data["CancelCode"] = "DocDeleted";
				$order_data["CancelCode"] = $CancelCode;

				include_once(DIR_SYSTEM . 'AvaTax4PHP/cancel_tax.php');				
				$return_message = CancelTax($order_data);
				
				return $return_message;
			}			
			
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
				$language_filename = $language_info['filename'];
				$language_directory = $language_info['directory'];
			} else {
				$language_code = '';
				$language_filename = '';
				$language_directory = '';
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'custom_field'            => unserialize($order_query->row['custom_field']),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => unserialize($order_query->row['payment_custom_field']),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => unserialize($order_query->row['shipping_custom_field']),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'language_filename'       => $language_filename,
				'language_directory'      => $language_directory,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added']
			);
		} else {
			return false;
		}
	}



			public function updateOrderForAvaTaxFields($avatax_document_id, $avatax_transaction_id, $avatax_document_code, $avatax_error_message, $order_id) {
				$this->db->query("UPDATE `" . DB_PREFIX . "order` SET avatax_paytax_document_id = '" . (int)$avatax_document_id . "', avatax_paytax_transaction_id = '" . (int)$avatax_transaction_id . "', avatax_paytax_document_code = '" . (int)$avatax_document_code . "', avatax_paytax_error_message = '".$this->db->escape($avatax_error_message)."' WHERE order_id = '" . (int)$order_id . "'");
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
		//$product_categories = substr($product_categories, 0, (strlen($product_categories) - 2));
		//$product_categories = substr($product_categories, 0, 24);
		return $product_categories;
	}

	 //Removed older getProductOriginalPrice function. Replaced with admin function
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

	public function AvaTaxGetTaxOrder($order_info, $products) {
		
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

		//Variable Mapping
		if ($this->customer->isLogged()) {
			$customer_address = $this->customer->getAddress($this->customer->getAddressId());
			$CustomerCode = $customer_address["customer_id"];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');

			//$CustomerCode = $this->config->get('config_account_id');
			$CustomerCode = $this->config->get('config_customer_group_id');
		}

		$country_details = $this->getCountry($this->config->get('config_country_id'));
		$zone_details = $this->getZone($this->config->get('config_zone_id'));

		$OrigAddress = $this->config->get('config_address');
		$OrigCity = $this->config->get('config_city');
		$OrigRegion = $zone_details["code"];
		$OrigPostalCode = $this->config->get('config_postal_code');
		$OrigCountry = $country_details["iso_code_2"];

		if(!empty($order_info["shipping_address_1"]))
		{
	
			$DestAddress = $order_info["shipping_address_1"];
			$DestCity = $order_info["shipping_city"];
			$DestRegion = $order_info["shipping_zone_code"];
			$DestPostalCode = $order_info["shipping_postcode"];
			$DestCountry = $order_info["shipping_iso_code_2"];
		}
		else
		{
	
			$DestAddress = $order_info["payment_address_1"];
			$DestCity = $order_info["payment_city"];
			$DestRegion = $order_info["payment_zone_code"];
			$DestPostalCode = $order_info["payment_postcode"];
			$DestCountry = $order_info["payment_iso_code_2"];
		}

		$CompanyCode = $this->config->get('config_avatax_company_code');
		$DocType = $this->config->get('config_avatax_transaction_calculation');
		if($DocType == 1){
			$DocType = "SalesInvoice";
		}else{
			$DocType = "SalesOrder";
		}
		$DocCode = $order_info['order_id'];
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
		$request->setPurchaseOrderNo($PurchaseOrderNo);
		$request->setExemptionNo($ExemptionNo);
		$request->setDetailLevel(DetailLevel::$Tax);
		$request->setLocationCode($LocationCode);
		//$request->setCommit(FALSE);

		//Code for paypal status
		if(isset($order_info["order_status_id"]) && $order_info["order_status_id"]==5 )
			$request->setCommit(TRUE);
		else 
			$request->setCommit(FALSE);

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
		$ordertotal = 0 ;
		$status = false;

		$avatax_discount_amount = 0;
		$TaxCode = 0;

		$lineCount = count($products);
		foreach ($products as $product) {

			$total_amount = $product["total"];

			$Description = $this->getCategories($product["product_id"]);
			//$TaxCode = substr($product["name"], 0, 24);
			if(isset($product["tax_class_id"]) && $product["tax_class_id"] > 0)
			{
				if($product["tax_class_title"] == 'Non Taxable')
				{
					$TaxCode = 'NT';	//Used to post product on amdin console.
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

			//Product Discount
			$this->load->model('catalog/product');
			//$product_discount = $this->model_catalog_product->getProductDiscounts($product["product_id"]);
			$product_discount = $this->model_catalog_product->getProductDiscountsForGivenRange($product["product_id"], $product["quantity"], date_format($dateTime, "Y-m-d"));

			$discount_count = 0;
			$discount_amount = 0;
			foreach($product_discount as $discount) {
				$discount_amount += $discount["price"];
				$discount_count++;
			}

			$line1 = new Line();
			//$line1->setNo($i+1);//$product["product_id"]
			$line1->setNo($product["product_id"]);

			//UPC Code Added by Vijay as on 3rd Dec 2014. If enabled, UPC code will be passed instead of Model number
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
			//$line1->setAmount($product["price"]);
			//$line1->setAmount($product["total"]);
			$line1->setAmount($total_amount);
			//if($discount_count>0) $line1->setDiscounted(true);
			//else $line1->setDiscounted(false);

			//Added by Tushar coupon_info
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
			$ordertotal += $total_amount;
			if($discount_count>0) $avatax_discount_amount += (($product_original_amount - $discount_amount) * $product["quantity"]);
			$product_total += $product['quantity'];
		}

		//Shipping Line Item
		// Order Totals
		$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_info['order_id'] . "' ORDER BY sort_order ASC");

		$shipping_count = 0;

		foreach ($order_total_query->rows as $order_total) {
			if($order_total['code']=="coupon") {
				$Discount = abs($order_total['value']);
			}
		}
	
		foreach ($order_total_query->rows as $order_total) {
			if($order_total['code']=="shipping") {
				if(isset($this->session->data['shipping_method']))
				{
				$shipping_method = $this->session->data['shipping_method'];
				if(isset($shipping_method["tax_class_id"]))
				{
					if($shipping_method["tax_class_id"] > 0){
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
					else{
					   // $TaxCode = 'FR';
					   $TaxCode = '';
					}
				}
				}
				//$TaxCode = $product["tax_class_id"];
				$line1 = new Line();
				$line1->setNo($i+1);
				$line1->setItemCode($order_total['code']);
				$line1->setDescription($order_total['title']);
				$line1->setTaxCode($TaxCode);
				$line1->setQty(1);

				//If Coupon is applied & free shipping is enabled, we'll pass 0 to free shipping - 
				$cost = $order_total['value'];
				if(isset($this->session->data['coupon_info']) && !empty($this->session->data['coupon_info']))
				{
					$coupon_info = $this->session->data['coupon_info'];
					if($coupon_info['shipping'])
					{
						$Discount = $Discount - $cost;
						$cost = 0;
					}
				}
				$line1->setAmount($cost);
				
				$status = false;
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
				$shipping_count++;
			}
			if($order_total['code']=="handling") {
				$hadling_total = $this->config->get('handling_total');
				$hadling_tax_class_id = $this->config->get('handling_tax_class_id');
				$hadling_fee = $this->config->get('handling_fee');
				//echo "<br>Hadling 2: ".$hadling_fee;

				//Added Handling Status in if condition by Vijay Nalawade on 13 Jan 2015. To check if Handling Fee status is enabled or not
				$handling_status = $this->config->get('handling_status');

				if($handling_status==1)
				{
					if($ordertotal <= $hadling_total)
					{
						if($hadling_tax_class_id > 0){
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
						else{
							//$TaxCode = 'HNLD';
							$TaxCode = '';
						}
					}
				}
				//$TaxCode = $product["tax_class_id"];
				$line1 = new Line();
				$line1->setNo($i+1);
				$line1->setItemCode($order_total['code']);
				$line1->setDescription($order_total['title']);
				//$line1->setTaxCode($TaxCode);
				$line1->setQty(1);
				$line1->setAmount($order_total['value']);
				
				$status = false;
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
			}
		}

		//$request->setLines(array($lines));
		$request->setLines($lines);
		$request->setDiscount($Discount);

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
		
			
			// Error Trapping
			if ($getTaxResult->getResultCode() == SeverityLevel::$Success) {

				$GetTaxData['GetTaxDocCode'] = $getTaxResult->getDocCode();
				$GetTaxData['GetTaxDocDate'] = $getTaxResult->getDocDate();
				$GetTaxData['GetTaxTotalAmount'] = $getTaxResult->getTotalAmount();
				$GetTaxData['GetTaxTotalTax'] = $getTaxResult->getTotalTax();

				

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
			
				
				return $GetTaxData;

			} else {

				foreach ($getTaxResult->getMessages() as $msg) {
					//echo $msg->getName() . ": " . $msg->getSummary() . "\n";
					$returnMessage .= $msg->getName() . ": " . $msg->getSummary() . "\n";
				}
				return $returnMessage;
			}
			}
		} catch (SoapFault $exception) {
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

			public function AvaTaxPostTax($GetTaxReturnValue) {

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

				$order_data["DocCode"] = $GetTaxReturnValue['GetTaxDocCode'];
				$order_data["DocDate"] = $GetTaxReturnValue['GetTaxDocDate'];


				$order_data["TotalAmount"] = $GetTaxReturnValue['GetTaxTotalAmount'];
				$order_data["TotalTax"] = $GetTaxReturnValue['GetTaxTotalTax'];
				$order_data["Commit"] = 1;

				include_once(DIR_SYSTEM . 'AvaTax4PHP/post_tax.php');
				$return_message = PostTax($order_data);
				return $return_message;
			}

			
	public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = false) {

			if($this->config->get('config_avatax_tax_calculation')&& $this->config->get('config_avatax_transaction_calculation'))
			{
				$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int)$order_id . "'");

				//Added Left join by Vijay on 11 Dec 2014 to fetch UPC & SKU details
				if ($order_query->num_rows) {
					$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product LEFT JOIN " . DB_PREFIX . "product ON(" . DB_PREFIX . "order_product.product_id=" . DB_PREFIX . "product.product_id)   WHERE order_id = '" . (int)$order_id . "'");

					//$existing_product_list = $product_query->rows;
					//$new_product_list = $data['order_product'];
					$new_product_list = $product_query->rows;
				}
				$data['order_status_id'] = $order_status_id;
				
				//echo "order: ".$order_query." Data: ".$data." Existing: ".$existing_product_list." New: ".$new_product_list;
				if(isset($new_product_list))
				{
					$this->AvaTaxChangeDocumentStatus($order_query, $data, $new_product_list);
				}
			}
			else{
				$this->session->data['previous_error_status'] = "Success";
			}
			
		$this->event->trigger('pre.order.history.add', $order_id);

		$order_info = $this->getOrder($order_id);

		if ($order_info) {
			// Fraud Detection
			$this->load->model('account/customer');

			$customer_info = $this->model_account_customer->getCustomer($order_info['customer_id']);

			if ($customer_info && $customer_info['safe']) {
				$safe = true;
			} else {
				$safe = false;
			}

			if ($this->config->get('config_fraud_detection')) {
				$this->load->model('checkout/fraud');

				$risk_score = $this->model_checkout_fraud->getFraudScore($order_info);

				if (!$safe && $risk_score > $this->config->get('config_fraud_score')) {
					$order_status_id = $this->config->get('config_fraud_status_id');
				}
			}

			// Ban IP
			if (!$safe) {
				$status = false;

				if ($order_info['customer_id']) {
					$results = $this->model_account_customer->getIps($order_info['customer_id']);

					foreach ($results as $result) {
						if ($this->model_account_customer->isBanIp($result['ip'])) {
							$status = true;

							break;
						}
					}
				} else {
					$status = $this->model_account_customer->isBanIp($order_info['ip']);
				}

				if ($status) {
					$order_status_id = $this->config->get('config_order_status_id');
				}
			}

			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

			// If current order status is not processing or complete but new status is processing or complete then commence completing the order
			if (!in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) || in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Stock subtraction
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_product_query->rows as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Redeem coupon, vouchers and reward points
				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $order_total) {
					$this->load->model('total/' . $order_total['code']);

					if (method_exists($this->{'model_total_' . $order_total['code']}, 'confirm')) {
						$this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
					}
				}

				// Add commission if sale is linked to affiliate referral.
				if ($order_info['affiliate_id'] && $this->config->get('config_affiliate_auto')) {
					$this->load->model('affiliate/affiliate');

					$this->model_affiliate_affiliate->addTransaction($order_info['affiliate_id'], $order_info['commission'], $order_id);
				}
			}

			// If old order status is the processing or complete status but new status is not then commence restock, and remove coupon, voucher and reward history
			if (in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && !in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Restock
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach($product_query->rows as $product) {
					$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

					$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

					foreach ($option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Remove coupon, vouchers and reward points history
				$this->load->model('account/order');

				$order_totals = $this->model_account_order->getOrderTotals($order_id);

				foreach ($order_totals as $order_total) {
					$this->load->model('total/' . $order_total['code']);

					if (method_exists($this->{'model_total_' . $order_total['code']}, 'unconfirm')) {
						$this->{'model_total_' . $order_total['code']}->unconfirm($order_id);
					}
				}

				// Remove commission if sale is linked to affiliate referral.
				if ($order_info['affiliate_id']) {
					$this->load->model('affiliate/affiliate');

					$this->model_affiliate_affiliate->deleteTransaction($order_id);
				}
			}


			$avatax_tax_country = "";
			if(trim($this->config->get('config_avatax_validate_address_in'))=="both")
			{
				$avatax_tax_country = "|US|CA|";
			}
			else
			{
				$avatax_tax_country = "|".$this->config->get('config_avatax_validate_address_in')."|";
			}
				$avatax_tax_country_pos = strpos($avatax_tax_country, "|".$order_info["shipping_iso_code_2"]."|");

			//if($this->config->get('config_avatax_tax_calculation') && ($avatax_tax_country_pos !== false))
			if($this->config->get('config_avatax_tax_calculation'))
			{
				$time_start = round(microtime(true) * 1000);
				//Call 2 Methods
				//1. GetTax with OrderType = SalesInvoice
				$products = $this->cart->getProducts();
				
				//added for paypal checkout
				if($order_status_id!=0)
				{
					$order_info["order_status_id"]=$order_status_id;
				}

				$checkEmpty = array_filter($products);
				if (!empty($checkEmpty)) 
				{
					require_once(DIR_SYSTEM . 'AvaTax4PHP/classes/SystemLogger.class.php');	

					

					$GetTaxReturnValue = $this->AvaTaxGetTaxOrder($order_info, $products);


					//3. Get the Document Id from PostTax Return Value and update it in the Order Table
					//Commented below line as on 3rd Dec 2014 as mysql_query will not be executed in below line.
					//$query_avatax = mysql_query("SELECT avatax_paytax_document_id FROM `" . DB_PREFIX . "order`");

					$result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'avatax_paytax_document_id'");
					if($result->num_rows == 0){
						$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `avatax_paytax_document_id` INT NOT NULL DEFAULT '0', ADD `avatax_paytax_transaction_id` INT NOT NULL DEFAULT '0', ADD `avatax_paytax_document_code` VARCHAR( 40 ) NOT NULL, ADD `avatax_paytax_error_message` TEXT NOT NULL");
					}

					//2. PostTax with GUID
					//5. Completed, 15. Processed, 3. Shipped


						if(is_array($GetTaxReturnValue))
						{
							$this->updateOrderForAvaTaxFields(0, 0, $GetTaxReturnValue["GetTaxDocCode"], "Success", $order_id);
						
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
					
					$application_log->metric('GetTax123 '.$this->session->data['getDocType'],count($this->session->data['getTaxLines']),$this->session->data['getDocCode'],$connectortime,$latency);
					
					
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
							if(strpos($GetTaxReturnValue,"urisdictionNotFoundError:"))
							{
								$this->updateOrderForAvaTaxFields(0, 0, 0, $GetTaxReturnValue, $order_id);
							}

						}
					//}
				}
			}
			
			$this->cache->delete('product');

			// If order status is 0 then becomes greater than 0 send main html email
			if (!$order_info['order_status_id'] && $order_status_id) {
				// Check for any downloadable products
				$download_status = false;

				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_product_query->rows as $order_product) {
					// Check if there are any linked downloads
					$product_download_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_download` WHERE product_id = '" . (int)$order_product['product_id'] . "'");

					if ($product_download_query->row['total']) {
						$download_status = true;
					}
				}

				// Load the language for any mails that might be required to be sent out
				$language = new Language($order_info['language_directory']);
				$language->load($order_info['language_filename']);
				$language->load('mail/order');

				$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

				if ($order_status_query->num_rows) {
					$order_status = $order_status_query->row['name'];
				} else {
					$order_status = '';
				}

				$subject = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);

				// HTML Mail
				$data = array();

				$data['title'] = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

				$data['text_greeting'] = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
				$data['text_link'] = $language->get('text_new_link');
				$data['text_download'] = $language->get('text_new_download');
				$data['text_order_detail'] = $language->get('text_new_order_detail');
				$data['text_instruction'] = $language->get('text_new_instruction');
				$data['text_order_id'] = $language->get('text_new_order_id');
				$data['text_date_added'] = $language->get('text_new_date_added');
				$data['text_payment_method'] = $language->get('text_new_payment_method');
				$data['text_shipping_method'] = $language->get('text_new_shipping_method');
				$data['text_email'] = $language->get('text_new_email');
				$data['text_telephone'] = $language->get('text_new_telephone');
				$data['text_ip'] = $language->get('text_new_ip');
				$data['text_order_status'] = $language->get('text_new_order_status');
				$data['text_payment_address'] = $language->get('text_new_payment_address');
				$data['text_shipping_address'] = $language->get('text_new_shipping_address');
				$data['text_product'] = $language->get('text_new_product');
				$data['text_model'] = $language->get('text_new_model');
				$data['text_quantity'] = $language->get('text_new_quantity');
				$data['text_price'] = $language->get('text_new_price');
				$data['text_total'] = $language->get('text_new_total');
				$data['text_footer'] = $language->get('text_new_footer');

				$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
				$data['store_name'] = $order_info['store_name'];
				$data['store_url'] = $order_info['store_url'];
				$data['customer_id'] = $order_info['customer_id'];
				$data['link'] = $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id;

				if ($download_status) {
					$data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
				} else {
					$data['download'] = '';
				}

				$data['order_id'] = $order_id;
				$data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
				$data['payment_method'] = $order_info['payment_method'];
				$data['shipping_method'] = $order_info['shipping_method'];
				$data['email'] = $order_info['email'];
				$data['telephone'] = $order_info['telephone'];
				$data['ip'] = $order_info['ip'];
				$data['order_status'] = $order_status;

				if ($comment && $notify) {
					$data['comment'] = nl2br($comment);
				} else {
					$data['comment'] = '';
				}

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				// Products
				$data['products'] = array();

				foreach ($order_product_query->rows as $product) {
					$option_data = array();

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

							if ($upload_info) {
								$value = $upload_info['name'];
							} else {
								$value = '';
							}
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
						);
					}

					$data['products'][] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				// Vouchers
				$data['vouchers'] = array();

				$order_voucher_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_voucher_query->rows as $voucher) {
					$data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					);
				}

				// Order Totals
				foreach ($order_total_query->rows as $total) {
					$data['totals'][] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
					);
				}

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
					$html = $this->load->view($this->config->get('config_template') . '/template/mail/order.tpl', $data);
				} else {
					$html = $this->load->view('default/template/mail/order.tpl', $data);
				}

				// Can not send confirmation emails for CBA orders as email is unknown
				$this->load->model('payment/amazon_checkout');

				if (!$this->model_payment_amazon_checkout->isAmazonOrder($order_info['order_id'])) {
					// Text Mail
					$text  = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
					$text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
					$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
					$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";

					if ($comment && $notify) {
						$text .= $language->get('text_new_instruction') . "\n\n";
						$text .= $comment . "\n\n";
					}

					// Products
					$text .= $language->get('text_new_products') . "\n";

					foreach ($order_product_query->rows as $product) {
						$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";

						$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");

						foreach ($order_option_query->rows as $option) {
							if ($option['type'] != 'file') {
								$value = $option['value'];
							} else {
								$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

								if ($upload_info) {
									$value = $upload_info['name'];
								} else {
									$value = '';
								}
							}

							$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
						}
					}

					foreach ($order_voucher_query->rows as $voucher) {
						$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
					}

					$text .= "\n";

					$text .= $language->get('text_new_order_total') . "\n";

					foreach ($order_total_query->rows as $total) {
						$text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
					}

					$text .= "\n";

					if ($order_info['customer_id']) {
						$text .= $language->get('text_new_link') . "\n";
						$text .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
					}

					if ($download_status) {
						$text .= $language->get('text_new_download') . "\n";
						$text .= $order_info['store_url'] . 'index.php?route=account/download' . "\n\n";
					}

					// Comment
					if ($order_info['comment']) {
						$text .= $language->get('text_new_comment') . "\n\n";
						$text .= $order_info['comment'] . "\n\n";
					}

					$text .= $language->get('text_new_footer') . "\n\n";

					$mail = new Mail($this->config->get('config_mail'));
					$mail->setTo($order_info['email']);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($order_info['store_name']);
					$mail->setSubject($subject);
					$mail->setHtml($html);
					$mail->setText($text);
					$mail->send();
				}

				// Admin Alert Mail
				if ($this->config->get('config_order_mail')) {
					$subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);

					// HTML Mail
					$data['text_greeting'] = $language->get('text_new_received');
					if ($comment) {
						if ($order_info['comment']) {
							$data['comment'] = nl2br($comment) . '<br/><br/>' . $order_info['comment'];
						} else {
							$data['comment'] = nl2br($comment);
						}
					} else {
						if ($order_info['comment']) {
							$data['comment'] = $order_info['comment'];
						} else {
							$data['comment'] = '';
						}
					}
					$data['text_download'] = '';

					$data['text_footer'] = '';

					$data['text_link'] = '';
					$data['link'] = '';
					$data['download'] = '';

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
						$html = $this->load->view($this->config->get('config_template') . '/template/mail/order.tpl', $data);
					} else {
						$html = $this->load->view('default/template/mail/order.tpl', $data);
					}

					// Text
					$text  = $language->get('text_new_received') . "\n\n";
					$text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
					$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
					$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
					$text .= $language->get('text_new_products') . "\n";

					foreach ($order_product_query->rows as $product) {
						$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";

						$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");

						foreach ($order_option_query->rows as $option) {
							if ($option['type'] != 'file') {
								$value = $option['value'];
							} else {
								$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
							}

							$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
						}
					}

					foreach ($order_voucher_query->rows as $voucher) {
						$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
					}

					$text .= "\n";

					$text .= $language->get('text_new_order_total') . "\n";

					foreach ($order_total_query->rows as $total) {
						$text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
					}

					$text .= "\n";

					if ($order_info['comment']) {
						$text .= $language->get('text_new_comment') . "\n\n";
						$text .= $order_info['comment'] . "\n\n";
					}

					$mail = new Mail($this->config->get('config_mail'));
					$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($this->config->get('config_email'));
					$mail->setReplyTo($order_info['email']);
					$mail->setSender($order_info['store_name']);
					$mail->setSubject($subject);
					$mail->setHtml($html);
					$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
					$mail->send();

					// Send to additional alert emails
					$emails = explode(',', $this->config->get('config_mail_alert'));

					foreach ($emails as $email) {
						if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
							$mail->setTo($email);
							$mail->send();
						}
					}
				}
			}

			// If order status is not 0 then send update text email
			if ($order_info['order_status_id'] && $order_status_id) {
				$language = new Language($order_info['language_directory']);
				$language->load($order_info['language_filename']);
				$language->load('mail/order');

				$subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

				$message  = $language->get('text_update_order') . ' ' . $order_id . "\n";
				$message .= $language->get('text_update_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

				$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

				if ($order_status_query->num_rows) {
					$message .= $language->get('text_update_order_status') . "\n\n";
					$message .= $order_status_query->row['name'] . "\n\n";
				}

				if ($order_info['customer_id']) {
					$message .= $language->get('text_update_link') . "\n";
					$message .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
				}

				if ($notify && $comment) {
					$message .= $language->get('text_update_comment') . "\n\n";
					$message .= $comment . "\n\n";
				}

				$message .= $language->get('text_update_footer');

				$mail = new Mail($this->config->get('config_mail'));
				$mail->setTo($order_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($order_info['store_name']);
				$mail->setSubject($subject);
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();
			}

			// If order status in the complete range create any vouchers that where in the order need to be made available.
			if (in_array($order_info['order_status_id'], $this->config->get('config_complete_status'))) {
				// Send out any gift voucher mails
				$this->load->model('checkout/voucher');

				$this->model_checkout_voucher->confirm($order_id);
			}
		}

		$this->event->trigger('post.order.history.add', $order_id);
	}
}