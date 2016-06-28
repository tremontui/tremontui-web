<?php
/**
 * Created by PhpStorm.
 * User: Niran
 * Date: 4/27/2016
 * Time: 12:13 PM
 */

namespace TremontuiWeb\Models\Entities;


use PhpSpec\Exception\Exception;

class UserCollection implements \Countable
{
	protected $collection = [];

	/**
	 * UserCollection constructor.
	 */
	public function __construct()
	{
	}

	public function add(User $user)
	{
		$this->collection[] = $user;
	}

	public function count()
	{
		return count($this->collection);
	}

	public function getUser($arg)
	{
		if (gettype($arg) === 'integer') {
			return $this->collection[$arg];
		} else if (gettype($arg) === 'string') {
			foreach ($this->collection as $user) {
				if ($user->getUsername() === $arg) {

					return $user;
				}
			}
			print_r('<pre>');
			print_r($this->collection);
			print_r('</pre>');

			return FALSE;
		}

		throw new Exception('InvalidArgumentException');

	}

	public function getFirstUser()
	{
		if (!empty($this->collection)) {
			return $this->collection[0];
		}

		return FALSE;
	}

	public function getLastUser()
	{
		if (!empty($this->collection)) {
			return $this->collection[($this->count() - 1)];
		}

		return FALSE;
	}
}