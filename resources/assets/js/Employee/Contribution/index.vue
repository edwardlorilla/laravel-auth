<template>
        <v-card>
            <v-card-title>
                    <v-layout row>
                        <v-flex xs6>
                            <el-input placeholder="Please input" v-model="search" class="input-with-select">
                                <el-select clearable v-model="transactions" slot="prepend" placeholder="Select">
                                    <el-option v-for="(transaction, index) in pluckData" :key="index" :label="transaction" :value="transaction"/>
                                </el-select>

                            </el-input>

                        </v-flex>
                        <v-flex xs6>
                            <el-date-picker
                                    v-model="filterDate"
                                    type="daterange"
                                    align="right"
                                    start-placeholder="Start Date"
                                    end-placeholder="End Date"
                                    :default-value="new Date().toISOString().substr(0, 10)">
                            </el-date-picker>
                        </v-flex>


                    </v-layout>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="dataFilters"
                    :search="search"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.transaction.title}}</td>
                    <td>{{ props.item.amount}}</td>
                    <td>{{ props.item.created_at }}</td>
                    <td>
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

        </v-card>
</template>
<style>
    .el-select .el-input {
        width: 150px;
    }
    .input-with-select .el-input-group__prepend {
        background-color: #fff;
    }
</style>
<script>
    export default{
        data(){
            return {
                transactions:[],
                filterDate:[],
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
        mounted(){
            var vm = this
            if(vm.$root.$data.user.user_type){
                vm.headers.push({text: 'Action', value: 'created_at', sortable: false})
            }
        },
        computed:{
            pluckData() {
                var a = this,
                    b = a.$root.$data.contributions,
                    c = _.map(b, function(f) {
                        return f.transaction ? f.transaction.title : null;
                    }),
                    d = _.uniq(c),
                    e = _.filter(d, function(f) {
                        return "" == f ? null : f;
                    });
                return e;
            },
            filteredData() {
                var a = this,
                    b = a.filterDate ? a.filterDate[0] : [],
                    c = new Date(a.$moment(b).format("YYYY-MM-DD")),
                    d = a.filterDate ? a.filterDate[1] : [],
                    e = new Date(a.$moment(d).format("YYYY-MM-DD"));
                return _.filter(a.getUserContribution, function(f) {
                    if (_.isEmpty(a.filterDate) || (_.isNull(b) && _.isNull(d))) return !0;
                    var g = new Date(a.$moment(f.created_at).format("YYYY-MM-DD"));
                    return g >= c && g <= e;
                });
            },
            dataFilters() {
                var b,
                    a = this,
                    c = a.transactions,
                    d = _.filter(a.filteredData, function(e) {
                        return e.transaction
                            ? e.transaction.title
                                ? -1 != c.indexOf(e.transaction.title)
                                : e.transaction.title
                            : null;
                    });
                return (b = _.isEmpty(c) ? a.filteredData : d), b;
            },
            getUserContribution(){
                var vm = this
                return _.filter(vm.$root.$data.contributions, ['user_id', _.parseInt(vm.$route.params.id)])
            }
        }
    }
</script>
