<template>
    <v-container grid-list-md text-xs-center>
        <v-layout row justify-space-between>
            <v-flex xs10  offset-xs1>
                <h1 id="introduction" class="display-1 primary--text">
                    Documents
                </h1>
                <br>
                <no-mode>
                    <router-view/>
                </no-mode>
            </v-flex>

        </v-layout>
    </v-container>
</template>
<script>
    import NoMode from './../Transition/no-mode.vue'
    export default{
        components: {
            NoMode,
        }
    }
</script>