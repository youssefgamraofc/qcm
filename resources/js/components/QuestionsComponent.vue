<template>
    <div class="container">
      <div class="card">
          <div class="card-header text-center h2">Start Now</div>

          <div class="card-body p-5">
            <div class="" v-show="show_results">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Question</th>
                    <th scope="col">Question</th>
                    <th scope="col">Your answer</th>
                    <th scope="col">Correct Answer</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(value, key) in answers">
                    <td>{{key}}</td>
                    <th scope="row">{{value.question}}</th>
                    <td>{{value.answer}}</td>
                    <td>{{value.correct_answer}}</td>

                  </tr>
                </tbody>
              </table>
            </div>
            <div v-show="!show_results" class="row">
              <div class="col-md-6">
                <h3>Select a type please</h3>
                <div class="radio-toolbar-type ">
                  <div class="row">
                    <input  type="radio" id="radio2099" v-model="type" value="99">
                    <label for="radio2099">All</label>

                    <div v-for="(value, key) in types" v-bind:key="key" class="mr-2">
                      <input type="radio" :id="key+'point'" v-model="type" v-bind:value="key" >
                      <label :for="key+'point'">{{value}}</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <h3>How many questions</h3>
                <div class="radio-toolbar-number">
                  <div class="row">

                    <div v-for="(value, key) in available_pagination" v-bind:key="key">
                      <input type="radio" :id="'radio20'+key" v-model="number" v-bind:value="value" >
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
      <div class="modal fade " id="modalr" tabindex="-1" role="dialog" aria-labelledby="modalrTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalrTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{question_key +1}} of {{ 20 }}
              <div >
                <p>Ques {{quest.question}}</p>
                <div class="answers">
                  <div class="radio-toolbar-type ">
                    <div class="row">
                      <div class="mr-2">
                        <input type="radio" :id="'answer1'" v-model="answer" v-bind:value="quest.answer1" >
                        <label :for="'answer1'">{{quest.answer1}}</label>
                      </div>
                      <div class="mr-2">
                        <input type="radio" :id="'answer2'" v-model="answer" v-bind:value="quest.answer2" >
                        <label :for="'answer2'">{{quest.answer2}}</label>
                      </div>
                      <div class="mr-2">
                        <input type="radio" :id="'answer3'" v-model="answer" v-bind:value="quest.answer3" >
                        <label :for="'answer3'">{{quest.answer3}}</label>
                      </div>
                      <div class="mr-2">
                        <input type="radio" :id="'answer4'" v-model="answer" v-bind:value="quest.answer4" >
                        <label :for="'answer4'">{{quest.answer4}}</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <button type="button" class="btn" :class="maximum ? 'btn-outline-success' : 'btn-outline-primary' " @click="maximum ? results() : validateAnswer()">
                {{maximum ? 'SUBTMIT':'NEXT >>'}}
              </button>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">QUIT</button>
              <button type="button" class="btn btn-primary">Save changes</button>
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

          question: {},
          pagination: {},

          show_results: false,
        }
      },
      methods:{
        getTypes(){
          fetch('../api/types/')
            .then(res => res.json())
            .then(res => {
              this.types = res.types;
              this.available_pagination = res.available_pagination;

            })
            .catch(err => console.log(err));
        },
        openModal(){
          $('#modalr').modal('show');
          this.answered_count = "0";
          this.answers = [];
          this.correct = "0";
          this.question_key = "0";
          this.incorrect = "0";
          this.fetchQuestion();
        },
        fetchQuestion(quest_key){
          var self = this;
          let vm = this;

          if (quest_key === "") {
            self.question_key = quest_key;
          }
           // page_url = page_url || '../api/filter/20/99/';

            axios.get('../api/type/'+this.type+'/')
              .then(function (response) {

                self.question = response.data.data;
                self.quest_id = response.data.data[self.question_key]['id'];
                self.correct_answer = response.data.data[self.question_key]['correct_answer'];
                self.quest = self.question[self.question_key];

                // this.setDataForDisplay(response.data.data);

                // console.log(response.data.data[0]['id']);

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
          this.answered_count ++;

          this.new_answer = {
            quest_key: this.question_key,
            id : this.quest_id,
            answer : this.answer,
            question: this.quest.question,
            correct_answer: this.correct_answer,
            correct: this.correct_answer === this.answer,
          };

          this.answers.push(this.new_answer);

          if (this.answer === this.correct_answer) {
            this.correct ++;
          }else{
            this.incorrect ++;
          }

          this.answer = '';

          this.question_key ++;
          this.maximum = this.question_key >= 19;

          this.quest = this.question[this.question_key];
          this.quest_id = this.question[this.question_key]['id'];
          this.correct_answer = this.question[this.question_key]['correct_answer'];

        },
        results(){
          $('#modalr').modal('hide');
          this.show_results = true;
        },

      },
      mounted() {
        this.getTypes();
      }
    }
</script>
