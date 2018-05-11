<template>
    <v-list dense>
        <v-list-tile v-for="(route, index) in routes" :key="index" @click="$router.push({name: route.name})">
            <v-list-tile-action>
                <v-icon>{{route.meta.icon}}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>{{route.title}}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list>
</template>
<script>
    export default{
        computed: {
            routes: function () {
                var routes = [];
                for (var i in this.$router.options.routes) {
                    if (!this.$router.options.routes.hasOwnProperty(i)) {
                        continue
                    }
                    var route = this.$router.options.routes[i];
                    if(route.hasOwnProperty('title') && route.meta.visible) {
                        routes.push(route);
                    }
                }
                return routes;
            }
        }
    }
</script>
