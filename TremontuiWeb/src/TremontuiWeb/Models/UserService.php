<?php

namespace TremontuiWeb\Models;

use TremontuiWeb\Models\Entities\DataSource;
use TremontuiWeb\Models\Entities\UserCollection;

class UserService
{

	protected $userCollection;
	protected $dataSource;

	public function __construct()
	{
		$this->userCollection = new UserCollection();
	}

	public function addUser($user)
	{
		$this->userCollection->add($user);
	}

	public function userCount()
	{
		return $this->userCollection->count();
	}

	public function setDataSource(DataSource $data_source)
	{
		$this->dataSource = $data_source;
	}

	public function hasDataSource()
	{
		if (!empty($this->dataSource)) {
			return TRUE;
		}

		return FALSE;
	}


}
