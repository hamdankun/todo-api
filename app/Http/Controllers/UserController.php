<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\BaseApiController;

class UserController extends BaseApiController
{	
	/**
	 * Builder instance
	 * @var \DB
	 */
	protected $table;

	/**
	 * Ini Bulder Query and request http 
	 * @return void 
	 */
	public function __construct()
	{
		$this->table = $this->initBuilder(static::USER);
		$this->initRequest();
	}

	/**
	 * Show all resources from storage
	 * @return \Illuminate\Http\Request
	 */
	public function index()
	{	
		$users = $this->toCache($this->request->fullUrl(), function () {
			return $this->table->q()->select('id', 'username', 'email', 'created_at', 'updated_at')->orderBy('id')->paginate(10);
		});
		$data = $this->whenOk($users);
		return $this->apiResponse($data, static::OK);
	}

	/**
	 * Show spesific resource form storage
	 * @param  integer $id 
	 * @return \Illuminate\Http\Request     
	 */
	public function show($id)
	{

		$user = $this->table->findById($id);

		if($user) {
			$data = $this->whenOk($user);
			$status = static::OK;
		} else {
			$data = $this->whenNotFound();
			$status = static::NOT_FOUND;
		}

		return $this->apiResponse($data, $status);
	}

	/**
	 * Store new resource
	 * @return \Illuminate\Http\Request
	 */
	public function store()
	{
		$validation =  $this->validation($this->request, $this->rules());

		if ($validation->fails()) {
			return $this->apiResponse($this->whenUnprocessableEntity($validation->errors()), static::UNPROCESSEBLE_ENTITY);
		}
		$data = $this->request->only('username', 'email', 'password');
		$data['password'] = app('hash')->make($data['password']);
		$data = $this->table->saveData($data);
		return $this->apiResponse($this->whenCreated($data), static::CREATED);
	}

	/**
	 * Store new resource
	 * @return \Illuminate\Http\Request
	 */
	public function update($id)
	{
		$validation =  $this->validation($this->request, $this->rules($id));

		if ($validation->fails()) {
			return $this->apiResponse($validation->errors(), static::UNPROCESSEBLE_ENTITY);
		}

		$user = $this->table->findById($id);
		
		if (!$user) {
			return $this->apiResponse($this->whenNotFound(), static::NOT_FOUND);
		}

		$data = $this->request->only('username', 'email', 'password');
		
		if ($data['password']) {
			$data['password'] = app('hash')->make($data['password']);
		} else {
			unset($data['password']);
		}

		$data = $this->table->updateData($data, $id);
		return $this->apiResponse($this->whenOk($data), static::OK);
	}

	/**
	 * Rules input 
	 * @param  integer $userId 
	 * @return array          
	 */
	public function rules($userId = 0)
	{		
		if ($userId) {
			$rulesPassword = 'min:8';
		} else {
			$rulesPassword = 'required|min:8';
		}

		return [
			'username' => 'required',
			'email' => 'required|email|unique:users,email,'.$userId,
			'password' => $rulesPassword
		];
	}

	public function destroy($id)
	{
		$user = $this->table->findById($id);
		if (!$user) {
			return $this->apiResponse($this->whenNotFound(), static::NOT_FOUND);
		}

		$this->table->deleteData($id);
		return $this->apiResponse($this->whenOk(), static::OK);
	}
}
