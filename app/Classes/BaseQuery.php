<?php 
namespace App\Classes;

use DB;
use Carbon\Carbon;

class BaseQuery 
{	
	/**
	 * Builder instance
	 * @var DB
	 */
	protected $builder;

	/**
	 * Init Builder query instance
	 * @param string $tableName 
	 */
	public function __construct($tableName)
	{
		$this->builder = DB::table($tableName);
	}

	/**
	 * Query builder 
	 * @return \DB
	 */
	public function q()
	{
		return $this->builder;
	}

	/**
	 * Find by id
	 * @param  integer $id 
	 * @return array     
	 */
	public function findById($id)
	{
		return $this->q()->where('id', $id)->first();
	}

	/**
	 * Save data to database
	 * @param  array $data 
	 * @return array       
	 */
	public function saveData($data)
	{
		$data = $this->timeStamp($data);
		$id = $this->q()->insertGetId($data);
		return $this->findById($id);
	}

	/**
	 * Update data in database
	 * @param  array $data 
	 * @return array       
	 */
	public function updateData($data, $id)
	{
		$data = $this->timeStamp($data, ['updated_at']);
		$this->q()->where('id', $id)->update($data);
		return $this->findById($id);
	}

	public function deleteData($id)
	{
		return $this->q()->where('id', $id)->delete();
	}

	/**
	 * Define timestampe for data
	 * @param array $data 
	 * @param array $columns 
	 * @return array
	 */
	public function timeStamp($data, $columns = ['created_at', 'updated_at'])
	{
		if (in_array('created_at', $columns)) {
			$data['created_at'] = Carbon::now();
		}

		if (in_array('updated_at', $columns)) {
			$data['updated_at'] = Carbon::now();
		}

		return $data;
	}
}
