<template>
    <v-card>
        <v-card-title>
            <span class="headline">Evaluate Performance</span>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" v-model.number="create$.school_year_start" label="school year start" required/>
                    </v-flex><v-flex xs12 sm6 md4>
                        <v-text-field type="number" v-model.number="create$.school_year_end" label="school year end" :max="maxDate" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-select
                                :items="getUser"
                                v-model.number="create$.user_id"
                                label="User"
                                single-line
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-select
                                :items="[{value: 1, text: '1st semester'}, {value: 2, text: '2nd semester'}]"
                                v-model.number="create$.semester"
                                label="Semester"
                                single-line
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min='1' max="10" v-model.number="create$.target" label="TARGET" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min='1' max="10" v-model.number="create$.ceta" label="CETA" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min='1' max="10" v-model.number="create$.etd" label="ETD" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min='1' max="10" v-model.number="create$.etp" label="ETP" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min='1' max="10" v-model.number="create$.ets" label="ETS" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field type="number" min='1' max="10" v-model.number="create$.etse" label="ETSE" required/>
                    </v-flex>
                </v-layout>
            </v-container>
            <small>*indicates required field</small>
        </v-card-title>
        <v-card-actions>

            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" :disabled="isDisabled" flat @click.native="store$">Save</v-btn>
            <v-btn color="blue darken-1" :disabled="isDisabled" flat @click.native="$router.push('/performances')">Cancel</v-btn>
        </v-card-actions>
    </v-card>
</template>
<script>
    import {post} from './../helper/api'
    export default{
        data(){
            return {
                isDisabled: false,
                maxDate: _.parseInt(new Date().getFullYear() + 1),
                create$: {

                    school_year_start: _.parseInt(new Date().getFullYear()),
                    school_year_end: _.parseInt(new Date().getFullYear() + 1),
                    semester: 1,
                    user_id: 0,
                    target: 0,
                    ceta: 0,
                    etd: 0,
                    etp: 0,
                    ets: 0,
                    etse: 0,
                }
            }
        },
        mounted(){
        },
        computed:{
            getUser(){
                var vm = this
                return _.map(vm.$root.$data.users, function(data){
                    return {
                        text: `${data.first_name} ${data.last_name}`,
                        value: data.id
                    }
                })
            }
        },
        methods: {
            store$(){
                var vm = this

                vm.isDisabled = true
                post('/api/performances', vm.create$).then(function (response) {
                    var index = _.findIndex(vm.$root.$data.performances, ['id', response.data.id]);
                    console.log(index)
                    if (-1 != index) {
                        vm.$set(vm.$root.$data.performances, index, response.data)
                    } else {
                        vm.$set(vm.$root.$data.performances, vm.$root.$data.performances.length, response.data)
                    }

                    vm.$root.successResponse('Create A Performance')
                    vm.isDisabled = false
                    vm.$router.push('/performances')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                });
            }
        }
    }
</script>
