<?php

namespace TremontuiWeb\Controllers;

use TremontuiWeb\Models\Entities\ChannelAdvisorProduct;
use TremontuiWeb\Models\Entities\ReadRequest;
use TremontuiWeb\Models\Entities\RESTDataLink;
use TremontuiWeb\Models\Entities\RESTDataSource;

class ChannelAdvisorProductsController
{

	protected $dataSource;

	public function __construct(RESTDataLink $rest_link)
	{
		$this->dataSource = new RESTDataSource();
		$this->dataSource->setDataLink($rest_link);
	}

	public function hasDataSource()
	{
		if (!empty($this->dataSource)) {
			return TRUE;
		}

		return FALSE;
	}

	public function readProductByUPC($upc)
	{
		$this->dataSource->accessMemberMethod('restDataLink', 'setGet');
		$read_request = new ReadRequest();
		$payloadMap = [
			'id'                => 'ID',
			'sku'               => 'Sku',
			'title'             => 'Title',
			'isParent'          => 'IsParent',
			'parentProductID'   => 'ParentProductID',
			'brand'             => 'Brand',
			'upc'               => 'UPC',
			'warehouseLocation' => 'WarehouseLocation',
			'height'            => 'Height',
			'length'            => 'Length',
			'width'             => 'Width',
			'weight'            => 'Weight',
			'sellerCost'        => 'Cost',
			'retailPrice'       => 'RetailPrice',
			'reservePrice'      => 'ReservePrice',
			'binPrice'          => 'BuyItNowPrice',
			'storePrice'        => 'StorePrice',
			'classification'    => 'Classification',
			'totalQuantity'     => 'TotalQuantity'/*,
			'dcQuantities'      => 'DCQuantities'*/
		];

		$read_request->defineSubjectEntity(new ChannelAdvisorProduct(), $payloadMap, "channeladvisor/products?filter=upc^eq^'" . $upc . "'");
		//Product Object from REST API data source
		$product = $this->dataSource->read($read_request);

		return $product;
	}


}
