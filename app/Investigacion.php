<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class Investigacion extends Model
{
    protected $fillable = [
        'nombre', 'fecha','descripcion'
    ];
}