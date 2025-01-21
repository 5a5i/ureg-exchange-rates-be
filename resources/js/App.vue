<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <!-- <a href="https://shouts.dev/" target="_blank"><img src="https://i.imgur.com/hHZjfUq.png"></a><br> -->
            <span class="text-secondary"></span>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <!-- for logged-in user -->
                <div class="navbar-nav ms-auto" v-if="isLoggedIn">
                    <!-- Align menus to the left -->
                    <!-- <div class="me-auto"> -->
                        <!-- <router-link to="/developer" class="nav-item nav-link">Dashboard</router-link> -->
                        <router-link to="/developer" class="nav-item nav-link">Developers</router-link>
                        <a href="/products" class="nav-item nav-link">Products</a>
                    <!-- </div> -->
                    <!-- Align logout to the right -->
                    <!-- <div class="ms-auto"> -->
                        <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
                    <!-- </div> -->
                </div>
                <!-- for non-logged user -->
                <div class="navbar-nav ms-auto" v-else>
                    <!-- Align menus to the left -->
                    <!-- <div class="me-auto"> -->
                        <!-- <router-link to="/" class="nav-item nav-link">Home</router-link> -->
                        <a href="/welcome" class="nav-item nav-link">Home</a>
                        <a href="/products" class="nav-item nav-link">Products</a>
                        <!-- <router-link to="/about" class="nav-item nav-link">About</router-link> -->
                    <!-- </div> -->
                    <!-- Conditionally display Register or Login -->
                    <!-- <div class="ms-auto"> -->
                        <router-link v-if="$route.path !== '/login'" to="/login" class="nav-item nav-link">Login</router-link>
                        <router-link v-if="$route.path !== '/register'" to="/register" class="nav-item nav-link">Register</router-link>
                    <!-- </div> -->
                </div>
            </div>
            </nav>
        <br/>
        <router-view/>
    </div>
</template>

<script>

export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        }

    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {
        logout(e) {
            e.preventDefault()
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>
