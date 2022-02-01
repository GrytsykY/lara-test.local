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
        'search_word',
        'time_out',
        'max_count_ping',
        'ping_counter',
        'status_code',
        'last_ping',
        'is_failed',
        'is_sent_alert',
        'id_alert',
        'id_user',
        'id_project',

    ];


    public function urls()
    {
        return $this->hasMany("App\Urls", "id_user", "id");
    }

}
