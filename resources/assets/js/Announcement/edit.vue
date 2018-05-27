
<template>
    <v-card v-if="edit$">
        <v-card-title>
            <span class="headline">Announcement</span>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="edit$.title" label="title" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="edit$.description" label="description"/>
                    </v-flex>
                </v-layout>
            </v-container>
            <small>*indicates required field</small>
        </v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="update$">Save</v-btn>
        </v-card-actions>
    </v-card>
</template>
    <script>
        import {put} from './../helper/api'
        export default{
            computed:{
              edit$(){
                  var vm = this
                  return _.clone(_.find(this.$root.$data.announcements, ['id', _.parseInt(vm.$route.params.id)]))
              }
            },
            methods: {
                update$(){
                    var vm = this
                    put(`/api/announcements/${vm.$route.params.id}`, vm.edit$).then(function (response) {
                        var index = _.findIndex(vm.$root.$data.announcements, ['id', _.parseInt(vm.$route.params.id)]);
                        console.log(index)
                        vm.$set(vm.$root.$data.announcements, index, response.data)
                        vm.$root.successResponse('Edited A Announcement')
                    }).catch(function (_ref2) {
                        vm.$root.errorResponse(_ref2)
                    });
                }
            }
        }
</script>
