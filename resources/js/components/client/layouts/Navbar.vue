<template>
    <div id="navbar">
        <nav class="navbar custom-nav fixed-top navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <router-link class="navbar-brand" to="/">Vue Shop</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/products" class="nav-link" href="#">Products</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/about" class="nav-link" href="#">About</router-link>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <a class="btn btn-outline-success my-2 my-sm-0 mx-2" data-toggle="modal" data-target="#login">Get
                            Start</a>
                        <a class="btn btn-outline-info my-2 my-sm-0 mx-2" data-toggle="modal"
                           data-target="#miniCart"><i class="fas fa-cart-plus"></i></a>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Modal Get Start-->
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <ul class="nav nav-fill nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-login"
                                   role="tab" aria-controls="pills-login" aria-selected="true">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-register-tab" data-toggle="pill" href="#pills-register"
                                   role="tab" aria-controls="pills-register" aria-selected="false">Signup</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-login" role="tabpanel"
                                 aria-labelledby="pills-login-tab">
                                <h5 class="text-center">Login Please</h5>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                           aria-describedby="emailHelp" placeholder="Enter email">
                                    <small class="form-text text-muted">We'll never share your email with anyone
                                        else.</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control"
                                           id="exampleInputPassword1"
                                           placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Login</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-register" role="tabpanel"
                                 aria-labelledby="pills-register-tab">

                                <h5 class="text-center">Create New Account</h5>
                                <div class="form-group">
                                    <label for="name">Your name</label>
                                    <input type="text" class="form-control" id="name"
                                           placeholder="Your nice name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email"
                                           aria-describedby="emailHelp"
                                           placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password"
                                           placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Signup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Get Start-->
        <!-- Modal Mini Cart -->
        <div class="modal fade" id="miniCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-shopping-bag"></i> My Bag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li class="media">
                                <img width="80px" class="align-self-center mr-3" alt="">
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <p class="mx-2"></p>
                                        <span class='btn btn-danger float-right'>Delete</span>
                                    </h5>
                                    <p class="mt-0"></p>
                                    <p class="mt-0"></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Continue Shopping</button>
                        <button type="button" class="btn btn-primary">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End Modal Mini cart-->
    </div>
</template>

<script>
    export default {
        name: "Navbar",
        props: {
            msg: String
        },
        components: {}
    };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
    @media (min-width: 992px) {
        #navbar.custom-nav {
            top: 16px;
            background-color: transparent !important;
        }
    }
</style>
