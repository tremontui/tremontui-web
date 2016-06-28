<?php

namespace TremontuiWeb\Models\Entities;

class RESTDataSource implements DataSource
{
	protected $restDataLink;

	public function setDataLink(DataLink $data_link)
	{
		$this->restDataLink = $data_link;
	}

	public function accessMemberMethod($member, $method){
		return $this->$member->$method();
		//return $this->restDataLink->$member();
	}

	public function create(CreateRequest $c)
	{
		// TODO: Implement create() method.
	}

	public function read(ReadRequest $r)
	{
		$resource = $r->getSubjectEntitySetName();
		$response = $this->restDataLink->queryRequest($resource);
		$payload_map = $r->getPayloadMap();
		$entity_type = $r->getSubjectEntityType();
		
		$returns = [];
		foreach($response AS $item){
			$returns[] = $this->newInstanceFromPayload($payload_map, $entity_type, $item);
		}
		return $returns;

	}

	private function newInstanceFromPayload($payload_map, $entity_type, $data_set){
		$payload = [];
		if(is_array($data_set)){
			foreach($payload_map AS $key=>$value){
				$payload[$key] = $data_set[$value];
			}
		} else if (is_object($data_set)){
			foreach($payload_map AS $key=>$value){
				$payload[$key] = $data_set[$value];
			}
		}
		return $entity_type::withPayload($payload);
	}

	public function update(UpdateRequest $u)
	{
		// TODO: Implement update() method.
	}

	public function delete(DeleteRequest $d)
	{
		// TODO: Implement delete() method.
	}

	public function hasRestURIDataLink()
	{
		if (!empty($this->restDataLink)) {
			return TRUE;
		}

		return FALSE;
	}

    public function getLastRESTReadCUrl()
    {
        // TODO: write logic here
    }
}
