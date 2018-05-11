<template>
    <div>
        <v-layout row justify-space-between>
            <v-flex xs5>
                <h1 class="display-1 primary--text">Welcome {{user.name}}!</h1>
            </v-flex>
            <v-flex xs4>
                Department:
            </v-flex>
        </v-layout>
        <v-layout row justify-center>
            <v-flex xs4>
                <v-card>
                    <v-card-title primary-title>
                        <div>
                            <h3 class="headline mb-0">Kangaroo Valley Safari</h3>
                            <div>Located two hours south of Sydney in the <br>Southern Highlands of New South Wales, ...</div>
                        </div>
                    </v-card-title>
                    <v-card-text>one</v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>
<script>
    export default{
        computed:{
            user(){
                return this.$root.$data.user
            }
        }
    }
</script>