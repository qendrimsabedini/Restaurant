<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.card-header -->
                        <div class="card-body row">
                            <div class="form-group col-md-4">
                                <label for="">Search:</label>
                               <input type="text" v-model="search"    class="form-control">
                            </div>
                        </div>

          <div class="col-12">
            <div class="card" v-if="$gate.isAdmin()">
              <div class="card-header">
                <h3 class="card-title">Tag List</h3>

                <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Created</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="tag in tags.data" :key="tag.id">

                      <td>{{tag.id}}</td>
                      <td class="text-capitalize">{{tag.name}}</td>
                      <td>{{tag.created_at}}</td>
                      <td>

                        <a href="#" @click="editModal(tag)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        <a href="#" @click="deleteTag(tag.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="tags" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Tag</h5>
                    <h5 class="modal-title" v-show="editmode">Update Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? updateTag() : createTag()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
    export default {
        data () {
            return {
                editmode: false,
                tags : {},
                search:'',
                form: new Form({
                    id : '',
                    name: '',
                })
            }
        },
        methods: {

            getResults(page = 1) {

                  this.$Progress.start();

                  axios.get('/api/tag?page=' + page).then(({ data }) => (this.tags = data.data));

                  this.$Progress.finish();
            },
            updateTag(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('/api/tag/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                    this.loadTags();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            editModal(tag){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(tag);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            loadTags(){
                if(this.$gate.isAdmin()){
                    axios.get("/api/tag").then(({ data }) => (this.tags = data.data));
                }
            },
            searchData(val)
            {
                 axios.get('api/tag/search/'+val).then((res)=>{
                  this.tags=res.data;
                });
            },
            //Delete function
            deleteTag(id){
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this! " + id,
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/tag/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadTags();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
            },
            createTag(){

                this.form.post('/api/tag')
                .then((response)=>{
                    $('#addNew').modal('hide');

                    Toast.fire({
                            icon: 'success',
                            title: response.data.message
                    });

                    this.$Progress.finish();
                    this.loadTags();

                })
                .catch(()=>{

                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
            }

        },
        watch:{
            search:function(){

               this.searchData(this.search);
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {

            this.$Progress.start();
            this.loadTags();
            this.$Progress.finish();
        }
    }
</script>
