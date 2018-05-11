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
        <v-layout row>
            <v-flex xs4>
                <v-card >
                    <v-card-title primary-title>
                        <div class="headline">Quick Links</div>
                        <br>
                        <v-card-text>
                            <v-icon>history</v-icon> Login History
                            <br>
                            <v-icon>description</v-icon> View Document
                        </v-card-text>
                    </v-card-title>

                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>
<script>
    export default{
        computed: {
            user(){
                return this.$root.$data.user
            }
        }
    }
</script>