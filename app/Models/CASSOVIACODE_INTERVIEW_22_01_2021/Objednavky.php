<?php

namespace App\Models\cassoviacode_interview_22_01_2021;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Objednavky extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Generate UUID on model creation
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = Str::orderedUuid();
            if(Auth::user()->id) {
                $model->user_id = Auth::user()->id;
            }
        });
    }

    /** @var string  */
    protected $table = 'objednavky';

    /** @var string  */
    protected $connection = "cassoviacode_interview_22_01_2021";

    /** @var string  */
    protected $keyType = 'string';

    /** @var boolean  */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'nazov',
        'popis',
        'dokument_name',
        'dokument_path',
    ];

    /** @var array  */
    protected $dates = [
        'created_at', 'update_at', 'deleted_at'
    ];

    /** @var array  */
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * get produkty_id priradene ku objednavky_id
     */

    public function produkty()
    {
        return $this->hasMany(ProduktyObjednavkyPivot::Class, 'objednavky_id', 'id');
    }


}
