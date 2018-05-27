<template>
    <div>
        <v-layout row justify-space-between>

        <v-flex @click="$router.push('/announcement')" xs12 v-if="getAnnouncement">
            <el-alert
                    :title="getAnnouncement.title"
                    type="success"
                    :description="getAnnouncement.description"
                    show-icon>
            </el-alert>
        </v-flex>
            </v-layout>
        <v-layout row justify-space-between>

            <v-flex xs5>
                <h1 class="display-1 primary--text">Welcome {{user.first_name}}!</h1>
            </v-flex>
            <v-flex xs4>
                Department: {{$root.$data.user.department}}
            </v-flex>

        </v-layout>
        <v-layout row>
            <v-flex xs4>
                <v-card >
                    <v-card-title primary-title>
                        <div class="headline">Quick Links</div>
                        <br>
                        <v-card-text>
                            <v-btn @click="$router.push({path: '/log-activity'})" flat small> <v-icon>history</v-icon> Login History</v-btn>

                            <br>
                            <v-btn @click="$router.push({path: '/documents'})" flat small> <v-icon>description</v-icon> View Document</v-btn>

                        </v-card-text>
                    </v-card-title>

                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                alert: true
            }
        },
        computed: {
            getAnnouncement(){
                var vm = this
              return _.head(vm.$root.$data.announcements)
            },
            user(){

                return this.$root.$data.user
            }
        }
    }
</script>