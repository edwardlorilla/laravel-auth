<template>
    <v-card>
        <form ref="form" @submit.prevent = "store$" method="post" enctype="multipart/form-data">
            <v-card-title>
                <span class="headline">Create Document</span>
                <v-container grid-list-md>
                    <v-layout wrap>

                        <v-flex xs12 sm6 md4>
                            <v-text-field  name="title" label="title" required/>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-select
                                    :items="$root.$data.categories"
                                    :filter="$root.$data.customFilter"
                                    item-text="title"
                                    item-value="id"
                                    label="Select"
                                    v-model="create$.category_id"
                                    required
                                    autocomplete
                            ></v-select>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <el-upload
                                    :on-change="handleChange"
                                    :file-list="create$.file"
                                    action=""
                                    class="upload-demo"
                                    ref="upload"
                                    name='file[]'
                                    multiple
                                    :auto-upload="false">
                                <v-btn slot="trigger" @click="resetFile" >Upload</v-btn>
                            </el-upload>
                            <input type="hidden" name="file[]" :value="create$.file">
                        </v-flex>
                    </v-layout>
                </v-container>
                <small>*indicates required field</small>
            </v-card-title>
            <v-card-actions>

                <v-btn color="blue darken-1" flat type="submit">Save</v-btn>
                <v-spacer/>
                <v-btn type="button" color="blue darken-1" @click="$router.push('/documents')" flat>Cancel</v-btn>
            </v-card-actions>
        </form>
    </v-card>
</template>
<script>
    import {post, put} from './../helper/api';
    import UploadButton from './../components/UploadButton.vue'

    export default{
        components: {
            UploadButton
        },
        data(){
            return {
                multipleupload: true,
                create$:{
                    title: '',
                    category_id: '',
                    file: [],
                }

            }
        },
        methods: {
            handleChange(file, fileList) {
                var vm = this
                    vm.create$.file = fileList


            },
            resetFile(){
                var vm = this
                vm.create$.file = []
            },
            store$(){
                var vm = this
                var store$ = new FormData(vm.$refs.form);
                store$.append('category_id', vm.create$.category_id )
                post('/api/documents', store$).then(function (response) {
                    vm.$set(vm.$root.$data.documents, vm.$root.$data.documents.length, response.data )
                    vm.$root.successResponse('Create A Document')
                    vm.$router.push('/documents')
                }).catch(function (_ref2) {
                    vm.$root.errorResponse(_ref2)
                });
            }
        }
    }
</script>
