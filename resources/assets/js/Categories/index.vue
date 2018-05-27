<template>
    <div>
        <v-dialog v-model="dialog" max-width="500px">
            <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>
            <v-card>
                <v-card-title>
                    <span class="headline">{{formTitle}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="editedItem.title" label="Title"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                    <v-btn color="blue darken-1" flat @click.native="save">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
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
                    :items="$root.$data.categories"
                    :search="search"
            >
                <template slot="items" slot-scope="props">
                    <td v-if="props.item.title">{{ props.item.title}}</td>
                    <td  v-if="$root.$data.user.user_type">
                        <v-btn icon class="mx-0" @click="editItem(props.item)">
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
    import {del, post, put} from './../helper/api'
    export default{
        components: {
            NoMode,
        },
        data(){
            return {
                editedIndex: -1,
                editedItem: {
                    title: ''
                },

                defaultItem: {
                    title: ''
                },
                dialog: false,
                newCategory:{
                  title: ''
                },
                search: '',
                headers: [
                    {
                        text: 'Title',
                        align: 'center',
                        sortable: false,
                        value: 'title'
                    },
                    {text: 'Action',sortable: false, value: 'created_at'}
                ],
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            }
        },
        methods: {
            deleteItem(id){
                var vm = this,
                r = confirm('Are you sure you want to delete this item?')
                if(!r) return
                del('/api/categories/' + id).then(function () {
                    var index = _.findIndex(vm.$root.$data.categories, ['id', id]);
                    vm.$delete(vm.$root.$data.categories, index)
                    vm.$root.successResponse('Delete A Category')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                })
            },
            editItem (item) {
                var vm = this
                this.editedIndex = vm.$root.$data.categories.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            close () {
                this.dialog = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            }, 300)
            },
            save () {
                var vm = this
                if (this.editedIndex > -1) {
                    put('/api/categories', vm.create$).then(function (response) {
                        Object.assign(vm.$root.$data.categories[this.editedIndex], response.data)
                        vm.$root.successResponse('Create A Announcements')
                    }).catch(function (_ref2) {
                        vm.$root.errorResponse(_ref2)
                    });

                } else {
                    post('/api/categories', vm.editedItem).then(function (response) {
                        vm.$root.$data.categories.unshift(response.data)
                        vm.$root.successResponse('Create A Announcements')
                    }).catch(function (_ref2) {
                        vm.$root.errorResponse(_ref2)
                    });

                }
                this.close()
            }
        }
    }
</script>
