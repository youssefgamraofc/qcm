<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $questions = Question::inRandomOrder()->paginate(20);
      return view('questions.index',[
        'questions' => $questions,
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $question_m = new Question();
      $types = $question_m->types();
      return view('questions.create', [
        'types' => $types,
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'question' => 'required',
        'answer1' => 'required',
        'answer2' => 'required',
        'answer3' => 'required',
        'answer4' => 'required',
        'correct_answer' => 'required|numeric',
        'type' => 'required|numeric',
       ]);

       $correct_answer = '';
       switch ($request->input('correct_answer')) {
         case 1:
          $correct_answer =  $request->input('answer1');
          break;
         case 2:
          $correct_answer =  $request->input('answer2');
          break;
         case 3:
          $correct_answer =  $request->input('answer3');
          break;
         case 4:
          $correct_answer =  $request->input('answer4');
          break;

         default:
          $correct_answer =  $request->input('answer4');

          break;
       }

       $data = [
         'question' => $request->input('question'),
         'answer1' => $request->input('answer1'),
         'answer2' => $request->input('answer2'),
         'answer3' => $request->input('answer3'),
         'answer4' => $request->input('answer4'),
         'type' => $request->input('type'),
         'correct_answer' => $correct_answer,
       ];

        $question = Question::create($data);

        return back()->with('message_success', 'Success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
