<?php

namespace TremontuiWeb\Models\Entities;

use JsonSerializable;

class ChannelAdvisorProduct implements JsonSerializable, Creatable
{

	public $id;
	public $sku;
	public $title;
	public $isParent;
	public $parentProductID;
	public $brand;
	public $upc;
	public $warehouseLocation;
	public $height;
	public $length;
	public $width;
	public $weight;
	public $sellerCost;
	public $retailPrice;
	public $reservePrice;
	public $binPrice;
	public $storePrice;
	public $classification;
	public $totalQuantity;
	public $dcQuantities;


	public static function withPayload(array $payload){
		$instance = new self();
		$instance->fillFromPayload($payload);

		return $instance;
	}

	private function fillFromPayload(array $payload){
		foreach($payload AS $key=>$value){
			$this->$key = $value;
		}
	}

	public function hasSku()
    {
        if(!empty($this->sku)){
			return TRUE;
		}
		return FALSE;
    }

	public function hasTitle()
    {
		if(!empty($this->title)){
			return TRUE;
		}
		return FALSE;
    }

	public function validateCreatable()
	{
		if($this->title && $this->sku){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	function jsonSerialize()
	{
		return (object) get_object_vars($this);
	}
}
