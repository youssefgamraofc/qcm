<template>
    <div class="container">
      <div class="wrapper">
          <div class="card-header text-center">
            <div v-show="show_results">

            <h3>Results</h3>
            <a href="#" @click="newQuiz">
              <h6>
                Start new Quiz
              </h6>
            </a>

            </div>

            <h3 v-show="!show_results">QCM Maroc</h3>
          </div>

          <div class="card-body">
            <div class="results" v-show="show_results">
              <div class="row">
                <div class="col-md-6">
                  <p>Correct Answers: {{correct}}</p>
                  <p>Incorrect Answers: {{incorrect}}</p>
                </div>
                <div class="col-md-6">
                  <p class="percentage" :class="correct_percentage >= 50 ? 'text-success':'text-warning'">{{correct_percentage}} <span>%</span> </p>
                </div>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Question</th>
                    <th scope="col">Your answer</th>
                    <th scope="col">Correct Answer</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(value, key) in answers" :class="value.answer === value.correct_answer? 'bg-success': 'bg-warning'">
                    <th class="question-field">{{value.question}}</th>
                    <td class="answer-field">{{value.answer}}</td>
                    <td class="correct-answer-field">{{value.correct_answer}}</td>
                    <td class="report-field">
                      <button type="button" class="btn btn-sm btn-outline-secondary" name="button" @click="reportQuestion(value.id)">Report</button>
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>
            <div v-show="!show_results" class="row selection-wrapper">
              <div class="col-md-6">
                <h3>Select a type</h3>
                <div class="radio-toolbar-type ">
                  <div class="row">
                    <input  type="radio" id="radio2099" v-model="type" value="99" @click="checkedType">
                    <label for="radio2099">All</label>

                    <div v-for="(value, key) in types" v-bind:key="key" class="mr-2">
                      <input type="radio" :id="key+'point'" v-model="type" v-bind:value="key" @click="checkedType">
                      <label :for="key+'point'">{{value}}</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 number-questions">
                <h3>How many questions</h3>
                <div class="radio-toolbar-number">
                  <div class="row">

                    <div v-for="(value, key) in available_pagination" v-bind:key="key" v-if="showPagination(value)">
                      <input type="radio" :id="'radio20'+key" v-model="number" v-bind:value="value" :disabled="!showPagination(value)">
                      <label :for="'radio20'+key">{{value}}</label>
                    </div>
                  </div>

                </div>
              </div>

              <button type="button" @click="openModal" name="button" class="mb-3 btn btn-lg btn-outline-primary w-100">START</button>
            </div>
          </div>


      </div>



    <!-- Modal -->
    <div class="modal fade" id="highscoremodal" tabindex="-1" role="dialog" aria-labelledby="highscoremodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="highscoremodalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="addToHighscore">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="name"  v-model="form.name"
                :class="{ 'is-invalid': form.errors.has('name') }">
                <small id="name" class="form-text text-muted">Your name will be shown in the highscore board.</small>
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="email" v-model="form.email"
                :class="{ 'is-invalid': form.errors.has('email') }">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                <has-error :form="form" field="email"></has-error>

              </div>

               <button :disabled="form.busy" type="submit" class="btn btn-outline-primary btn-block btn-lg">Submit</button>

            </form>
          </div>
        </div>
      </div>
    </div>



      <!-- Modal -->
      <div class="modal fade " id="modalr" tabindex="-1" role="dialog" aria-labelledby="modalrTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="col-12 modal-title text-center" id="modalrTitle"> {{quest.question}}</h3>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="paginate float-left">
                {{question_key > number ? number :  question_key +1}} of {{ number }}
              </p>
              <button type="button" class="btn btn-sm btn-outline-secondary float-right" name="button" @click="reportQuestion(quest.id)">Report</button>

              <div class="question-wrapper">
                <div class="answers">
                  <div class="radio-toolbar-type ">
                    <div class="row">
                      <div class="col text-center">
                        <div class="mr-2 col">
                          <input type="radio" :id="'answer1'" v-model="answer" v-bind:value="quest.answer1" >
                          <label :for="'answer1'">{{quest.answer1}}</label>
                        </div>
                        <div class="mr-2 col">
                          <input type="radio" :id="'answer2'" v-model="answer" v-bind:value="quest.answer2" >
                          <label :for="'answer2'">{{quest.answer2}}</label>
                        </div>
                        <div class="mr-2 col">
                          <input type="radio" :id="'answer3'" v-model="answer" v-bind:value="quest.answer3" >
                          <label :for="'answer3'">{{quest.answer3}}</label>
                        </div>
                        <div class="mr-2 col">
                          <input type="radio" :id="'answer4'" v-model="answer" v-bind:value="quest.answer4" >
                          <label :for="'answer4'">{{quest.answer4}}</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <button type="button" class="btn justify-content-center w-100 validation-button" :class="'btn-outline-primary' " @click="validateAnswer()">
                  {{'VALIDATE &gt;&gt;'}}
                </button>
                <button type="button" class="btn justify-content-center w-100" v-show="maximum" :class="maximum ? 'btn-outline-success' : 'btn-outline-primary' " @click="maximum ? results() : validateAnswer()">
                  {{maximum ? 'SUBTMIT':'VALIDATE &gt;&gt;'}}
                </button>
                <br><br>

                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">

                    <li class="page-item" v-for="n in 5" :class="paginationStatus(n,Number(question_key)+1)">
                      <a class="page-link" @click="switchToAnsweredQuestion(n,'0')" href="#">{{n}}</a>
                    </li>

                  </ul>
                  <ul class="pagination justify-content-center" v-for="m in 9">
                    <li class="page-item" v-for="n in 5" :class="paginationStatus(n+5*m,Number(question_key)+1)" v-if="n+5*m <= number">
                      <a class="page-link" @click="switchToAnsweredQuestion(n,5*m)" href="#">{{n+5*m}}</a>
                    </li>
                  </ul>

                </nav>

              </div>



            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeModal">QUIT</button>
            </div>
          </div>
        </div>
      </div>

    </div>
</template>

<script>

// I couldnot find a way to limit and paginate
// therefor im going to use vue to check if the user has reached the number of quesiton that they want
// E.G if(answered_questions_count == number) then the next button should be disabled
//The best way is to use the next & previous functionality thath I used in the ecommerce app
//There is a problem that I can't control the number of questions
// UNIQID **

    export default {
      data(){
        return{
          //To bind the question type & number of questions
          type:'99',
          number: '20',

          // To bind the answer givven
          answer : '',
          // To validate the data
          quest_id : '',
          correct_answer : '',
          answered_count: '0',
          correct: '0',
          incorrect: '0',

          // All the answers must be stored here first
          new_answer: {},
          //Then they must be pushed to the final array
          answers: [],

          //to disable the next button and enable the submit one
          maximum: false,

          question_key: '0',
          quest: '',

          types: {},
          available_pagination: {},
          paginations: {},

          question: {},
          pagination: {},

          show_results: false,

          // Incase the user changed their answer
          submitted_answer: '',

          // Incase the user tried to check on validate more than 10 times
          validate_count: "0",

          correct_percentage: '',

          // THe form to add user to the hishscore board

          form: new Form({
             name: '',
             email: '',
             score: '',
             number_of_questions: '',
             type_id: '',
           }),

           clicked: '0'

        }
      },
      methods:{
        getTypes(){
          fetch('../api/types/')
            .then(res => res.json())
            .then(res => {
              this.types = res.types;
              this.available_pagination = res.available_pagination;
              this.paginations = res.paginations;

            })
            .catch(err => console.log(err));
        },
        openModal(){
          this.$Progress.start();

          $('#modalr').modal('show');
          this.answered_count = "0";
          this.answers = [];
          this.correct = "0";
          this.question_key = "0";
          this.incorrect = "0";
          this.fetchQuestion();
          this.$Progress.finish();

          this.form.type_id = this.type;
          this.form.number_of_questions = this.number;



        },
        fetchQuestion(quest_key){
          var self = this;
          let vm = this;

          if (quest_key === "") {
            self.question_key = quest_key;
          }
           // page_url = page_url || '../api/filter/20/99/';

            axios.get('../api/filter/'+this.number+'/'+this.type+'/')
              .then(function (response) {

                self.question = response.data.data;
                self.quest_id = response.data.data[self.question_key]['id'];
                self.correct_answer = response.data.data[self.question_key]['correct_answer'];
                self.quest = self.question[self.question_key];

                // this.setDataForDisplay(response.data.data);


              })
              .catch(function (error) {
                // handle error
                console.log(error);
              })
              .then(function () {
                // always executed
              });


        },

        validateAnswer(){
          this.$Progress.start();

          // Checking the answer
          if (this.answer === this.quest['answer1']) {
            console.log('Answer1');
            console.log(this.answer);
          }else if (this.answer === this.quest['answer2']) {
            console.log('Answer2');
          }else if (this.answer === this.quest['answer3']) {
            console.log('Answer3');
          }else if (this.answer === this.quest['answer4']) {
            console.log('Answer4');

          }else if (!this.answer) {

          }else {
            window.location.replace("404");
          }

          if (this.answers[this.question_key]) {
            //WHEN Modifying the answer

            console.log('already answered ' + this.question_key);
            this.answers[this.question_key]['answer'] = this.answer;
            this.answers[this.question_key]['correct'] = this.correct_answer === this.answer;
            this.question_key = this.answers.length;

            if (this.question_key >= this.number) {
              this.question_key  = this.number;
              console.log("yeeap triggeresd");
            }

          }else if (!this.answers[this.question_key] && this.question_key >= this.number) {
            // console.log("SOmething really weaird is happening");
            this.validate_count++;
            if (this.validate_count == 10) {
              this.results();
            }
          }
          else {
            // If the answer is a new Answer

            this.new_answer = {
              quest_key: this.question_key,
              id : this.quest_id,
              answer : this.answer,
              question: this.quest.question,
              correct_answer: this.correct_answer,
              correct: this.correct_answer === this.answer,
            };

            this.answers.push(this.new_answer);
            this.answered_count ++;


            // If the user reach the last question then set maximum to true
            this.question_key+1 >=  Number(this.number) ? this.maximum = true : this.question_key ++;
          }


          this.answer = '';

          if (!this.maximum) {
            this.quest = this.question[this.question_key];
            this.quest_id = this.question[this.question_key]['id'];
            this.correct_answer = this.question[this.question_key]['correct_answer'];
          }

          this.$Progress.finish();

        },
        results(){
          this.$Progress.start();

          $('#modalr').modal('hide');

          var index, len;
          for (index = 0, len = this.answers.length; index < len; ++index) {
            if (this.answers[index]['correct']) {
              this.correct ++;
            }else {
              this.incorrect ++;
            }
          }

          this.correct_percentage = this.correct * 100 / this.number;
          this.show_results = true;

          if (this.correct_percentage) {

            this.form.score = this.correct_percentage;


            confirmationQuit.fire({
              title: 'Congratulation',
              text: "Would you like to add your name in the board with the winners?",
              icon: 'success',
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                $('#highscoremodal').modal('show');

              } else if (
                /* Read more about handling dismissals below */
                result.dismiss === swal.DismissReason.cancel
              ) {
                confirmationHighscore.fire(
                  'Cancelled',
                  'Your imaginary file is safe :)',
                  'error'
                )
              }
            })
          }

          this.$Progress.finish();

        },
        paginationStatus(n, key){
          if (key === n || n == this.answered_count+1) {
            if (n <= this.number) {
              return 'active';
            }
          }else if (key < n && !this.answers[n-1] || n > this.number) {
            return 'disabled';
          }else if (key > n || this.answers[n-1]) {
            if (this.answers[n-1]['answer'] ) {
              return 'answered';
            }
          }



        },
        switchToAnsweredQuestion(key, n){

          key = key + Number(n) - 1;
          if (key <= this.answered_count) {

            this.quest = this.question[key];
            this.quest_id = this.question[key]['id'];
            this.correct_answer = this.question[key]['correct_answer'];
            this.answer = this.answers[key] ? this.answers[key]['answer'] : '';
            this.question_key = key;
          }

        },

        setQuestionByKey(key){
          this.quest = this.question[key];
          this.quest_id = this.question[key]['id'];
          this.correct_answer = this.question[key]['correct_answer'];
        },
        newQuiz(){
          window.location.reload();
        },
        reportQuestion(id){
          this.$Progress.start();
          this.validate_count++;

          if (this.validate_count++ === 10) {
            window.location.replace("404");
          }

          axios({
            method: 'put',
            url: '../api/report/'+id+'/',
            data: {
              report: 'true',
            }
          })
          .then(function () {
            toast.fire({
              icon: 'success',
              title: 'We will review your report, Thank You'
            });
          });

          this.$Progress.finish();

        },

        closeModal(){
          confirmationQuit.fire({
            title: 'Are you sure?',
            text: "You will lose all the data",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Quit',
            cancelButtonText: 'Cancel',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
              $('#modalr').modal('hide');
            } else if (
              /* Read more about handling dismissals below */
              result.dismiss === swal.DismissReason.cancel
            ) {
            }
          })
        },
        addToHighscore(){

          console.log('hiiiiiiiiiiiit');
          // Submit the form via a POST request
          this.form.post('api/highscore')
          .then(
            $('#highscoremodal').modal('hide'),

            toast.fire({
               icon: 'success',
               title: 'You were added to the board,'
             })
           )
          .catch(()=>{
            toast.fire({
               icon: 'warning',
               title: 'SOmething wrong,'
             })
          })
        },
        showPagination(key){
          if (this.type == 99 ) {
            return true;
          }
          else if (key <= this.paginations[this.type]) {
            return true;
          }
          return false;
        },
        checkedType(id){
          this.clicked++;
          if (this.clicked > 10) {
            window.location.replace("404");
          }
        },
      },
      mounted() {
        this.getTypes();
      }
    }
</script>
