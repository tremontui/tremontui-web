<?php

namespace TremontuiWeb\Models\Entities;

class PDODataSource implements DataSource
{
	const OP_PHP_TO_SQL = [
		"==" => "=",
		"<"  => "<",
		">"  => ">",
		"<=" => "<=",
		">=" => ">=",
		"!=" => "!=",
		"&&" => "AND",
		"||" => "OR"
	];

	protected $pdoDataLink;
	protected $lastReadSql;
	protected $response;

	public function setDataLink(DataLink $data_link)
	{
		$this->pdoDataLink = $data_link;
	}

	public function create(CreateRequest $c)
	{
		// TODO: Implement create() method.
	}

	public function read(ReadRequest $r)
	{
		if ($this->pdoDataLink->getDataLang() == PDODataLink::DRIVER_LANG_SQL) {
			$fields = $this->convertFieldsToSQL($r);
			$subject = $r->getSubjectEntitySetName();
			$filter_obj = $this->convertFiltersToSQL($r);
			$filter_string = $filter_obj['query'];
			$filter_params = $filter_obj['params'];

			$read_query = "SELECT $fields FROM $subject" . $filter_string;

			$this->lastReadSql = $read_query;
			$this->pdoDataLink->queryRequest($read_query, $filter_params);
		}
		//TODO: Set response after queryRequest
		return $this->response;
	}

	public function update(UpdateRequest $u)
	{
		// TODO: Implement update() method.
	}

	public function delete(DeleteRequest $d)
	{
		// TODO: Implement delete() method.
	}

	public function hasPDODataLink()
	{
		if (!empty($this->pdoDataLink)) {
			return TRUE;
		}

		return FALSE;
	}

	public function getLastReadSQL()
	{
		return $this->lastReadSql;
	}

	/**
	 * @param ReadRequest $r
	 * @return string
	 */
	private function convertFiltersToSQL(ReadRequest $r)
	{
		$filter_obj = [
			'query'  => '',
			'params' => []
		];
		if (!empty($filters = $r->getFilters())) {
			$filter_obj['query'] = ' WHERE ';
			for ($i = 0, $f_count = count($filters); $i < $f_count; $i++) {
				$filter = $filters[$i];
				$f_field = $filter->getField();
				$f_op = PDODataSource::OP_PHP_TO_SQL[$filter->getOperator()];
				$f_value = ':' . $filter->getField();
				$filter_obj['params'][$f_value] = $filter->getValue();

				$filter_sub_string = "$f_field $f_op $f_value";
				if ($filter->hasConjunction()) {
					$f_conj = PDODataSource::OP_PHP_TO_SQL[$filter->getConjunction()];
					$filter_sub_string .= " " . $f_conj;
				}

				if ($i < ($f_count - 1)) {
					$filter_sub_string .= " ";
				}

				$filter_obj['query'] .= $filter_sub_string;
			}

			return $filter_obj;
		}

		return $filter_obj;
	}

	/**
	 * @param ReadRequest $r
	 * @return mixed
	 */
	private function convertFieldsToSQL(ReadRequest $r)
	{
		$fields = '*';
		if (!empty($read_fields = $r->getFields())) {
			$fields = implode(',', $read_fields);

			return $fields;
		}

		return $fields;
	}
}
