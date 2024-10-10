<?php

namespace App\Models;
use App\Models\ProductsController;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
   
   // use HasFactory;
    protected $fillable = ['Product_name','section_name','description','section_id'];

    public function section()
    {
    return $this->belongsTo('App\Models\sections');
    }
}
