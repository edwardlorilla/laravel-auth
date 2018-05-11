<template>
    <v-toolbar

            :style ="{transform: $root.isAuth ?  'translateY(0px)' : 'translateY(-86px)'}"
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            color="indigo"
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
                    <v-avatar size="32px" tile>
                        <img width="32px" height="32px" src="https://vuetifyjs.com/static/doc-images/logo.svg"
                             alt="Vuetify"
                        >
                    </v-avatar>
                </v-btn>
                <v-list >
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
        </v-toolbar-items>
    </v-toolbar>
</template>
<script>
    import {post} from './../helper/api'
    import Auth from './../plugin/auth'
    export default{
    methods: {
        logout() {
            var vm = this
            vm.$root.$data.fullscreenLoading = true
            vm.$root.$data.drawer = false
            post('/api/logout').then((res) => {
                Auth.remove()

                //You have successfully logged out.
                    this.$router.push('/login')
                })
            }
        }
    }
</script>
