<template>
    <div class="product">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title d-inline-block">Management Product</h3>
                        <div class="card-tools float-right">
                            <button class="btn btn-success" @click="newModal">Add New <i
                                class="fas fa-barcode fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Producer</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Price</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(product, index) in products.data" :key="index">
                                <td>{{index + 1}}</td>
                                <td>{{product.name}}</td>
                                <td>{{product.category.name}}</td>
                                <td v-if="product.producer">
                                    <img :src="'/img/producers/' + product.producer.logo" height="70" width="90">
                                </td>
                                <td v-else>
                                    <img height="70" width="90">
                                </td>
                                <td>
                                    <img :src="'/img/products/' + product.image" height="70" width="90">
                                </td>
                                <td>{{product.description}}</td>
                                <td>{{product.amount}}</td>
                                <td>
                                    <strong>$</strong>
                                    {{product.price}}
                                </td>
                                <td>{{product.created_at | formatDate}}</td>
                                <td>
                                    <a href="#" @click="formEdit(product)"><i class="fa fa-edit blue"></i></a>
                                    /
                                    <a href="#" @click="deleteProduct(product.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="products" @pagination-change-page="getResults"></pagination>
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
                        <h5 class="modal-title" v-show="!editMode">Add New Product</h5>
                        <h5 class="modal-title" v-show="editMode">Update Product's Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateProduct() : createProduct()"
                          enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                                       placeholder="Input Name ...">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model='form.category_id'>
                                    <option disabled value="">Select Category</option>
                                    <option v-for="(category, index) in categories" :key="index" :value="category.id">
                                        {{category.name}}
                                    </option>
                                </select>
                                <has-error :form="form" field="category_id"></has-error>
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model='form.producer_id'>
                                    <option disabled value="">Select Producer</option>
                                    <option v-for="(producer, index) in producers" :key="index" :value="producer.id">
                                        {{producer.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="col-md-9">
                                    <input type="file" name="file" v-on:change="onImageChange" class="form-control">
                                </div>
                                <div class="col-md-3" v-if="form.image">
                                    <img :src="'/img/products/' + form.image" class="img-responsive" height="70"
                                         width="90">
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea v-model="form.description"
                                          class="form-control"
                                          :class="{ 'is-invalid': form.errors.has('description') }"
                                          placeholder="Input Description ...">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <input v-model="form.amount" type="number" name="amount"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                                       placeholder="Input Amount ...">
                                <has-error :form="form" field="amount"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.price" type="number" name="price"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                                       placeholder="Input Price ...">
                                <has-error :form="form" field="price"></has-error>
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
        name: "Product",
        data() {
            return {
                editMode: false,
                products: {},
                categories: {},
                producers: {},
                form: new Form({
                    id: '',
                    name: '',
                    category_id: '',
                    producer_id: '',
                    image: '',
                    description: '',
                    amount: '',
                    price: ''
                }),
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('/api/product?page=' + page)
                    .then(response => {
                        this.products = response.data;
                    });
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            loadProducts() {
                axios.get('/api/product')
                    .then(({data}) => (this.products = data))
            },
            loadCategories() {
                axios.get('/api/getCategories')
                    .then(({data}) => (this.categories = data))
            },
            loadProducers() {
                axios.get('/api/getProducers')
                    .then(({data}) => (this.producers = data))
            },
            formEdit(product) {
                this.editMode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(product)
            },
            onImageChange(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onloadend = (file) => {
                    this.form.image = reader.result;
                };
                reader.readAsDataURL(file);
            },
            createProduct() {
                this.$Progress.start();
                this.form.post('/api/product')
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            title: 'Product created in successfully'
                        });
                        this.$Progress.finish();
                    }).catch(() => {
                });
            },
            updateProduct() {
                this.$Progress.start();
                this.form.put('/api/product/' + this.form.id)
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
            deleteProduct(productId) {
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
                        this.form.delete('/api/product/' + productId)
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
            this.loadProducts();
            this.loadCategories();
            this.loadProducers();
            Fire.$on('AfterCreate', () => {
                this.loadProducts();
            });
        }
    }
</script>

<style scoped>

</style>
