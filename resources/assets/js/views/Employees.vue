<template>
        <v-layout row wrap>
            <v-flex  xs12>

                <v-tabs v-model="active"

                >
                    <v-tab @click="$router.push({path: '/employees/create'})">
                        New Employee
                    </v-tab>
                    <v-tab @click="$router.push('/employees')">
                        Manage Employees
                    </v-tab>

                </v-tabs>

            </v-flex>
            <v-flex>
                <no-mode>
                    <router-view/>
                </no-mode>
            </v-flex>
        </v-layout>
</template>
<style>
</style>
<script>
    import NoMode from './../Transition/no-mode.vue'
    export default{
        data(){
            return {
                active: '1'
            }
        },
        computed: {
            routeHandler(){
                var vm = this
                return vm.active = "/employees" === vm.$route.fullPath
                    ? "1"
                    : "/employees/create" === vm.$route.fullPath ? "0" : "1";
            }
        },
        components: {
            NoMode,
        }
    }
</script>
