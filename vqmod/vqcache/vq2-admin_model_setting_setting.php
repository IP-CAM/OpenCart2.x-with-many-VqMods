<?php
class ModelSettingSetting extends Model {
	public function getSetting($group, $store_id = 0) {
		$data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");

		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = unserialize($result['value']);
			}
		}

		return $data;
	}

	public function editSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");

		foreach ($data as $key => $value) {
			// Make sure only keys belonging to this group are used
			if (substr($key, 0, strlen($group)) == $group) {
				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
				}
			}

					if(isset($data["config_avatax_tax_calculation"]) && $data["config_avatax_tax_calculation"]==1)
					{
						$this->avataxAddFields();
					}
				
		}
	}


				/***************************************************************************
				*   Last Updated On	   :	05/14/2015			                           				*
				*   Description        :   avataxAddFields() function adds AvaTax fields in database.    * 
				****************************************************************************/
			
				public function avataxAddFields() {
					$result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'avatax_paytax_document_id'");
					if($result->num_rows == 0){
					$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `avatax_paytax_document_id` INT NOT NULL DEFAULT '0', ADD `avatax_paytax_transaction_id` INT NOT NULL DEFAULT '0', ADD `avatax_paytax_error_message` TEXT NOT NULL, ADD `avatax_paytax_document_code` VARCHAR( 40 ) NOT NULL");
				}

				//Add one new field to Open Cart "order_status" table
				$result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order_status` LIKE 'avatax_document_status'");
				if($result->num_rows == 0){
					$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_status` ADD `avatax_document_status` VARCHAR( 30 ) NOT NULL");
					$this->db->query("UPDATE `" . DB_PREFIX . "order_status` SET avatax_document_status = 'Uncommitted' where order_status_id in (1, 2)");
					$this->db->query("UPDATE `" . DB_PREFIX . "order_status` SET avatax_document_status = 'Committed' where order_status_id in (3, 5, 15)");
					$this->db->query("UPDATE `" . DB_PREFIX . "order_status` SET avatax_document_status = 'Voided' where order_status_id in (7, 8, 9, 10, 11, 12, 13, 14, 16)");
				}

				//Add one new field to Open Cart "return" table
				$result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "return` LIKE 'avatax_return_document_code'");
				if($result->num_rows == 0){
					$this->db->query("ALTER TABLE `" . DB_PREFIX . "return` ADD `avatax_return_document_code` VARCHAR( 10 ) NOT NULL");
				}
			}
			
	public function deleteSetting($group, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
	}

	public function editSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
		if (!is_array($value)) {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "' WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1' WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		}
	}
}