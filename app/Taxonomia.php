<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class Taxonomia extends Model
{
    protected $fillable = [
        'name', 'filum','familia'
    ];
}