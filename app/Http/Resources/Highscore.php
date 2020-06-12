<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Highscore as HighscoreModel;
use App\Question as QuestionModel;


class Highscore extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $question_m = new QuestionModel();
        // return parent::toArray($request);
        return [
          "id" => $this->id,
          "name" => ucwords($this->user_name),
          "type" => $question_m->types($this->type_id),
          "type_id" => $this->type_id,
          "score" => $this->score,
          "number_of_questions" => $this->number_of_questions,
          "number_of_questions" => $this->number_of_questions,
          "created_at" => date('d M Y - H:i:s', $this->created_at->timestamp),
        ];
    }
}
