<?php

namespace TremontuiWeb\Controllers;

use TremontuiWeb\Models\Entities\ReadRequest;
use TremontuiWeb\Models\Entities\RESTDataLink;
use TremontuiWeb\Models\Entities\RESTDataSource;
use TremontuiWeb\Models\Entities\User;

class UserController
{
	/*
	 *
	 * Assume I will always be given creds
	 * Get input from Router concerning users
	 * The router will tell me what kind of method
	 * In the event of a get, I can take specific input
	 * 	- how many items
	 * 	- criteria for items
	 * 	-
	 *
	 * I will build a payload map for you
	 *
	 * Once I get back the user objects I will create the return type you are looking for
	 * and pass it along to you to implement as you please
	 *
	 */
	protected $dataSource;

	function __construct(RESTDataLink $rest_link)
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

	public function readAllUsers()
	{
		$this->dataSource->accessMemberMethod('restDataLink', 'setGet');
		$read_request = new ReadRequest();
		$payloadMap = [
			'username'  => 'Username',
			'firstName' => 'First_Name',
			'lastName'  => 'Last_Name',
			'email'     => 'Email',
			'id'        => 'ID'
		];
		$read_request->defineSubjectEntity(new User(), $payloadMap, 'users');
		//Array of User Objects from REST API data source
		$users = $this->dataSource->read($read_request);

		return $users;
	}

	public function createNewUser($params)
	{
		$this->dataSource->accessMemberMethod('restDataLink', 'setPost');
		$user = new User();
		$user->setUsername($params['username']);
		$user->setFirstName($params['f_name']);
		$user->setLastName($params['l_name']);
		$user->setEmail($params['email']);
		$user->setPassword($params['password']);
		
	}

}
