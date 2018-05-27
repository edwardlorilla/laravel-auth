<template>
    <v-card>
        <v-card-title>
            <span class="headline">User Profile</span>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12>
                        <v-avatar
                                :tile="tile"
                                size="170"
                                color="grey lighten-4"
                        >
                            <img :src="imgFile ?  imgFile : create$.photo ?  '/images/' + create$.photo.file : ''" alt="avatar">
                        </v-avatar>
                        <upload-button title="upload" :selectedCallback="createImage"/>
                        <v-btn v-if="imgFile" @click="imgFile = null" color="error">Remove image</v-btn>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="create$.first_name" label="Legal first name" required></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="create$.middle_name" label="Legal middle name"
                                      hint="example of helper text only on focus"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field
                                v-model="create$.last_name"
                                label="Legal last name"
                                hint="example of persistent helper text"
                                persistent-hint
                                required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field v-model="create$.email" label="Email" required></v-text-field>
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
                                    v-model="create$.birth_date"
                                    label="Birthday date"
                                    prepend-icon="event"
                                    readonly
                            ></v-text-field>
                            <v-date-picker
                                    ref="picker"
                                    v-model="create$.birth_date"
                                    :max="new Date().toISOString().substr(0, 10)"
                                    min="1950-01-01"
                                    @change="save"
                            ></v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-select
                                :items="gender"
                                v-model="create$.gender"
                                item-text= "text"
                                item-value= "value"
                                label="Select"
                                single-line
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field v-model.number="create$.mobile" label="Mobile" type="text" ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field v-model="create$.designation" label="Designation" type="text"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field v-model="create$.department" label="Department" type="text"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field v-model="create$.campus" label="Campus" type="text"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field v-model="create$.education" label="Education" type="text" ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-container>
            <small>*indicates required field</small>
        </v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="imgFile = null; $root.$data.dialog = false; ">Close</v-btn>
            <v-btn color="blue darken-1" flat @click.native="storeUser">Save</v-btn>
        </v-card-actions>
    </v-card>
</template>
<style>
</style>
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
                create$:{
                    file: '',
                    photo_id: '',
                    user_id: '',
                    user_type: 0,
                    status: 0,
                    education: '',
                    first_name: '',
                    middle_name: '',
                    last_name: '',
                    birth_date: '',
                    gender: 1,
                    mobile: '',
                    designation: '',
                    department: '',
                    campus: '',
                    email: '',
                    id: ''
                }
            }
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
                    vm.create$.file = vm.$root.dataURItoBlob(e.target.result);
                    vm.imgFile = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            storeUser(){
                var vm = this;
                var store$ = new FormData();
                store$.append('file', vm.create$.file, vm.$root.$data.user.id + '.jpg')
                store$.append('photo_id', vm.create$.photo_id)
                store$.append('user_id', vm.create$.user_id)
                store$.append('user_type', vm.create$.user_type)
                store$.append('status', vm.create$.status)
                store$.append('education', _.toString(vm.create$.education))
                store$.append('first_name', _.toString(vm.create$.first_name))
                store$.append('middle_name', _.toString(vm.create$.middle_name))
                store$.append('last_name', _.toString(vm.create$.last_name))
                store$.append('birth_date', _.toString(vm.create$.birth_date))
                store$.append('gender', vm.create$.gender)
                store$.append('mobile', vm.create$.mobile)
                store$.append('designation', _.toString(vm.create$.designation))
                store$.append('department', _.toString(vm.create$.department))
                store$.append('campus', _.toString(vm.create$.campus))
                store$.append('email', _.toString(vm.create$.email))
                store$.append('id', vm.create$.id )
                if(vm.create$.photo){
                    store$.append('photo', _.toString(vm.create$.photo.file))
                }
                post('/api/users/', store$).then(function (_ref) {
                    vm.$root.$data.dialog = false
                    console.log(_ref.data.id)
                    vm.$set(vm.$root.$data.users, vm.$root.$data.users.length, _ref.data )
                    vm.$router.push({path: '/employees'})
                    post('/api/password/email', {email: _ref.data.email} ).then(function(){
                    }).catch(function (_ref2) {
                        vm.$root.errorResponse(_ref2)
                    });
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                });
            }
        }
    }
</script>
