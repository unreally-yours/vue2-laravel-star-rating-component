<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\StarRatingRecords;

class StarRating extends Model
{
	protected $table='star_rating';
	protected $fillable=['source_id','source','rating'];
//------------------------------------------------------------------------------------------------
	public function add($request){
		$rating=StarRating::where([
			['source_id',$request->input('source_id')],
			['source',$request->input('source')]
		])->get();
		if($rating->count()){
			$rating=$rating->first();
		}else{
			$rating=StarRating::create($request->all());
		}
		$record=StarRatingRecords::create([
			'rating_id'	=>$rating->id,
			'rating'	=>$request->input('rating')
		]);
		$records=StarRatingRecords::where('rating_id',$rating->id)->get();
		$sum=0;
		foreach($records as $record){
			$sum+=$record->rating;
		}
		$sum/=$records->count();
		$rating->rating=round($sum);
		$rating->save();
		return $rating->toArray();
	}
}
