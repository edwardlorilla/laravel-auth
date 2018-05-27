<template>
    <div>
        <v-btn v-if="$root.$data.user.user_type" @click="$router.push({path: '/contributions/create'})" color="primary" dark class="mb-2">New Contribution</v-btn>
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
            <v-expansion-panel focusable>
                <v-expansion-panel-content v-for="(items,i, key) in getContribution" :key="i">
                    <div slot="header">{{i}}</div>
                    <v-data-table
                            :headers="headers"
                            :items="items"
                            :search="search"
                    >
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.transaction.title}}</td>
                            <td>{{ props.item.amount}}</td>
                            <td>{{ props.item.created_at }}</td>
                            <td v-if="$root.$data.user.user_type">
                                <v-btn icon class="mx-0"
                                       @click="$router.push({path: '/contribution/edit/' + props.item.id, params: { id: props.item.id }})">
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
                </v-expansion-panel-content>
            </v-expansion-panel>

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
                    {
                        text: 'Transaction',
                        align: 'center',
                        sortable: false,
                        value: 'title'
                    },
                    {text: 'Amount', value: 'amount', sortable: false},
                    {text: 'Created At', value: 'created_at', sortable: false},

                ],
            }
        },
        computed:{
            getContribution(){
                var vm = this
                return _.groupBy(vm.$root.$data.contributions, 'user.email' );
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
                del('/api/contributions/' + id).then(function () {
                    var index = _.findIndex(vm.$root.$data.contributions, ['id', id]);
                    vm.$delete(vm.$root.$data.contributions, index)
                    vm.$root.successResponse('Delete An Announcement')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                })
            }

        }
    }
</script>
