<?php

namespace TremontuiWeb\Models\Entities;

interface DataSource
{
	public function setDataLink(DataLink $data_link);
 	public function create(CreateRequest $c);
	public function read(ReadRequest $r);
	public function update(UpdateRequest $u);
	public function delete(DeleteRequest $d);

}
