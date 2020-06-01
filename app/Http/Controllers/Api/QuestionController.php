<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\Http\Resources\Question as QuestionResource;

class QuestionController extends Controller
{
    public function index(){
      return $this->getAllQuestions('all');
    }

    public function filter($pagination, $type){
      $question_m = new Question();

      if (is_numeric($type) && is_numeric($pagination)) {
        if (in_array($type, array_keys($question_m->types())) || $type == 99) {
          if (in_array($pagination, $question_m->available_pagination())) {
            if ($type == 99) {
              $questions = Question::inRAndomOrder()
                                    ->limit($pagination)
                                    ->get();


            }else {
              $query = Question::where('type', $type)
                                    ->limit($pagination)
                                    ->get();
            }

            return QuestionResource::collection($questions);

          }
        }
      }

      return 'Something is wrong';
    }
    
    public function getAllQuestions($limit){
      if (is_numeric($limit) && $limit < 60 ) {
        $questions = Question::limit($limit)->get();
        return QuestionResource::collection($questions);
      }elseif ($limit == 'all') {
        $questions = Question::all();
        return QuestionResource::collection($questions);
      }

      return false;
    }

    public function getQuestionsByType($type){
      $question_m = new Question();
      if (is_numeric($type)) {
        if (in_array($type, array_keys($question_m->types()))) {

          $questions = Question::where('type', $type)->inRAndomOrder()->limit($question_m->limit)->get();
          return QuestionResource::collection($questions);

        }elseif ($type == 99) {
          $questions = Question::inRAndomOrder()->limit($question_m->limit)->get();

          return QuestionResource::collection($questions);

        }
      }

      return false;
    }

    public function show($id){
      $question = Question::findOrFail($id);

      return (new QuestionResource($question));
    }

    public function showTypes(){
      $question = Question::limit(1)->first();
      $question_m = new Question();

      return (new QuestionResource($question))
                  ->additional([
                    'types' => $question_m->types(),
                    'available_pagination' => $question_m->available_pagination(),
                  ]);

    }
}
