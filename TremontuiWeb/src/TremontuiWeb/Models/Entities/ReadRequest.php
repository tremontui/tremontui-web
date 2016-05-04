<?php

namespace TremontuiWeb\Models\Entities;

class ReadRequest
{

	protected $subjectEntity;
	protected $filters;
	protected $fields;
	protected $subjectEntitySetName;
	protected $payloadMap;


	public function defineSubjectEntity($subject_entity,$payload_map, $set_name)
	{
		$this->subjectEntity = $subject_entity;
		$this->subjectEntitySetName = $set_name;
		$this->payloadMap = $payload_map;
	}

	public function getPayloadMap(){
		return $this->payloadMap;
	}

	public function hasSubjectEntity()
	{
		if (!empty($this->subjectEntity)) {
			return TRUE;
		}

		return FALSE;
	}

	public function getSubjectEntityType()
	{
		if(gettype($this->subjectEntity) == 'object'){
			return get_class($this->subjectEntity);
		}
		return gettype($this->subjectEntity);
	}

	public function getSubjectEntitySetName()
	{
		return $this->subjectEntitySetName;
	}

	public function defineFilters(array $filters = [])
    {
        $this->filters = $filters;
    }

	public function getFilters()
    {
        return $this->filters;
    }

	public function defineFields(array $fields = [])
    {
        $this->fields = $fields;
    }

	public function getFields()
    {
        return $this->fields;
    }


}
