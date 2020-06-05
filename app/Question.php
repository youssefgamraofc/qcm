<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

  protected $guarded = [];


  public $limit = 20;

    public function types($id = null){
      $types = [
        1 => 'تاريخ',
        2 => 'دين',
        3 => 'تقافة عامة',
        4 => 'المغرب',
      ];


      if ($id) {
        return $types[$id];
      }

      return $types;
    }

    public function getQuestionsByType($type){
      if (is_numeric($type) && $this->types($type)) {
        return $this::where('type', $type)->inRandomOrder()->paginate(20);
      }
      return '';
    }

    public function countQuestionsByType($type){
      if (is_numeric($type) && $this->types($type)) {
        return $this::where('type', $type)->get()->count();
      }
      return '';
    }

    public function available_pagination(){
      return [20,30,40,50];
    }
}
