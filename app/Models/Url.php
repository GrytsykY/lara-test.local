<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'url',
        'name',
        'time',
        'count_inquiry',
        'count_query_url',
        'choice',
        'id_user',
//        'created_at'
    ];

    public function urls()
    {
        return $this->hasMany("App\Urls", "id_user", "id");
    }
}
