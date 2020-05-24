@extends('layouts.app')

@section('content')
<div class="container" id="question-shoow">
  <h3 class="text-center">Non Valid Questions: {{$count_q}}</h3>

  <table class="table table-striped table-hover">
    <thead>
        <tr>
          <th scope="col">Question</th>
          <th scope="col">types</th>
          <th scope="col">Answer 1</th>
          <th scope="col">Answer 2</th>
          <th scope="col">Answer 3</th>
          <th scope="col">Answer 4</th>
          <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
      @foreach($non_validated as $question)
        <tr class="text-center">
          <td>{{$question->question}}</td>
          <td>{{$types[$question->type]}}</td>
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
          <td>
            <form action="{{action('QuestionController@validate_quest', $question->id)}}" method="post">
              @csrf
              @method('PATCH')

              <button type="submit" class="btn btn-sm btn-outline-dark" name="button">Validate</button>
            </form>
            <a href="{{action('QuestionController@edit', $question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>
          </td>
          <td>
            <a href="{{action('QuestionController@show', $question->id)}}" class="btn btn-sm btn-outline-info">Show</a>

            <form action="{{action('QuestionController@destroy', $question->id)}}" method="post">
              @csrf
              @method('DELETE')

              <button type="submit" class="btn btn-sm btn-danger" name="button">DELETE</button>
            </form>
          </td>

        </tr>
      @endforeach
    </tbody>
  </table>
   {{ $non_validated->links() }}
</div>
@endsection
