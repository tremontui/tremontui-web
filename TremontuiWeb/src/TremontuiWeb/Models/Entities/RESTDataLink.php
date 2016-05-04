<?php

namespace TremontuiWeb\Models\Entities;

class RESTDataLink implements DataLink
{
	protected $connection;
	protected $headerCollection;
	protected $method;
	protected $port;

	public function __construct($connection, $port = '8080')
	{
		if(substr($connection, -1) != "/"){
			$this->connection = ($connection .= "/");
		} else {
			$this->connection = $connection;
		}

		$this->port = $port;
	}

	public function queryRequest($request, $params = NULL)
	{
		$ch = curl_init($this->connection . $request);

		curl_setopt($ch, CURLOPT_PORT, $this->port);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, $this->method, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headerCollection);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec($ch);

		if($output === false){
			return 'curl error: ' . curl_error($ch);
		} else {
			$decoded_response = json_decode($output, true);
			if($decoded_response['api_success'] && $decoded_response['result']['db_success']) {
				return $decoded_response['result']['result'];
			}
		}

	}

    public function addHeaders($headers)
    {
        if(is_array($headers)){
			foreach($headers as $header){
				$this->headerCollection[] = $header;
			}
		} else {
			$this->headerCollection[] = $headers;
		}
    }

    public function RESTHeaderCount()
    {
        return count($this->headerCollection);
    }

    public function getConnectionHostURI()
    {
        return $this->connection;
    }

    public function setGet()
    {
        $this->method = CURLOPT_HTTPGET;
    }

    public function getMethod()
    {
        return $this->method;
    }
}
