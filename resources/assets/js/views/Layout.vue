<template>
    <v-app :class="$root.$data.loading ? 'overlay overlay--active' : ''" id="inspire">
       <div id="text" v-if="$root.$data.loading">
           <v-progress-circular indeterminate color="primary"></v-progress-circular>
       </div>
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
            <v-container fluid fill-height>
                <v-layout>
                    <v-flex>
                        <router-view/>
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
    import ToolBar from './../components/ToolBar.vue'
    export default {
        components:{
            NavItem,
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
