<?php

namespace TremontuiWeb\Models\Entities;

use PDO;
use PhpSpec\Exception\Exception;

class PDODataLink implements DataLink
{
	const DRIVER_LANG_SQL = 'SQL';

	const DRIVER_TO_LANG = [
		'mysql' => PDODataLink::DRIVER_LANG_SQL
	];

	protected $connection;
	protected $dataLang;

	public function __construct($connection)
	{
		if (gettype($connection) != 'object') {
			throw new Exception('InvalidArgumentException');
		} else {
			if (get_class($connection) != 'PDO') {
				throw new Exception('InvalidArgumentException');
			} else {
				$this->connection = $connection;
				$this->dataLang = PDODataLink::DRIVER_TO_LANG[$this->getPDODriver()];
			}
		}
	}

	public function getPDODriver()
	{
		return $this->connection->getAttribute(PDO::ATTR_DRIVER_NAME);
	}

	public function getDataLang()
	{
		return $this->dataLang;
	}
}
