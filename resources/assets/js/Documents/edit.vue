
<template>
    <v-card v-if="edit$">
        <form id="myForm"  @submit.prevent="update$" ref="form" method="post" enctype="multipart/form-data">
        <v-card-title>

                <input type="hidden" :value="edit$.id" name="id">
                <v-flex xs12 sm6 md4N>
                    <v-text-field name="title" v-model="edit$.title" label="title" required/>
                </v-flex>
                <v-flex xs12 sm6 md4>
                    <v-select
                            :items="$root.$data.categories"
                            :filter="$root.$data.customFilter"
                            item-text="title"
                            item-value="id"
                            label="Select"
                            v-model="edit$.category_id"
                            required
                            autocomplete
                    ></v-select>
                </v-flex>
                <v-flex xs12>
                    <upload-button  nameupload="file[]" :selectedCallback="createImage" :multipleupload="multipleupload" title="upload Files" />
                </v-flex>



        </v-card-title>
        </form>
        <v-data-table
                :headers="headers"
                :items="edit$.files"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.file }}</td>
                <td>{{ props.item.type }}</td>
                <td>
                    <v-btn icon class="mx-0" @click="deleteItem(props.item.id)">
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                </td>
            </template>
            <template slot="footer">
                <td colspan="100%">
                    <strong>All Files</strong>
                </td>
            </template>
        </v-data-table>
        <v-card-actions>
            <v-btn type="submit" form="myForm" color="blue darken-1" flat>Save</v-btn>
            <v-spacer/>
            <v-btn type="button" color="blue darken-1" @click="$router.push('/documents')" flat>Cancel</v-btn>
        </v-card-actions>
    </v-card>
</template>
    <script>
        import UploadButton from './../components/UploadButton.vue'
        import {post, put, del} from './../helper/api'
        export default{
            data(){
              return{
                  multipleupload: true,
                  headers: [
                      { text: 'File', value: 'file' },
                      { text: 'Type', value: 'type' },
                      { text: 'Action', value: 'file' }
                  ]
              }
            },
            components: {
                UploadButton
            },
            computed:{
              edit$(){
                  var vm = this
                  return _.clone(_.find(this.$root.$data.documents, ['id', _.parseInt(vm.$route.params.id)]))
              }
            },
            methods: {
                deleteItem(id){
                    var vm = this
                    del(`/api/files/${id}`).then(function(){
                        var findDocFile = _.find(vm.$root.$data.documents, ['id', _.parseInt(vm.$route.params.id)]).files
                        var index = _.findIndex(findDocFile, ['id', id])
                        vm.$delete(findDocFile, index)
                        vm.$root.successResponse('Deleted A File')
                    }).catch(function (_ref2) {
                        vm.$root.errorResponse(_ref2)
                    })
                },
                createImage(e, ref) {
                    var vm = this

                    var store$ = new FormData(vm.$refs.form);
                    post('/api/files', store$).then(function(response){
                        var index = _.findIndex(vm.$root.$data.documents, ['id', _.parseInt(vm.$route.params.id)]);
                        ref.value = null
                        vm.$set(vm.$root.$data.documents, index, response.data)
                    }).catch(function (_ref2) {
                        vm.$root.errorResponse(_ref2)
                    });
                },
                update$(){
                    var vm = this
                    put(`/api/documents/${vm.$route.params.id}`, vm.edit$).then(function (response) {
                        var index = _.findIndex(vm.$root.$data.documents, ['id', _.parseInt(vm.$route.params.id)]);
                        vm.$set(vm.$root.$data.documents, index, response.data)
                        vm.$root.successResponse('Edited A Announcement')
                        vm.$router.push('/documents')
                    }).catch(function (_ref2) {
                        vm.$root.errorResponse(_ref2)
                    });
                }
            }
        }
</script>
