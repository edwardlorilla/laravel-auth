<template>
    <form @submit.prevent="login">
        <v-card-text>

            <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="email" prepend-icon="person" name="login" label="Login"
                          type="email"></v-text-field>
            <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="password" id="password" prepend-icon="lock" name="password"
                          label="Password"
                          type="password"></v-text-field>

        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click.prevent="$router.push({path: '/forgot-password'})">Forgot Password?</v-btn>
            <v-btn type="submit" :disabled="$root.$data.fullscreenLoading" color="primary">Login</v-btn>
        </v-card-actions>
    </form>
</template>
<script>
    import Auth from "./../plugin/auth";
    import Flash from "./../Noty/flash";
    export default{
        name: 'Login',
        data() {
            return {email: "", password: ""};
        },
        methods: {
            login() {
                var a = {email: this.email, password: this.password};
                var vm = this;
                vm.$root.$data.fullscreenLoading = true
                axios
                    .post("/api/login", a)
                    .then(function (_ref) {
                        Auth.set(_ref.data.api_token, _ref.data.id, _ref.data)
                        vm.$router.push({name: 'dashboard'})
                    })
                    .catch(function (_ref2) {
                        vm.$root.$data.fullscreenLoading = false
                        vm.$root.errorResponse(_ref2)
                    });
            }
        }
    }
</script>
