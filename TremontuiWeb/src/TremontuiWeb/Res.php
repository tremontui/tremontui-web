<?php

namespace TremontuiWeb;

class Res
{

	protected $restDataLink;

	/**
	 * @param mixed $rest_data_link
	 */
	public function setRestDataLink($rest_data_link)
	{
		$this->restDataLink = $rest_data_link;
	}

	/**
	 * @return mixed
	 */
	public function getRestDataLink()
	{
		return $this->restDataLink;
	}


}
