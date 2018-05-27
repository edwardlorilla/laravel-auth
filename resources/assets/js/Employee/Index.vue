<template>
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
                    :items="$root.$data.users"
                    :search="search"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.first_name }} {{props.item.last_name}} </td>
                    <td class="text-xs-right">{{ props.item.email }}</td>
                    <td class="text-xs-right">{{ props.item.department }}</td>
                    <td class="text-xs-right">{{ props.item.designation }}</td>
                    <td class="text-xs-right">{{ props.item.status === 0 ? 'Inactive' : 'Active'}}</td>
                    <td>
                        <v-btn icon class="mx-0" @click="$router.push({path: '/employees/edit/' + props.item.id, params: { id: props.item.id }})">
                            <v-icon color="teal">edit</v-icon>
                        </v-btn>
                        <v-btn icon class="mx-0" @click="deleteItem(props.item.id)">
                            <v-icon color="pink">delete</v-icon>
                        </v-btn>
                    </td>
                </template>
                <v-alert slot="no-results" :value="true" color="error" icon="warning">
                    Your search for "{{ search }}" found no results.
                </v-alert>
            </v-data-table>
        </v-card>

</template>
<style>
</style>
<script>
    import {del} from './../helper/api'
    export default {
        data () {
            return {
                search: '',
                headers: [
                    {
                        text: 'Name',
                        align: 'left',
                        sortable: false,
                        value: 'first_name'
                    },
                    { text: 'Email', value: 'email' },
                    { text: 'Department', value: 'department' },
                    { text: 'Designation', value: 'designation' },
                    { text: 'Status', value: 'status' },
                    { text: 'Action',  value: 'name', sortable: false  }
                ],

            }
        },
        methods:{
            deleteItem(id){
                var vm = this
                del('/api/users/' + id).then(function(){
                    var index = _.findIndex(vm.$root.$data.users, ['id', id ]);
                    vm.$delete(vm.$root.$data.users, index)
                    vm.$root.successResponse('Delete A User')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                });
            }
        }
    }
</script>
