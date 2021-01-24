<?php

namespace App\Models\cassoviacode_interview_22_01_2021;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objednavky extends Model
{
    use HasFactory;
    use SoftDeletes;


    /** @var string  */
    protected $table = 'objednavky';

    /** @var string  */
    protected $connection = "cassoviacode_interview_22_01_2021_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nazov',
        'popis',
        'cena',
    ];

    protected $dates = [
        'created_at', 'update_at', 'deleted_at'
    ];

}
