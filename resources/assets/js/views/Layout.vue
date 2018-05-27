<template>
    <div v-loading.fullscreen.lock="$root.$data.fullscreenLoading">
        <v-app v-if="!$root.$data.fullscreenLoading" id="inspire">
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
                <v-container fluid
                             style="min-height: 0;"
                             grid-list-lg>
                    <v-layout row wrap>

                        <v-flex xs12>
                            <no-mode>
                                <router-view/>
                            </no-mode>

                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
    </div>

</template>
<script>
    import NavItem from './../components/NavigationDrawer.vue'
    import NoMode from './../Transition/no-mode.vue'
    import ToolBar from './../components/ToolBar.vue'
    export default {
        components: {
            NavItem,
            NoMode,
            ToolBar,
        },
        computed: {
            getFullYear(){
                var d = new Date();
                return d.getFullYear();
            }
        }
    }
</script>
