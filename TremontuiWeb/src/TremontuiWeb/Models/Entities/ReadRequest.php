<?php

namespace TremontuiWeb\Models\Entities;

class ReadRequest
{

	protected $subjectEntity;
	protected $filters;
	protected $fields;

	public function defineSubjectEntity($subject_entity)
	{
		$this->subjectEntity = $subject_entity;
	}

	public function hasSubjectEntity()
	{
		if (!empty($this->subjectEntity)) {
			return TRUE;
		}

		return FALSE;
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
