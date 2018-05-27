<template>
    <v-card>
        <v-card-title>
            <span class="headline">User Profile</span>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="create$.title" label="title" required/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="create$.description" label="description"/>
                    </v-flex>
                </v-layout>
            </v-container>
            <small>*indicates required field</small>
        </v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="store$">Save</v-btn>
        </v-card-actions>
    </v-card>
</template>
<script>
    import {post} from './../helper/api'
    export default{
        data(){
            return {
                create$: {
                    title: null,
                    description: null,
                }
            }
        },
        methods: {
            store$(){
                var vm = this
                post('/api/announcements', vm.create$).then(function (response) {
                    vm.$set(vm.$root.$data.announcements, vm.$root.$data.announcements.length, response.data )
                    vm.$root.successResponse('Create A Announcements')
                    vm.$router.go(-1)
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                });
            }
        }
    }
</script>
