<?php

namespace TremontuiWeb\Models\Entities;

class PDODataSource implements DataSource
{
	protected $pdoDataLink;
	protected $lastReadSql;

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
		// TODO: Implement read() method.
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
        if(!empty($this->pdoDataLink)) {
			return TRUE;
		}
		return FALSE;
    }

    public function getLastReadSQL()
    {
        return $this->lastReadSql;
    }
}
