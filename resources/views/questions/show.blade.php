@extends('layouts.app')

@section('content')
<div class="container ">
  @auth
  <div class="row justify-content-center show-quest">
      <div class="col-md-10">
        <a href="{{action('QuestionController@show', $question->id-1)}}" class="float-left"> << previous</a>
        <a href="{{action('QuestionController@show', $question->id+1)}}" class="float-right">next >> </a>
        <br>
          <div class="card">
              <div class="card-header">
                <h3 class="float-left">Question {{$question->id}}</h3>
                <div class="float-right">
                  @if(!$question->validated)
                    <form action="{{action('QuestionController@validate_quest', $question->id)}}" method="post">
                      @csrf
                      @method('PATCH')

                      <button type="submit" class="btn btn-sm btn-success" name="button">Validate</button>
                    </form>
                  @else
                  <form action="{{action('QuestionController@invalidate_quest', $question->id)}}" method="post">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="btn btn-sm btn-outline-dark" name="button">Invalidate</button>
                  </form>
                  @endif
                </div>
                <a href="{{action('QuestionController@edit', $question->id)}}" class="btn btn-sm btn-info float-right mx-1">Edit</a>

                <div class="float-right">

                  <form action="{{action('QuestionController@destroy', $question->id)}}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm btn-danger" name="button">DELETE</button>
                  </form>
                </div>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-7">
                    <div class="row">
                      <dt class="col-sm-4">Question:</dt>
                        <dd class="col-sm-8">{{$question->question}}</dd>

                        <dt class="col-sm-4">Answers:</dt>
                        <dd class="col-sm-8">
                          <ul>
                            <li class="{{$question->answer1 == $question->correct_answer ? 'text-success' : ''}}">{{$question->answer1}}</li>
                            <li class="{{$question->answer2 == $question->correct_answer ? 'text-success' : ''}}">{{$question->answer2}}</li>
                            <li class="{{$question->answer3 == $question->correct_answer ? 'text-success' : ''}}">{{$question->answer3}}</li>
                            <li class="{{$question->answer4 == $question->correct_answer ? 'text-success' : ''}}">{{$question->answer4}}</li>
                          </ul>
                        </dd>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="row">
                      <dt class="col-sm-5">Type:</dt>
                      <dd class="col-sm-7">{{$types[$question->type]}}</dd>

                      <dt class="col-sm-5">Validated:</dt>
                      <dd class="col-sm-7">{{$question->validated ? 'Valid' : 'Non Valid'}}</dd>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  @endauth
</div>
@endsection
