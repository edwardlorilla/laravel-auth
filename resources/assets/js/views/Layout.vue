<template>
    <v-app v-loading.fullscreen.lock="$root.$data.fullscreenLoading" id="inspire">
        <v-navigation-drawer
                v-if="$root.isAuth"
                :clipped="$vuetify.breakpoint.lgAndUp"
                fixed
                v-model="$root.$data.drawer"
                app

        >
            <nav-item></nav-item>
        </v-navigation-drawer>
        <tool-bar></tool-bar>
        <v-content>
            <v-container grid-list-lg fluid fill-height>
                <v-layout>
                    <v-flex>
                        <no-mode>
                            <router-view/>
                        </no-mode>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
        <v-footer v-if="$root.isAuth" color="indigo" app inset>
            <span class="white--text">    &copy; {{getFullYear}}</span>
        </v-footer>
    </v-app>
</template>
<script>
    import NavItem from './../components/NavigationDrawer.vue'
    import NoMode from './../Transition/no-mode.vue'
    import ToolBar from './../components/ToolBar.vue'
    export default {
        components: {
            NavItem,
            NoMode,
            ToolBar
        },
        computed: {
            getFullYear(){
                var d = new Date();
                return d.getFullYear();
            }
        }
    }
</script>
