<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Question as QuestionModel;


class Question extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      // return parent::toArray($request);
      $question_m = new QuestionModel();

      return [
        "id" => $this->id,
        "question" => $this->question,
        "correct_answer" => $this->correct_answer,
        "answer1" => $this->answer1,
        "answer2" => $this->answer2,
        "answer3" => $this->answer3,
        "answer4" => $this->answer4,
        "type" => $question_m->types($this->type)
      ];
    }
}
