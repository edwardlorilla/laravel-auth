<template>
    <v-content style="padding: 0px">
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-12">
                        <v-toolbar dark color="primary">
                            <v-toolbar-title>{{currentTab}} form</v-toolbar-title>
                            <v-spacer></v-spacer>

                            <v-tooltip right>
                                <v-btn v-if="currentTab === 'Login'" @click="currentTab = 'Register'" slot="activator" icon large
                                       target="_blank">
                                    <v-icon large>add</v-icon>
                                </v-btn>
                                <v-btn v-else @click="currentTab = 'Login'" slot="activator" icon large
                                       target="_blank">
                                    <v-icon large>input</v-icon>
                                </v-btn>
                                <span>{{currentTab === 'Login' ? 'Add Employee' : 'Login' }}</span>
                            </v-tooltip>
                        </v-toolbar>
                        <no-mode>
                            <component v-bind:is="currentTab"></component>
                        </no-mode>

                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
    import Login from "./../Auth/Login.vue";
    import Register from "./../Auth/Register.vue";
    import NoMode from "./../Transition/no-mode.vue";
    export default {
        components:{
            Login,
            Register,
            NoMode
        },
        data(){
            return{
                currentTab: 'Login',
            }
        },
    };

</script>