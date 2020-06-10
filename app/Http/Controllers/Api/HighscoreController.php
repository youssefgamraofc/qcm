<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Highscore;
use App\Question;
use App\Http\Resources\Highscore as HighscoreResource;


class HighscoreController extends Controller
{
    public function index(){
      dd('index');
    }
    public function store(Request $request){
      $question_m = new Question();

      if ($question_m->types($request['type_id']) || $request['type_id'] == 99) {
        if (in_array($request['number_of_questions'], $question_m->available_pagination())) {
          $validatedData = $request->validate([
            'type_id' => 'required', 'integer',
            'name' => 'required', 'min:4', 'max:15',
            'email' => 'required', 'email:rfc,dns',
            'score' => 'required', 'integer',
            'number_of_questions' => 'required', 'integer',
          ]);

          Highscore::create([
            'type_id' => $request['type_id'],
            'user_name' => $request['name'],
            'email' => $request['email'],
            'score' => $request['score'],
            'number_of_questions' => $request['number_of_questions'],
          ]);
        }


      }
    }
}
