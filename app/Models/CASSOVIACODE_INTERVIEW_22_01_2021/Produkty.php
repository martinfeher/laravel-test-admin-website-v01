<?php

namespace App\Models\cassoviacode_interview_22_01_2021;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produkty extends Model
{
    use HasFactory, SoftDeletes;


    /** @var string  */
    protected $table = 'produkty';

    /** @var string  */
    protected $connection = "cassoviacode_interview_22_01_2021";

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

    /** @var array  */
    protected $dates = [
        'created_at', 'update_at', 'deleted_at'
    ];

    /**
     * get objednavky_id priradene ku produkty_id
     */

    public function objednavky()
    {
        return $this->hasMany(ProduktyObjednavkyPivot::Class, 'produkty_id', 'id');
    }

}
