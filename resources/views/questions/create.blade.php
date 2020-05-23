@extends('layouts.app')

@section('content')
<div class="container">
  @auth
  <div class="row justify-content-center">
      <div class="col-md-10">
          <div class="card">
              <div class="card-header">
                <h3>Add a question</h3>
              </div>

              <div class="card-body">
                <form class="add-form" action="{{action('QuestionController@store')}}" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="question">Question</label>
                    <input type="text" class="form-control" id="question" name="question" value="{{old('question')}}">
                  </div>
                  <small id="" class="form-text text-danger">{{ $errors->first('question') }}</small>

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="answer1">Answer 1</label>
                        <input type="text" class="form-control" id="answer1" name="answer1" value="{{old('answer1')}}">
                        <small id="" class="form-text text-danger">{{ $errors->first('answer1') }}</small>

                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_answer" id="correct_answer" value="1">
                        <label class="form-check-label" for="correct_answer">
                          Correct
                        </label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="answer2">Answer 2</label>
                        <input type="text" class="form-control" id="answer2" name="answer2" value="{{old('answer2')}}">
                        <small id="" class="form-text text-danger">{{ $errors->first('answer2') }}</small>

                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_answer" id="correct_answer2" value="2">
                        <label class="form-check-label" for="correct_answer2">
                          Correct
                        </label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="answer3">Answer 3</label>
                        <input type="text" class="form-control" id="answer3" name="answer3" value="{{old('answer3')}}">
                        <small id="" class="form-text text-danger">{{ $errors->first('answer3') }}</small>

                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_answer" id="correct_answer3" value="3">
                        <label class="form-check-label" for="correct_answer3">
                          Correct
                        </label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="answer4">Answer 4</label>
                        <input type="text" class="form-control" id="answer4" name="answer4" value="{{old('answer4')}}">
                        <small id="" class="form-text text-danger">{{ $errors->first('answer4') }}</small>

                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_answer" id="correct_answer4" value="4">
                        <label class="form-check-label" for="correct_answer4">
                          Correct
                        </label>
                      </div>
                    </div>
                    <small id="" class="form-text text-danger">{{ $errors->first('correct_answer') }}</small>

                  </div>

                  <br>
                  <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control w-50" name="type">
                      @foreach($types as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                    </select>
                    <small id="" class="form-text text-danger">{{ $errors->first('type') }}</small>

                  </div>

                  <button type="submit" class="btn btn-lg btn-outline-primary" name="button">Submit</button>
                </form>
              </div>
          </div>
      </div>
  </div>
  @endauth
</div>
@endsection
