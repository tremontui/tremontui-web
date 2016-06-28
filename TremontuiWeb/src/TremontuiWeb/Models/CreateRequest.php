<?php

namespace TremontuiWeb\Models;

use TremontuiWeb\Models\Entities\Creatable;

class CreateRequest
{

	protected $setName;
	protected $objects;
	protected $typeLock;

	public function __construct($set_name)
	{
		$this->setName = $set_name;
	}

	public function getSetName()
	{
		return $this->setName;
	}

	public function add(Creatable $obj)
	{
		if ($obj->validateCreatable()) {
			$this->objects[] = $obj;
			$this->lockCreateType(get_class($obj));
		} else {
			return FALSE;
		}
	}

	public function addArray(array $obj_array)
	{
		foreach ($obj_array AS $obj) {
			if ($obj instanceof Creatable) {
				if ($obj->validateCreatable()) {
					$this->objects[] = $obj;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}
	}

	private function lockCreateType($type){
		if(!empty($this->typeLock)){
			if($this->typeLock != $type){
				return FALSE;
			} else{
				return TRUE;
			}
		} else {
			$this->typeLock = $type;
		}
	}

	public function objectCount()
	{
		return count($this->objects);
	}

    public function getTypeLock()
    {
        return $this->typeLock;
    }
}
