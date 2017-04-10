<?php 
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\BaseApiController;

class AuthController extends BaseApiController
{   

    /**
     * @var \App\User
     */
    protected $auth;

    /**
     * Init Request Http
     */
    public function __construct(User $user)
    {
     	$this->initRequest();
        $this->auth = $user;
    }

    public function auth()
    {	

        $user = $this->auth->attempt($this->request->only('email', 'password'));
        
        if(!$user) {
            return $this->apiResponse($this->whenUnauthorized(), static::UNAUTHORIZED);
        } 

        return $this->apiResponse($this->whenOk(['token' => $user->api_token]), static::OK);

    }
}
