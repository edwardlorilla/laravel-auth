<template>
    <v-toolbar

            :style="{transform: $root.isAuth ?  'translateY(0px)' : 'translateY(-86px)'}"
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            color="red darken-4"
            dark
            app
            fixed
    >
        <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
            <v-toolbar-side-icon @click.stop="$root.$data.drawer = !$root.$data.drawer"></v-toolbar-side-icon>
            <span>Web Portal</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-menu v-show="$root.isAuth" offset-y>
                <v-btn slot="activator" icon large>
                    <v-avatar v-if="$root.$data.user.photo && $root.$data.user.photo_id"  size="32px" tile>
                        <img style="border-radius: 50%;" :src="'/images/' + $root.$data.user.photo.file"
                             :alt="$root.$data.user.first_name"
                        >
                    </v-avatar>
                    <avatar v-else :size="picSize"  :username="$root.$data.user.first_name"></avatar>
                </v-btn>
                <v-list>
                    <v-list-tile @click="$root.$data.dialog = true">
                        <v-list-tile-action>
                            <v-icon>person</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>My User Profile</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="logout">
                        <v-list-tile-action>
                            <v-icon>input</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>Logout</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-menu>
            <user-profile/>
        </v-toolbar-items>
    </v-toolbar>
</template>
<script>
    import {post} from './../helper/api'
    import UserProfile from './../User/index.vue'
    import Avatar from 'vue-avatar'
    import Flash from './../Noty/flash'
    import Auth from './../plugin/auth'
    export default{
        components:{
            Avatar,
            UserProfile
        },
        data(){
            return{
                picSize: 32
            }
        },
        methods: {
            logout() {
                var vm = this
                vm.$root.$data.fullscreenLoading = true
                vm.$root.$data.drawer = false
                post('/api/logout').then((res) => {
                    Auth.remove()
                    Flash('You have successfully logged out.')

                    vm.$root.$data.fullscreenLoading = false
                    vm.$router.push('/login')
                })
            }
        }
    }
</script>
