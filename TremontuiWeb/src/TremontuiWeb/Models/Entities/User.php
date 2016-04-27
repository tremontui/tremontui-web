<?php

namespace TremontuiWeb\Models\Entities;

class User
{

	protected $username;
	protected $firstName;
	protected $lastName;
	protected $email;
	protected $passwordHash;

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function setFirstName($first_name)
	{
		$this->firstName = $first_name;
	}

	public function setLastName($last_name)
	{
		$this->lastName = $last_name;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setPassword($password)
	{
		$this->passwordHash = $this->encryptPassword($password);
	}

	public function hasUsername()
	{
		if (!empty($this->username)) {
			return TRUE;
		}

		return FALSE;
	}

	public function hasFirstName()
	{
		if (!empty($this->firstName)) {
			return TRUE;
		}

		return FALSE;
	}

	public function hasLastName()
	{
		if (!empty($this->lastName)) {
			return TRUE;
		}

		return FALSE;
	}

	public function hasEmail()
	{
		if (!empty($this->email)) {
			return TRUE;
		}

		return FALSE;
	}

	public function hasSafePassword()
	{
		if (!empty($this->passwordHash)) {
			return TRUE;
		}

		return FALSE;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function getLastName()
	{
		return $this->lastName;
	}

	public function getEmail()
	{
		return $this->email;
	}

	private function encryptPassword($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

    public function verifyPassword($password)
    {
		return password_verify($password, $this->passwordHash);
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

}
