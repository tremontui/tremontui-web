<?php

namespace TremontuiWeb\Models\Entities;

class Filter
{
	const OP_EQ = "==";
	const OP_LT = "<";
	const OP_GT = ">";
	const OP_LTEQ = "<=";
	const OP_GTEQ = ">=";
	const OP_NOTEQ = "!=";
	const CON_AND = "&&";
	const CON_OR = "||";

	protected $field;
	protected $operator;
	protected $value;
	protected $conjunction;

	public function __construct($field, $operator, $value)
	{
		$this->field = $field;
		$this->operator = $operator;
		$this->value = $value;
	}

	public function getField()
	{
		return $this->field;
	}

	public function getOperator()
	{
		return $this->operator;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function setConjunction($conjunction)
	{
		$this->conjunction = $conjunction;
	}

	public function hasConjunction()
	{
		if (!empty($this->conjunction)) {
			return TRUE;
		}

		return FALSE;
	}

    public function getConjunction()
    {
        return $this->conjunction;
    }
}
