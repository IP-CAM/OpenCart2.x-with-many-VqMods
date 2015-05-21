<?php
class ModelTotalTax extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
        $taxCount=0;

				/*if($this->config->get('config_avatax_tax_calculation'))
				{
					$title = 'Total Tax';
					//$avatax_taxname = $this->config->get('avataxname');
				}*/
				
		foreach ($taxes as $key => $value) {

				if($this->config->get('config_avatax_tax_calculation'))
				{
					//$title = $avatax_taxname[$taxCount]['name'];
					$title = 'Total Tax';	//It displays title on Checkout page - Step 6: Confirm Order
				}
				else
				{
					$title = $this->tax->getRateName($key);
				}
				
			if ($value >= 0) {
				$total_data[] = array(
					'code'       => 'tax',
					'title'      => $title,
					'value'      => $value,
					'sort_order' => $this->config->get('tax_sort_order')
				);

				$total += $value;
                $taxCount++;
			}
		}
//}
	}
}