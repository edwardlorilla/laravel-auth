<template>
    <v-layout row justify-space-between>
        <v-flex xs10 offset-xs1>
            <h1 id="introduction" class="display-1 primary--text">
                Log Activities
            </h1>
            <br>
            <no-mode>
                <v-card>
                    <v-card-title>
                        <v-spacer></v-spacer>
                        <v-text-field
                                v-model="search"
                                append-icon="search"
                                label="Search"
                                single-line
                                hide-details
                        ></v-text-field>
                    </v-card-title>
                    <v-data-table
                            :headers="headers"
                            :items="$root.$data.logActivity"
                            :search="search"
                    >
                        <template slot="items" slot-scope="props">
                            <td v-if="props.item.causer">{{ props.item.causer.first_name }} {{ props.item.causer.last_name }}</td>
                            <td v-else></td>
                            <td>{{ props.item.description }}</td>
                            <td>{{  $moment.utc(props.item.created_at).local().fromNow() }}</td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                    </v-data-table>
                </v-card>
            </no-mode>
        </v-flex>

    </v-layout>

</template>
<style>

</style>
<script>
    import NoMode from './../Transition/no-mode.vue'
    import {get} from './../helper/api'
    export default{
        components: {
            NoMode,
        },
        data(){
            return{
                search: '',
                headers: [
                    {
                        text: 'Name',
                        align: 'left',
                        sortable: false,
                        value: 'causer.first_name'
                    },
                    { text: 'Description',  value: 'description', sortable: false },
                    { text: 'Created At',  value: 'created_at' ,sortable: false }
                ],
            }
        }
    }
</script>
