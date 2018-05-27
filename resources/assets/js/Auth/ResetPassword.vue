<template>
    <v-content style="padding: 0px">
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-12">
                        <form @submit.prevent="sendReset">
                            <v-card-text>

                                <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="reset.email"
                                              prepend-icon="person" name="login" label="Login"
                                              type="email"></v-text-field>
                                <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="reset.password"
                                              prepend-icon="lock" name="login" label="Login"
                                              type="password"></v-text-field>
                                <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="reset.password_confirmation "
                                              prepend-icon="lock" name="login" label="Login"
                                              type="password"></v-text-field>
                                <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="reset.token"
                                              name="login" label="Login"
                                              type="text"></v-text-field>

                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn type="submit" :disabled="$root.$data.fullscreenLoading" color="info">
                                    Change Password
                                </v-btn>
                            </v-card-actions>
                        </form>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
    import {post} from './../helper/api'
    export default{
        data(){
            return {
               reset:{
                   email : '',
                   password : '',
                   password_confirmation : '',
                   token : ''
               }
            }
        },
        methods:{
            sendReset(){
                var vm = this
                post('api/password/reset', vm.reset).then(function(response){
                    console.log(response)
                })
            }
        }
    }
</script>
