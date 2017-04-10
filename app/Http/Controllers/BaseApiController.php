<?php 
namespace App\Http\Controllers;

use App\Classes\BaseQuery;
use App\Classes\ApiResponse;
use App\Classes\BaseValidator;
use App\Classes\TableRepository;
use App\Http\Controllers\Controller;
use App\Classes\ApiResponseInterface;

class BaseApiController extends Controller implements ApiResponseInterface, TableRepository
{
	use ApiResponse, BaseValidator;

	/**
	 * Request http instance
	 * @var 
	 */
	protected $request;

	/**
	 * Init builder instance
	 * @param  string $tableName 
	 * @return \DB            
	 */
	public function initBuilder($tableName)
	{
		return new BaseQuery($tableName);
	}

	/**
	 * Init Request Http 
	 * @return void
	 */
	public function initRequest()
	{
		$this->request = app(\Illuminate\Http\Request::class);
	}

	/**
     * Store Data to Cache
     * @param  string  $name
     * @param  Closure $callback
     * @param  integer  $minutes
     * @return \Illuminate\Support\Cache
     */
    public function toCache($name, \Closure $callback, $minutes = 5)
    {
      return \Cache::remember($name, $minutes, $callback);
    }

    /**
     * Response Api
     * @param  array $data   
     * @param  integer $status 
     * @return \Illuminate\Support\Response         
     */
    public function apiResponse($data, $status)
    {
    	return response()->json($data, $status);
    }

    /**
     * Get user via api token
     * @param  string $apiToken 
     * @return App\User           
     */
    public function getUser()
    {
    	$apiToken = $this->request->header('Authorization');
    	$instance = new \App\User;
    	return $instance->findByApiToken($apiToken);
    }
}
