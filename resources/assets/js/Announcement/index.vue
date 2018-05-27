<template>
    <div>
        <v-btn @click="$router.push({path: '/announcement/create'})" color="primary" dark class="mb-2">New Announcement</v-btn>
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
                    :items="$root.$data.announcements"
                    :search="search"
            >
                <template slot="items" slot-scope="props">
                    <td v-if="props.item.title">{{ props.item.title}}</td>
                    <td>{{ props.item.description }}</td>
                    <td>{{ props.item.created_at }}</td>
                    <td  v-if="$root.$data.user.user_type">
                        <v-btn icon class="mx-0"
                               @click="$router.push({path: '/announcement/edit/' + props.item.id, params: { id: props.item.id }})">
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
    </div>
</template>
<script>
    import NoMode  from './../Transition/no-mode.vue'
    import {del} from './../helper/api'
    export default{
        components: {
            NoMode,
        },
        mounted(){
            var vm = this
            if(vm.$root.$data.user.user_type){
                vm.headers.push({text: 'Action', value: 'created_at', sortable: false})
            }
        },
        data(){
            return {
                search: '',
                headers: [
                    {
                        text: 'Title',
                        align: 'center',
                        sortable: false,
                        value: 'title'
                    },
                    {text: 'Description', value: 'description', sortable: false},
                    {text: 'Created At', value: 'created_at', sortable: false},

                ],
            }
        },
        methods: {
            deleteItem(id){
                var vm = this
                del('/api/announcements/' + id).then(function () {
                    var index = _.findIndex(vm.$root.$data.announcements, ['id', id]);
                    vm.$delete(vm.$root.$data.announcements, index)
                    vm.$root.successResponse('Delete An Announcement')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                })
            }

        }
    }
</script>
