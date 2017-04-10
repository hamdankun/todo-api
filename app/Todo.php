<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model {

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['user_id', 'title', 'date', 'notify', 'description'];

	/**
	 * Relation with user
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
