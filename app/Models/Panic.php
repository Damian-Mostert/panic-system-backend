<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panic extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'type', 'details', 'longitude', 'latitude', 'canceled'];

    // Mutator for the 'data' attribute
    public function setDataAttribute($value)
    {
        $allowedKeys = ['status', 'type', 'details', 'longitude', 'latitude'];

        // Filter the input data to include only allowed keys
        $filteredData = array_intersect_key($value, array_flip($allowedKeys));

        // Encode the filtered data as JSON and set it to the 'data' attribute
        $this->attributes['data'] = json_encode($filteredData);
    }

    // Accessor for the 'data' attribute
    public function getDataAttribute($value)
    {
        // Decode the 'data' attribute to get an array
        return json_decode($value, true);
    }
}
