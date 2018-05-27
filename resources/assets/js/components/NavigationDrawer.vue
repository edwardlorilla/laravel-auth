<template>
    <v-list dense>
        <nav-list namelist="/" icon="dashboard" title="Dashboard"/>
        <v-list-group
                prepend-icon="account_circle"
                value="true"
        >
            <v-list-tile slot="activator">
                <v-list-tile-title>{{$root.$data.user.user_type == 0 ? 'User' : $root.$data.user.user_type == 1 ?
                    'Admin' : 'HR' }}
                </v-list-tile-title>
            </v-list-tile>
            <nav-list namelist="/user" icon="person" title="Edit"/>
            <nav-list namelist="/user/change-password" icon="lock" title="Change Password"/>
            <!--TODO nested list-->
            <nav-list namelist="/user/contribution"  title="Contribution"/>
            <nav-list namelist="/user/performance" title="Performance"/>
        </v-list-group>
        <v-list-group
                v-if="$root.$data.user.user_type"
                prepend-icon="group"
                value="true"
                no-action
        >
            <v-list-tile slot="activator">
                <v-list-tile-title>Employees</v-list-tile-title>
            </v-list-tile>
            <nav-list namelist="/employees" title="Manage Employees" icon="people"/>
            <nav-list namelist="/employees/create" title="Create Employee" icon="person_add"/>
        </v-list-group>
        <v-list-group
                v-if="$root.$data.user.user_type"
                prepend-icon="comments"
                value="true"
                no-action
        >
            <v-list-tile slot="activator">
                <v-list-tile-title>Announcements</v-list-tile-title>
            </v-list-tile>
            <nav-list namelist="/announcement" title="Manage Announcement"  icon="announcement" />
            <nav-list namelist="/announcement/create"  title="Create Announcement" icon="add"  />
        </v-list-group>

        <v-list-group
                v-if="$root.$data.user.user_type"
                prepend-icon="pie_chart"
                value="true"
                no-action
        >
            <v-list-tile slot="activator">
                <v-list-tile-title>Performances</v-list-tile-title>
            </v-list-tile>

            <nav-list namelist="/performances" title="Manage Performance" icon="show_chart"  />
            <nav-list namelist="/performances/create" title="Add Performance" icon="playlist_add"  />
        </v-list-group>
        <v-list-group
                prepend-icon="assignment"
                value="true"
        >
            <v-list-tile slot="activator">
                <v-list-tile-title>Documents</v-list-tile-title>
            </v-list-tile>

            <nav-list namelist="/documents" icon="" title="Manage Documents"/>
            <nav-list v-if="$root.$data.user.user_type" namelist="/documents/create" icon="" title="Create Document"/>
            <nav-list v-if="$root.$data.user.user_type" namelist="/categories" icon="" title="Manage Categories"/>
        </v-list-group>
        <!--<nav-list namelist="/hrmd" icon="assignment_ind" title="HRMD"/>-->
        <nav-list namelist="/log-activity" icon="history" title="Log Activity"/>

    </v-list>
</template>
<script>
    import NavList from './NavList.vue'
    export default{
        components: {
            NavList
        },
        computed: {
            routes: function () {
                var routes = [];
                for (var i in this.$router.options.routes) {
                    if (!this.$router.options.routes.hasOwnProperty(i)) {
                        continue
                    }
                    var route = this.$router.options.routes[i];
                    if (route.hasOwnProperty('title') && route.meta.visible) {
                        routes.push(route);
                    }
                }
                return routes;
            }
        }
    }
</script>
