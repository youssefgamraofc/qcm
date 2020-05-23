@extends('layouts.app')

@section('content')
<div class="container" id="question-shoow">
  <table class="table table-striped table-hover">
    <thead>
        <tr>
          <th scope="col">Question</th>
          <th scope="col">Answer 1</th>
          <th scope="col">Answer 2</th>
          <th scope="col">Answer 3</th>
          <th scope="col">Answer 4</th>
        </tr>
    </thead>
    <tbody>
      @foreach($questions as $question)
        <tr class="text-center">
          <td>{{$question->question}}</td>
          <td class="{{$question->answer1 == $question->correct_answer? 'bg-success' : ''}}">
            {{$question->answer1}}
          </td>
          <td class="{{$question->answer2 == $question->correct_answer? 'bg-success' : ''}}">
            {{$question->answer2}}
          </td>
          <td class="{{$question->answer3 == $question->correct_answer? 'bg-success' : ''}}">
            {{$question->answer3}}
          </td>
          <td class="{{$question->answer4 == $question->correct_answer? 'bg-success' : ''}}">
            {{$question->answer4}}
          </td>

        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
