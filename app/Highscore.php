<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Highscore extends Model
{
  protected $guarded = [];


  public function getAll(){
    return $this::latest()->paginate(20);
  }

}
