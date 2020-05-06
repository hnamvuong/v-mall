<template>
    <div class="category">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title d-inline-block">Management Producer</h3>
                        <div class="card-tools float-right">
                            <button class="btn btn-success" @click="newModal">Add New <i
                                class="fab fa-amazon fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Logo</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(producer, index) in producers.data" :key="index">
                                <td>{{index + 1}}</td>
                                <td>{{producer.name}}</td>
                                <td>{{producer.logo}}</td>
                                <td>{{producer.description}}</td>
                                <td>{{producer.created_at | formatDate}}</td>
                                <td>
                                    <a href="#" @click="formEdit(producer)"><i class="fa fa-edit blue"></i></a>
                                    /
                                    <a href="#" @click="deleteProducer(producer.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="producers" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode">Add New Category</h5>
                        <h5 class="modal-title" v-show="editMode">Update Category's Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateCategory() : createProducer()" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                                       placeholder="Input Name ...">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="input-group mb-3">
                                <div class="col-md-3" v-if="form.logo">
                                    <img :src="form.logo" class="img-responsive" height="70" width="90">
                                </div>
                                <div class="col-md-6">
                                    <input type="file" v-on:change="onImageChange" class="form-control">
                                </div>
<!--                                <div class="col-md-3">-->
<!--                                    <button class="btn btn-success btn-block" @click="createImage">Upload</button>-->
<!--                                </div>-->
                            </div>
                            <div class="form-group">
                                <textarea v-model="form.description"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"
                                          placeholder="Input Description ...">
                                </textarea>
                                <has-error :form="form" field="description"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Producer",
        data() {
            return {
                editMode: false,
                producers: {},
                form: new Form({
                    id: '',
                    name: '',
                    logo: '',
                    description: ''
                }),
                image: '',
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('/api/producer?page=' + page)
                    .then(response => {
                        this.producers = response.data;
                    });
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            loadProducers() {
                axios.get('/api/producer')
                    .then(({data}) => (this.producers = data))
            },
            formEdit(category) {
                this.editMode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(category)
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.form.logo = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            createImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.form.logo = e.target.result;
                };
                reader.readAsDataURL(file);
                this.form.logo = file;
            },
            createProducer() {
                this.$Progress.start();
                this.form.post('/api/producer')
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            title: 'Producer created in successfully'
                        });
                        this.$Progress.finish();
                    }).catch(() => {
                });
            },
            updateCategory() {
                this.$Progress.start();
                this.form.put('/api/producer/' + this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide');
                        swal(
                            'Updated!',
                            'Information has been updated.',
                            'success'
                        );
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                    }).catch(() => {
                    this.$Progress.fail();
                });
            },
            deleteProducer(producerId) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('/api/producer/' + producerId)
                            .then(() => {
                                swal(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                                Fire.$emit('AfterCreate');
                            }).catch(() => {
                            swal("Failed!", "There was something wrong.", "warning");
                        })
                    }
                })
            }
        },
        created() {
            this.loadProducers();
            Fire.$on('AfterCreate', () => {
                this.loadProducers();
            });
        }
    }
</script>

<style scoped>

</style>
