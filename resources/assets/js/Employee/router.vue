<template>
        <v-layout row wrap>
            <v-flex xs12>
                <el-breadcrumb separator-class="el-icon-arrow-right">
                    <el-breadcrumb-item v-for="(item, index) in items" :key="index" :to="{ path: item.link }">{{item.text}}</el-breadcrumb-item>
                </el-breadcrumb>
            </v-flex>
            <v-flex xs2>
                <ul class="yum-ul">
                    <li class="yum-nav"><router-link  :to="{path: '/employees/edit/' + $route.params.id}">User Profile</router-link></li>
                    <li class="yum-nav"><router-link  :to="{path: '/employees/edit/' + $route.params.id + '/contribution'}">Contribution</router-link></li>
                    <li class="yum-nav"><router-link  :to="{path: '/employees/edit/' + $route.params.id + '/performance'}">Performance</router-link></li>
                </ul>
            </v-flex>

            <v-flex xs10>
                <no-mode>
                    <router-view/>
                </no-mode>
            </v-flex>
        </v-layout>
</template>
<style>
    ul.yum-ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        background-color: #f1f1f1;
        border: 1px solid #555;
    }

    li.yum-nav a {
        display: block;
        color: #000;
        padding: 8px 16px;
        text-decoration: none;
    }

    li.yum-nav {
        text-align: center;
        border-bottom: 1px solid #555;
    }

    li.yum-nav:last-child {
        border-bottom: none;
    }

    li.yum-nav a.active {
        background-color: #3949AB;
        color: white;
    }

    li.yum-nav a:hover:not(.active) {
        background-color: #555;
        color: white;
    }
</style>
<script>
    import NoMode from './../Transition/no-mode.vue'
    export default{
        components:{
            NoMode
        },
        data(){
            return {
                items: [
                    {
                        text: 'Manage Employees',
                        disabled: false,
                        link: '/employees'
                    },
                    {
                        text: 'User Profile',
                        disabled: false,
                        link: '/employees/edit/' + this.$route.params.id
                    }
                ]
            }
        }
    }
</script>
