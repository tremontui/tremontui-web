<?php

class Http_Service{
	
	private $required_headers = [];
	private $base_uri;
	private $expects = 'expectsJson';
	private $temp_body = '';
	
	public function __construct( $base_uri ){
		
		$this->base_uri = $base_uri;
		
	}
	
	public function add_header( $header_name, $header_value ){
		
		$this->required_headers[$header_name] = $header_value;
		
		return $this;
		
	}
	
	private function reset(){
		
		$this->temp_body = '';
		
	}
	
	public function expectsJson(){
		
		$this->expects = 'expectsJson';
		
		return $this;
		
	}
	
	public function expectsHtml(){
		
		$this->expects = 'expectsHtml';
		
		return $this;
		
	}
	
	public function withBody( $body ){
		
		$this->temp_body = $body;
		
		return $this;
		
	}
	
	public function testBaseUri(){
		
		return $this->base_uri;
		
	}
	
	public function get( $end_point ){
		$expects = $this->expects;
		
		$result = \Httpful\Request::get( $this->base_uri . $end_point )
			->addHeaders( $this->required_headers )
			->body( $this->temp_body )
			->$expects()
			->send();
		
		$this->reset();
		
		return $result;
		
	}
	
	public function post( $end_point ){
		$expects = $this->expects;
		
		$result = \Httpful\Request::post( $this->base_uri . $end_point )
			->addHeaders( $this->required_headers )
			->body( $this->temp_body )
			->$expects()
			->send();
		
		$this->reset();
		
		return $result;
		
	}
	
	
}

?>