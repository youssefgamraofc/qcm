<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

  protected $guarded = [];

    public function types($id = null){
      $types = [
        1 => 'تاريخ',
        2 => 'دين',
        3 => 'تقافة عامة',
      ];


      if ($id) {
        return $types[$id];
      }

      return $types;
    }
}
