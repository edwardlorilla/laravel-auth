<template>
    <v-card v-if="edit$">
        <v-card-title>
            <span class="headline">User Profile</span>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" v-model.number="edit$.school_year_start" label="school year start"
                                      required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" v-model.number="edit$.school_year_end" label="school year end"
                                      :max="maxDate" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-select
                                :items="getUser"
                                v-model.number="edit$.user_id"
                                label="User"
                                single-line
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-select
                                :items="[{value: 1, text: '1st semester'}, {value: 2, text: '2nd semester'}]"
                                v-model.number="edit$.semester"
                                label="Semester"
                                single-line
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min="1" max="10" v-model.number="edit$.target" label="TARGET"
                                      required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min="1" max="10" v-model.number="edit$.ceta" label="CETA" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min="1" max="10" v-model.number="edit$.etd" label="ETD" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min="1" max="10" v-model.number="edit$.etp" label="ETP" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min="1" max="10" v-model.number="edit$.ets" label="ETS" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min="1" max="10" v-model.number="edit$.etse" label="ETSE" required/>
                    </v-flex>
                </v-layout>
            </v-container>
            <small>*indicates required field</small>
        </v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" :disabled="isDisabled" flat @click.native="$router.push('/performances')">Cancel</v-btn>
            <v-btn color="blue darken-1" :disabled="isDisabled" flat @click.native="update$">Save</v-btn>
        </v-card-actions>
    </v-card>
</template>
<script>
    import {put} from './../helper/api'
    export default{
        data(){
          return{
              isDisabled: false,
              maxDate: _.parseInt(new Date().getFullYear() + 1),
          }
        },
        computed: {
            edit$(){
                var vm = this
                return _.clone(_.find(this.$root.$data.performances, ['id', _.parseInt(vm.$route.params.id)]))
            },
            getUser(){
                var vm = this
                return _.map(vm.$root.$data.users, function (data) {
                    return {
                        text: `${data.first_name} ${data.last_name}`,
                        value: data.id
                    }
                })
            }
        },

        methods: {
            update$(){
                var vm = this
                vm.isDisabled = true
                put(`/api/performances/${vm.$route.params.id}`, vm.edit$).then(function (response) {
                    var index = _.findIndex(vm.$root.$data.performances, ['id', _.parseInt(vm.$route.params.id)]);
                    vm.$set(vm.$root.$data.performances, index, response.data)
                    vm.$root.successResponse('Edited A Performance')
                    vm.isDisabled = false
                    vm.$router.push('/performances')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                });
            }
        }
    }
</script>
