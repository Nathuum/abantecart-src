<?php
/*------------------------------------------------------------------------------
  $Id$

  AbanteCart, Ideal OpenSource Ecommerce Solution
  http://www.AbanteCart.com

  Copyright © 2011 Belavier Commerce LLC

  This source file is subject to Open Software License (OSL 3.0)
  Lincence details is bundled with this package in the file LICENSE.txt.
  It is also available at this URL:
  <http://www.opensource.org/licenses/OSL-3.0>

 UPGRADE NOTE:
   Do not edit or add to this file if you wish to upgrade AbanteCart to newer
   versions in the future. If you wish to customize AbanteCart for your
   needs please refer to http://www.AbanteCart.com for more information.
------------------------------------------------------------------------------*/
if ( !defined ( 'DIR_CORE' )) {
	header ( 'Location: static_pages/' );
}

class ModelExtensionDefaultFlatRateShipping extends Model {
	function getQuote($address) {
		$this->load->language('default_flat_rate_shipping/default_flat_rate_shipping');
		$location_id = (int)$this->config->get('default_flat_rate_shipping_location_id');

		if ($this->config->get('default_flat_rate_shipping_status')) {

			$taxes = $this->tax->getTaxes((int)$address['country_id'], (int)$address['zone_id']);
		
      		if (!$location_id) {
        		$status = TRUE;
      		} elseif ($taxes) {
        		$status = TRUE;
      		} else {
        		$status = FALSE;
      		}
		} else {
			$status = FALSE;
		}

		$method_data = array();
	
		if ($status) {
			$quote_data = array();

      		$quote_data['default_flat_rate_shipping'] = array(
        		'id'           => 'default_flat_rate_shipping.default_flat_rate_shipping',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => $this->config->get('default_flat_rate_shipping_cost'),
        		'tax_class_id' => $this->config->get('default_flat_rate_shipping_tax'),
				'text'         => $this->currency->format($this->tax->calculate($this->config->get('default_flat_rate_shipping_cost'),
				                                                                $this->config->get('default_flat_rate_shipping_tax'),
				                                                                $this->config->get('config_tax')))
      		);

      		$method_data = array(
        		'id'         => 'default_flat_rate_shipping',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('default_flat_rate_shipping_sort_order'),
        		'error'      => FALSE
      		);
		}
	
		return $method_data;
	}
}
?>