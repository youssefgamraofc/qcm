<template>
    <div class="container">
        <div class="row justify-content-center">
          <h3 class="text-center">Highscore</h3>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Info</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="highscore in all_highscores">
                <td>

                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{highscore.name}}</li>
                    <li class="list-group-item">at: {{highscore.created_at}}</li>
                  </ul>
                </td>
                <td>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Type: {{highscore.type}}</li>
                    <li class="list-group-item">Number of questions: {{highscore.number_of_questions}}</li>
                    <li class="list-group-item">Accuracy: {{highscore.score+"%"}}</li>
                  </ul>

                </td>
              </tr>
            </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
      data(){
        return{
          all_highscores: {},
        }
      },
      methods:{
        getAllQuestions(){
          var self = this;
          axios.get('../api/highscore/')
            .then(function (response) {

              self.all_highscores = response.data.data;

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
      },
      mounted() {
        this.getAllQuestions()
        console.log('Component mounted.')
      }
    }
</script>
