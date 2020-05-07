<template>
    <div class="admin">
        <div class="page-wrapper default-theme sidebar-bg bg1 toggled">
            <a id="show-sidebar" @click="closeMenu" class="btn btn-sm btn-dark" href="#">
                <i class="fas fa-bars"></i>
            </a>
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="sidebar-content">
                    <!-- sidebar-brand  -->
                    <div class="sidebar-item sidebar-brand">
                        <a href="#">Vue Shop</a>
                        <div id="close-sidebar" @click="closeMenu">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                    <!-- sidebar-header  -->
                    <div class="sidebar-item sidebar-header">
                        <div class="user-pic">
                            <img class="img-responsive img-rounded" src="/img/user.png" alt="User picture">
                        </div>
                        <div class="user-info">
                            <span class="user-name">
                                <strong>ADMIN</strong>
                            </span>
                            <span class="user-role">hnam.vuong</span>
                            <span class="user-status">
                                <i class="fas fa-circle green"></i>
                                <span>Online</span>
                            </span>
                        </div>
                    </div>
                    <!-- sidebar-search  -->
                    <div class="sidebar-item sidebar-search">
                        <div>
                            <div class="input-group">
                                <input type="text" class="form-control search-menu" placeholder="Search...">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- sidebar-menu  -->
                    <div class=" sidebar-item sidebar-menu">
                        <ul>
                            <li class="header-menu">
                                <span>Menu</span>
                            </li>
                            <li>
                                <router-link to="/admin/overview">
                                    <i class="fa fa-chart-line blue"></i>
                                    <span>Overview</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/admin/categories">
                                    <i class="fas fa-list-ul indigo"></i>
                                    <span>Categories</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/admin/producers">
                                    <i class="fab fa-amazon purple"></i>
                                    <span>Producers</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/admin/products">
                                    <i class="fas fa-barcode green"></i>
                                    <span>Products</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/admin/profile">
                                    <i class="fa fa-user orange"></i>
                                    <span>Profile</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/admin/orders">
                                    <i class="fa fa-shopping-cart teal"></i>
                                    <span>Orders</span>
                                </router-link>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-power-off red"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- sidebar-menu  -->
                </div>
            </nav>
            <!-- sidebar-content  -->
            <main class="page-content">
                <router-view/>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
    </div>
</template>

<script>
    export default {
        name: "Admin",
        methods: {
            closeMenu() {
                $(".page-wrapper").toggleClass("toggled");
            }
        }
    }
</script>

<style scoped>
    .router-link-exact-active{
        background-color: #3f51b5;
        color:#fff !important;
    }
</style>
