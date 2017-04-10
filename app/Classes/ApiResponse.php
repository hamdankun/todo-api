<?php 
namespace App\Classes;

trait ApiResponse
{	
	/**
	 * The text for success response
	 * @var string
	 */
	public $success = true;

	/**
	 * The text for error response
	 * @var string
	 */
	public $error = false;

	/**
	 * Response when OK
	 * @param  array  $data 
	 * @return array       
	 */
	public function whenOk($data = [])
	{
		return $this->mapResponse($this->success, static::OK, 'OK', $data);
	}

	/**
	 * Response when OK
	 * @param  array  $data 
	 * @return array       
	 */
	public function whenCreated($data = [])
	{
		return $this->mapResponse($this->success, static::CREATED, 'Created', $data);
	}

	/**
	 * Response when not found 
	 * @param  array  $data 
	 * @param  string $key  
	 * @return array       
	 */
	public function whenNotFound($data = [], $key = 'data')
	{
		return $this->mapResponse($this->error, static::NOT_FOUND, 'Not found', $data, $key);
	}

	/**
	 * Response when bad request
	 * @param  array  $data 
	 * @param  string $key  
	 * @return array       
	 */
	public function whenBadRequest($data = [], $key = 'data')
	{
		return $this->mapResponse($this->error, static::BAD_REQUEST, 'Bad Request', $data, $key);
	}

	/**
	 * Response when forbidden 
	 * @param  array  $data 
	 * @param  string $key  
	 * @return array       
	 */
	public function whenForbidden($data = [], $key = 'data')
	{
		return $this->mapResponse($this->error, static::FORBIDDEN, 'Forbidden', $data, $key);
	}

	/**
	 * Response when unprocessable entiry
	 * @param  array $data 
	 * @param  string $key  
	 * @return array       
	 */
	public function whenUnprocessableEntity($data = [], $key = 'errors')
	{
		return $this->mapResponse($this->error, static::UNPROCESSEBLE_ENTITY, 'Unprocessable Entity', $data, $key);
	}

	/**
	 * Response when internal server error
	 * @param  array  $data 
	 * @param  string $key  
	 * @return array       
	 */
	public function whenInternalServerError($data = [], $key = 'data')
	{
		return $this->mapResponse($this->error, static::SERVER_ERROR, 'Internal Server Error', $data, $key);
	}

	/**
	 * whenServer Unavailable 
	 * @param  array $data 
	 * @param string $key  
	 * @return array       
	 */
	public function whenServerUnavailable($data = [], $key = 'data')
	{
		return $this->mapResponse($this->error, static::SERVER_UNAVAILABLE, 'Server Unavailable', $data, $key);
	}

	public function whenUnauthorized($data = [], $key = 'data')
	{
		return $this->mapResponse($this->error, static::UNAUTHORIZED, 'Unauthorized', $data, $key);
	}


	/**
	 * Structur array for response
	 * @param  string $status  
	 * @param  integer $code    
	 * @param  string $message 
	 * @param  array  $data    
	 * @param  string $key     
	 * @return array          
	 */
	public function mapResponse($status, $code, $message, $data = [], $key = 'data')
	{
		return [
			'status' => $status,
			'code' => $code,
			'message' => $message,
			$key => count($data) > 0 ? $data : (object)[]
		];
	}
}
