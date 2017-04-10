<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\BaseApiController;

class TodoController extends BaseApiController
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
		$this->table = $this->initBuilder(static::TODO);
		$this->initRequest();
	}

	/**
	 * Show all resources from storage
	 * @return \Illuminate\Http\Request
	 */
	public function index()
	{	
		$todos = $this->toCache($this->request->fullUrl(), function () {
			return $this->table->q()->where('user_id', $this->getUser()->id)->orderBy('id')->paginate(10);
		});
		$data = $this->whenOk($todos);
		return $this->apiResponse($data, static::OK);
	}

	/**
	 * Show spesific resource form storage
	 * @param  integer $id 
	 * @return \Illuminate\Http\Request     
	 */
	public function show($id)
	{

		$todo = $this->table->q()->where('id', $id)->where('user_id', $this->getUser()->id)->first();

		if($todo) {
			$data = $this->whenOk($todo);
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

		$data = $this->request->only('title', 'date', 'notify', 'description');
		$data['user_id'] = $this->getUser()->id;
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

		if (!$this->existData($id)) {
			return $this->apiResponse($this->whenForbidden(), static::FORBIDDEN);
		}

		$data = $this->request->only('title', 'date', 'notify', 'description');
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
		return [
			'title' => 'required',
			'date' => 'required|date',
			'nofity' => 'in:0,1',
			'description' => 'required'
		];
	}

	public function destroy($id)
	{
		if (!$this->existData($id)) {
			return $this->apiResponse($this->whenNotFound(), static::NOT_FOUND);
		}

		$this->table->deleteData($id);
		return $this->apiResponse($this->whenOk(), static::OK);
	}

	/**
	 * Check if todo data is exist
	 * @param  integer $id 
	 * @return array     
	 */
	public function existData($id)
	{
		return $this->table->q()->where('id', $id)->where('user_id', $this->getUser()->id)->first();
	}
}
