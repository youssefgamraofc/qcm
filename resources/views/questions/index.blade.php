@extends('layouts.app')

@section('content')
<div class="container" id="question-shoow">
  <h3 class="text-center">All Questions {{$count_q}}</h3>

  <table class="table table-striped table-hover table-bordered ">
    <thead>
        <tr>
          <th scope="col">Question</th>
          <th scope="col">Type</th>

          <th scope="col">Answer-1</th>
          <th scope="col">Answer-2</th>
          <th scope="col">Answer-3</th>
          <th scope="col">Answer-4</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
      @foreach($questions as $question)
        <tr class="text-center {{!$question->validated? 'bg-warning' : ''}}">
          <td>{{$question->question}}</td>
          <td><b>
            {{$types[$question->type]}}
          </b></td>
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
              @if(!$question->validated)
                <form action="{{action('QuestionController@validate_quest', $question->id)}}" method="post">
                  @csrf
                  @method('PATCH')

                  <button type="submit" class="btn btn-sm btn-outline-dark" name="button">Validate</button>
                </form>
              @else
              <form action="{{action('QuestionController@invalidate_quest', $question->id)}}" method="post">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-sm btn-outline-dark" name="button">Invalidate</button>
              </form>
              @endif
              <a href="{{action('QuestionController@edit', $question->id)}}" class="btn btn-sm btn-info">Edit</a>
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
   {{ $questions->links() }}
</div>
@endsection
