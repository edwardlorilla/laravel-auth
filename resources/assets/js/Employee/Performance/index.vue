<template>
    <v-card>
            <v-card-title>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <line-graph :user="getPerformance"/>
                        </v-flex>
                        <v-flex xs6>
                            <el-input placeholder="Please input" v-model="search" class="input-with-select"/>
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
                    <v-data-table
                            :headers="headers"
                            :items="dataFilters"
                            :search="search"
                    >
                        <template slot="items" slot-scope="props">


                            <td>{{props.item.ceta}}</td>
                            <td>{{props.item.etd}}</td>
                            <td>{{props.item.etp}}</td>
                            <td>{{props.item.ets}}</td>
                            <td>{{props.item.etse}}</td>
                            <td>{{props.item.target}}</td>
                            <td>{{props.item.school_year_start}}</td>
                            <td>{{props.item.school_year_end}}</td>
                            <td>
                                <v-btn icon class="mx-0"
                                       @click="$router.push({path: '/performances/edit/' + props.item.id, params: { id: props.item.id }})">
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
            </v-card-title>


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
    import LineGraph from './graph.vue'
    export default{
        components:{
            LineGraph
        },
        mounted(){
            var vm = this
            if(vm.$root.$data.user.user_type){
                vm.headers.push({text: 'Action', value: 'created_at', sortable: false})
            }
        },
        data(){
            return {
                performances:[],
                filterDate:[],
                search: '',
                headers: [
                    {text: 'CETA', value: 'ceta', sortable: false},
                    {text: 'ETD', value: 'etd', sortable: false},
                    {text: 'ETP', value: 'etp', sortable: false},
                    {text: 'ETS', value: 'ets', sortable: false},
                    {text: 'ETSE', value: 'etse', sortable: false},
                    {text: 'TARGET', value: 'target', sortable: false},
                    {text: 'School Year Start', value: 'school_year_start', sortable: false},
                    {text: 'School Year End', value: 'school_year_end', sortable: false},

                ],
            }
        },
        computed:{
            filteredData() {
                var a = this,
                    b = a.filterDate ? a.filterDate[0] : [],
                    c = new Date(a.$moment(b).format("YYYY-MM-DD")),
                    d = a.filterDate ? a.filterDate[1] : [],
                    e = new Date(a.$moment(d).format("YYYY-MM-DD"));
                return _.filter(a.getPerformance, function(f) {
                    if (_.isEmpty(a.filterDate) || (_.isNull(b) && _.isNull(d))) return !0;
                    var g = new Date(a.$moment(f.created_at).format("YYYY-MM-DD"));
                    return g >= c && g <= e;
                });
            },
            dataFilters() {
                var b,
                    a = this,
                    c = a.performances,
                    d = _.filter(a.filteredData, function(e) {
                        return e.transaction
                            ? e.transaction.title
                                ? -1 != c.indexOf(e.transaction.title)
                                : e.transaction.title
                            : null;
                    });
                return (b = _.isEmpty(c) ? a.filteredData : d), b;
            },
            getPerformance(){
                var vm = this
                return _.filter(vm.$root.$data.performances, ['user_id', _.parseInt(vm.$route.params.id)])
            }
        }
    }
</script>
