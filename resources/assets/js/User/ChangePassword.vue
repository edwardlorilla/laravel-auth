<template>
    <v-card>
        <v-card-title>
            <span class="headline">Change Password</span>
            <v-container grid-list-md>
            <v-layout wrap>
                <v-flex xs12 sm6 md4>
                    <v-text-field v-model="change$.old_password"
                                  label="Current Password"
                                  type="password"
                                  required
                    ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                    <v-text-field v-model="change$.new_password"
                                  type="password"
                                  label="New Password"
                                  required
                    ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                    <v-text-field v-model="change$.confirm_password"
                                  label="Confirm Password"
                                  type="password"
                                  required
                    ></v-text-field>
                </v-flex>
            </v-layout>
                </v-container>
        </v-card-title>
        <v-card-actions>
            <v-btn @click="saveChange" flat color="blue">Save Change</v-btn>
        </v-card-actions>
    </v-card>
</template>
<style>

</style>
<script>
    import {put} from './../helper/api'
    export default{
        data(){
            return {
                change$:{
                    old_password: '',
                    new_password: '',
                    confirm_password: ''
                }
            }
        },
        methods:{
            saveChange(){
                var vm = this

                vm.$root.$data.fullscreenLoading = true
                put('/api/users/' + vm.$root.$data.user.id, vm.change$)
                    .then(function (_ref) {
                        vm.$root.$data.fullscreenLoading = false
                    })
                    .catch(function (_ref2) {
                        vm.$root.errorResponse(_ref2)
                    });
            }
        }
    }
</script>
