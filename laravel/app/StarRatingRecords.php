<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class StarRatingRecords extends Model
{
//------------------------------------------------------------------------------------------------
	protected $table='star_rating_records';
	protected $fillable=['rating_id','rating'];
//------------------------------------------------------------------------------------------------
}
