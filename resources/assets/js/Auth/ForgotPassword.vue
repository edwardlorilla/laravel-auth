<template>
    <v-content style="padding: 0px">
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-12">
                        <form @submit.prevent="sendResetLinkEmail">
                            <v-card-text>

                                <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="forgot$.email" prepend-icon="person" name="login" label="Login"
                                              type="email"></v-text-field>

                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn type="submit" :disabled="$root.$data.fullscreenLoading" color="info">Reset Email</v-btn>
                            </v-card-actions>
                        </form>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>
<style>
</style>
<script>
    import {post} from './../helper/api'
    export default{
        data(){
            return{
                forgot$:{
                    email: ''
                }
            }
        },
        methods:{
            sendResetLinkEmail(){
             var vm = this
                post('/api/password/email', vm.forgot$).then(function(){
                    console.log('check')
                })
            }
        }
    }
</script>
