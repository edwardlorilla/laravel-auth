<template>
    <v-card v-if="update$">
        <v-card-title>
                <v-layout wrap>
                    <v-flex xs12>
                        <v-avatar
                                :tile="tile"
                                size="170"
                                color="grey lighten-4"
                        >
                            <img :src="imgFile ?  imgFile : update$.photo ?  '/images/' + update$.photo.file : ''" alt="avatar">
                        </v-avatar>
                        <upload-button title="upload" :selectedCallback="createImage"/>
                        <v-btn v-if="imgFile" @click="imgFile = null" color="error">Remove image</v-btn>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="update$.first_name" label="Legal first name" required></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="update$.middle_name" label="Legal middle name"
                                      hint="example of helper text only on focus"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field
                                v-model="update$.last_name"
                                label="Legal last name"
                                hint="example of persistent helper text"
                                persistent-hint
                                required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field v-model="update$.email" label="Email" required></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-menu
                                ref="menu"
                                :close-on-content-click="false"
                                v-model="menu"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                        >
                            <v-text-field
                                    slot="activator"
                                    v-model="update$.birth_date"
                                    label="Birthday date"
                                    prepend-icon="event"
                                    readonly
                            ></v-text-field>
                            <v-date-picker
                                    ref="picker"
                                    v-model="update$.birth_date"
                                    :max="new Date().toISOString().substr(0, 10)"
                                    min="1950-01-01"
                                    @change="save"
                            ></v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-select
                                :items="gender"
                                v-model="update$.gender"
                                item-text= "text"
                                item-value= "value"
                                label="Select"
                                single-line
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <span>Status</span>
                        <v-select
                                :items="status"
                                v-model="update$.status"
                                label="Status"
                                single-line
                        ></v-select>
                    </v-flex>
                    <v-flex  xs12 sm6>
                        <span>User Type</span>
                        <v-select
                                :items="user_type"
                                v-model="update$.user_type"
                                label="User Type"
                                single-line
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field v-model.number="update$.mobile" label="Mobile" type="text" ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field v-model="update$.designation" label="Designation" type="text"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field v-model="update$.department" label="Department" type="text"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field v-model="update$.campus" label="Campus" type="text"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field v-model="update$.education" label="Education" type="text" ></v-text-field>
                    </v-flex>
                </v-layout>
            <small>*indicates required field</small>
        </v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="imgFile = null; $root.$data.dialog = false; ">Close</v-btn>
            <v-btn color="blue darken-1" flat @click.native="storeUser">Save</v-btn>
        </v-card-actions>
    </v-card>
</template>
<script>
    import Auth from "./../plugin/auth";
    import {post} from './../helper/api'
    import UploadButton from './../components/UploadButton.vue'
    export default{
        components: {
            UploadButton
        },
        data(){
            return {
                tile: false,
                gender: [
                    {text: 'Male', value: 1},
                    {text: 'Female', value: 0},
                ],
                date: null,
                menu: false,
                dateFormatted: null,
                imgFile: null,
                blobFile: '',
                status: [{text: 'Active', value: 1}, {text: 'Inactive', value: 0} ],
                user_type: [{text: 'Employee', value: 0}, {text: 'Admin', value: 1}, {text: 'HR', value: 3} ]
            }
        },
        computed:{
            update$(){
                var vm = this
                return _.clone(_.find(this.$root.$data.users, ['id', _.parseInt(vm.$route.params.id)]))
            },
        },
        watch: {
            menu (val) {
                val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
            }
        },
        methods: {
            save (date) {
                this.$refs.menu.save(date)
            },
            createImage(file, ref) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.blobFile = vm.$root.dataURItoBlob(e.target.result);
                    vm.imgFile = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            storeUser(){
                var vm = this;
                var store$ = new FormData();
                store$.append('file', vm.blobFile, vm.$root.$data.user.id + '.jpg')
                if(vm.update$.photo_id){
                    store$.append('photo_id', vm.update$.photo_id)
                }
                store$.append('user_id', vm.update$.user_id)
                if(vm.$root.$data.user.user_type === 1){
                    store$.append('user_type', vm.update$.user_type)
                    store$.append('status', vm.update$.status)
                }
                store$.append('education', _.toString(vm.update$.education))
                store$.append('first_name', _.toString(vm.update$.first_name))
                store$.append('middle_name', _.toString(vm.update$.middle_name))
                store$.append('last_name', _.toString(vm.update$.last_name))
                store$.append('birth_date', _.toString(vm.update$.birth_date))
                store$.append('gender', vm.update$.gender)
                store$.append('mobile', vm.update$.mobile)
                store$.append('designation', _.toString(vm.update$.designation))
                store$.append('department', _.toString(vm.update$.department))
                store$.append('campus', _.toString(vm.update$.campus))
                store$.append('email', _.toString(vm.update$.email))
                store$.append('id', vm.update$.id )
                if(vm.update$.photo){
                    store$.append('photo', _.toString(vm.update$.photo.file))
                }
                post('/api/users/', store$).then(function (_ref) {
                    var index = _.findIndex(vm.$root.$data.users, ['id',  _.parseInt(vm.$route.params.id)]);
                    vm.$set(vm.$root.$data.users, index, _ref.data)
                    vm.$root.$data.dialog = false
                    vm.$root.successResponse('Edited A User')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                });
            }
        }
    }
</script>