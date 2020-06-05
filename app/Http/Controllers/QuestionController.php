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
      $count = Question::all()->count();
      $question_m = new Question();


      return view('questions.index',[
        'questions' => $questions,
        'question_m' => $question_m,
        'count_q' => $count,
      ]);
    }

    public function questionsByType($id){
      $question_m = new Question();

      if ($question_m->types($id)) {
        $questions = $question_m ->getQuestionsByType($id);

        return view('questions.type',[
          'questions' => $questions,
          'question_m' => $question_m,
        ]);

      }

      return abort(404);
    }

    public function reported(){
      $question_m = new Question();
      

      $questions = Question::where('reported' ,'1')
                              ->inRandomOrder()
                              ->paginate(20);

      return view('questions.reported',[
        'questions' => $questions,
        'question_m' => $question_m,

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
        'question' => 'required|unique:questions',
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
        $question = Question::findOrFail($id);
        $question_m = new Question();


        return view('questions.show',[
          'question' => $question,
          'types' => $question_m->types(),

        ]);
    }

    public function validation(){
      $non_validated = Question::where('validated', '0')->paginate(20);
      $question_m = new Question();
      $count = Question::where('validated', '0')->count();



      return view('questions.validation', [
        'non_validated' => $non_validated,
        'types' => $question_m->types(),
        'count_q' => $count,

      ]);
    }
    public function validated(){
      $validated = Question::where('validated', '1')->paginate(20);
      $question_m = new Question();
      $count = Question::where('validated', '1')->count();

      return view('questions.validated', [
        'validated' => $validated,
        'types' => $question_m->types(),
        'count_q' => $count,

      ]);
    }

    public function validate_quest(Request $request, $id){
      $validation = Question::findOrFail($id);

      $data = [
        'validated' => 1,
      ];

      $question_m = new Question();
      $affected = $question_m->where('id', $id)->update($data);

      return back()->with('message_success', 'Validated Successfully');

    }

    public function invalidate_quest(Request $request, $id){
      $validation = Question::findOrFail($id);

      $data = [
        'validated' => "0",
      ];

      $question_m = new Question();
      $affected = $question_m->where('id', $id)->update($data);

      return back()->with('message_success', 'Invalidated Successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $question = Question::findOrFail($id);
      $question_m = new Question();

      return view('questions.edit', [
        'quest' => $question,
        'types' => $question_m->types(),
      ]);
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
      $question = Question::findOrFail($id);

      $validatedData = $request->validate([
        'question' => ['required','unique:questions,question,'.$question->id],
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

       $question_m = new Question();

       $updated = $question_m->where('id', $id)->update($data);

       return back()->with('message_success', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        Question::where('id', $id)->delete($id);

        return back()->with('message_success', 'Successfully DELETED');

    }
}
