<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'users';
	protected $fillable = ['email', 'username', 'password', 'level', 'firstname', 'lastname'];

	public $timestamps = false;
}

?>