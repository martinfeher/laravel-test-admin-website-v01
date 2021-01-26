<?php

namespace App\Models\cassoviacode_interview_22_01_2021;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCompositePrimaryKeyTrait;

class ProduktyObjednavkyPivot extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string  */
    protected $table = 'produkty_objednavky_pivot';

    /** @var string  */
    protected $connection = "cassoviacode_interview_22_01_2021";

    /** @var string  */
    public $primaryKey = ['produkty_id', 'objednavky_id'];

    /** @var bool  */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'produkty_id',
        'objednavky_id',
    ];



    /** @var array  */
    protected $dates = [
        'created_at', 'update_at', 'deleted_at'
    ];



}
