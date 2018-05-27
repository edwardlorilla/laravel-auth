<template>
    <div>
        <v-btn v-if="$root.$data.user.user_type" @click="$router.push({path: '/documents/create'})" color="primary" dark class="mb-2">New Document</v-btn>
        <v-card>
            <v-card-title>

                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex xs6>
                            <el-input placeholder="Please input" v-model="search" class="input-with-select">
                                <el-select clearable v-model="categories" slot="prepend" placeholder="Select">
                                    <el-option v-for="(category, index) in pluckData" :key="index" :label="category" :value="category"/>
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
                    </v-container>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="dataFilters"
                    :search="search"
            >
                <template slot="items" slot-scope="props">
                    <td v-if="props.item.title">{{ props.item.title}}</td>
                    <td>
                        <div v-for="item in props.item.files">
                            <a :href="'/files/' + item.file">{{item.file}}</a>
                        </div>
                    </td>
                    <td>{{ props.item.created_at }}</td>
                    <td  v-if="$root.$data.user.user_type">
                        <v-btn icon class="mx-0"
                               @click="$router.push({path: '/documents/edit/' + props.item.id, params: { id: props.item.id }})">
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
<style>
    .el-select .el-input {
        width: 150px;
    }
    .input-with-select .el-input-group__prepend {
        background-color: #fff;
    }
</style>
<script>
    import NoMode  from './../Transition/no-mode.vue'
    import {del} from './../helper/api'
    export default{
        components: {
            NoMode,
        },
        data(){
            return {
                filterDate: [],
                categories: [],
                search: '',
                headers: [
                    {
                        text: 'Title',
                        align: 'center',
                        sortable: false,
                        value: 'title'
                    },
                    {text: 'File', value: 'file', sortable: false},
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
                    b = a.$root.$data.documents,
                    c = _.map(b, function(f) {
                        return f.category ? f.category.title : null;
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
                return _.filter(a.$root.$data.documents, function(f) {
                    if (_.isEmpty(a.filterDate) || (_.isNull(b) && _.isNull(d))) return !0;
                    var g = new Date(a.$moment(f.created_at).format("YYYY-MM-DD"));
                    return g >= c && g <= e;
                });
            },
            dataFilters() {
                var b,
                    a = this,
                    c = a.categories,
                    d = _.filter(a.filteredData, function(e) {
                        return e.category
                            ? e.category.title
                                ? -1 != c.indexOf(e.category.title)
                                : e.category.title
                            : null;
                    });
                return (b = _.isEmpty(c) ? a.filteredData : d), b;
            },
        },
        methods: {
            deleteItem(id){
                var vm = this
                del('/api/documents/' + id).then(function () {
                    var index = _.findIndex(vm.$root.$data.documents, ['id', id]);
                    vm.$delete(vm.$root.$data.documents, index)
                    vm.$root.successResponse('Delete A Document')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                })
            }

        }
    }
</script>
