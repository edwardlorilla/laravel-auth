<template>
    <div>
        <form ref="form" @submit.prevent = "store$" method="post" >
        <v-card>
            <v-card-title primary-title>
                <v-container text-xs-center>
                    <v-layout v-for="(item, index) in create$" :key="index">
                        <v-flex xs12 sm6 md4>
                            <v-select
                                    :items="getUser"
                                    v-model.number="user_id"
                                    :filter="$root.$data.customFilter"
                                    label="User"
                                    autocomplete
                            ></v-select>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <input type="hidden"  name="transaction_id[]" :value="item.transaction_id" >
                            <v-select
                                    :items="$root.$data.transactions"
                                    :filter="$root.$data.customFilter"
                                    item-text="title"
                                    item-value="id"
                                    v-model="item.transaction_id"
                                    label="Transaction"
                                    autocomplete
                            ></v-select>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field type="number" name="amount[]" required label="amount"/>

                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-btn @click="remove$(index)" depressed small>Remove</v-btn>
                        </v-flex>
                    </v-layout>
                    <small>*indicates required field</small>
                </v-container>
            </v-card-title>


            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn type="submit" color="blue darken-1" flat>Save</v-btn>
                <v-btn color="gray darken-1" flat @click.native="add$">Add</v-btn>
            </v-card-actions>
        </v-card>
        </form>
    </div>

</template>
<script>
    import {post} from './../helper/api'
    export default{
        data(){
            return {

                user_id: 1,
                create$: [{
                    transaction_id: null,
                }]
            }
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
            add$(){
                var vm = this
                vm.create$.push({
                    transaction_id: null
                })
            },
            remove$: function (index) {
                this.create$.splice(index, 1);
            },
            store$(){
                var vm = this
                var store$ = new FormData(vm.$refs.form);
                store$.append('user_id', vm.user_id)
                post('/api/contributions', store$).then(function (response) {
                    response.data.forEach(function(element){
                        vm.$set(vm.$root.$data.user.contributions,vm.$root.$data.user.contributions.length, element )
                    })

                    vm.$root.successResponse('Create A Contribution')
                    vm.$router.go(-1)
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                });
            }
        }
    }
</script>
