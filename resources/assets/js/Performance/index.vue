<template>
    <div>
        <v-btn @click="$router.push({path: '/performances/create'})" color="primary" dark class="mb-2">New Item</v-btn>
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
                    :items="$root.$data.performances"
                    :search="search"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.semester === 1 ?
                        '1st Sem. ' + props.item.school_year_start + '-' + props.item.school_year_end :
                        '2nd Sem. ' + props.item.school_year_start + '-' + props.item.school_year_end }}</td>
                    <td>{{ props.item.target }}</td>
                    <td>{{ props.item.ceta }}</td>
                    <td>{{ props.item.etd }}</td>
                    <td>{{ props.item.etp }}</td>
                    <td>{{ props.item.ets }}</td>
                    <td>{{ props.item.etse }}</td>
                    <td v-if="$root.$data.user.user_type">
                        <v-btn :disabled="$root.$data.isDisabled" icon class="mx-0"
                               @click="$router.push({path: '/performances/edit/' + props.item.id, params: { id: props.item.id }})">
                            <v-icon color="teal">edit</v-icon>
                        </v-btn>
                        <v-btn :disabled="$root.$data.isDisabled" icon class="mx-0" @click="deleteItem(props.item.id)">
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
        data(){
            return {
                search: '',
                headers: [
                    {value: 'semester', text: 'SEMESTER', sortable: false},
                    {value: 'target', text: 'TARGET', sortable: false},
                    {value: 'ceta', text: 'CETA', sortable: false},
                    {value: 'etd', text: 'ETD', sortable: false},
                    {value: 'etp', text: 'ETP', sortable: false},
                    {value: 'ets', text: 'ETS', sortable: false},
                    {value: 'etse', text: 'ETSe', sortable: false},

                ],
            }
        },
        mounted(){
            var vm = this
            if(vm.$root.$data.user.user_type){
                vm.headers.push({text: 'Action', value: 'created_at', sortable: false})
            }
        },
        methods: {
            deleteItem(id){
                var vm = this
                vm.$root.$data.isDisabled = true
                del('/api/performances/' + id).then(function () {
                    var index = _.findIndex(vm.$root.$data.performances, ['id', id]);
                    vm.$delete(vm.$root.$data.performances, index)
                    vm.$root.$data.isDisabled = false
                    vm.$root.successResponse('Delete An Announcement')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                })
            }

        }
    }
</script>
