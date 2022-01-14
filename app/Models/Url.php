<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    public $timestamps = false;



    protected $fillable = [
        'url',
        'time',
        'count_inquiry',
        'count_query_url',
        'choice',
        'id_user'
    ];

    public function urls()
    {
        return $this->hasMany("App\Urls", "id_user", "id");
    }
}
