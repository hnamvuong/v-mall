<template>
    <div class="category">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title d-inline-block">Management Category</h3>
                        <div class="card-tools float-right">
                            <button class="btn btn-success" @click="newModal">Add New <i
                                class="fas fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(category, index) in categories.data" :key="index">
                                <td>{{index + 1}}</td>
                                <td>{{category.name}}</td>
                                <td>{{category.created_at | formatDate}}</td>
                                <td>
                                    <a href="#" @click="formEdit(category)"><i class="fa fa-edit blue"></i></a>
                                    /
                                    <a href="#" @click="deleteUser(category.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="categories" @pagination-change-page="getResults"></pagination>
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
                    <form @submit.prevent="editMode ? updateCategory() : createCategory()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                                       placeholder="Input Name ...">
                                <has-error :form="form" field="name"></has-error>
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
        name: "Category",
        data() {
            return {
                editMode: false,
                categories: {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: '',
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('/api/category?page=' + page)
                    .then(response => {
                        this.categories = response.data;
                    });
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            loadCategories() {
                axios.get('/api/category')
                    .then(({data}) => (this.categories = data))
            },
            formEdit(category) {
                this.editMode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(category)
            },
            createCategory() {
                this.$Progress.start();
                this.form.post('/api/category')
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            title: 'Category created in successfully'
                        });
                        this.$Progress.finish();
                    }).catch(() => {
                });
            },
            updateCategory() {
                this.$Progress.start();
                this.form.put('/api/category/' + this.form.id)
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
            deleteUser(categoryId) {
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
                        this.form.delete('/api/category/' + categoryId)
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
            this.loadCategories();
            Fire.$on('AfterCreate', () => {
                this.loadCategories();
            });
        }
    }
</script>

<style scoped>

</style>
