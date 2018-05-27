<template>
    <div>
        <form @submit.prevent="register">
            <v-card-text>

                <v-text-field type="number" v-model="create$.user_id" :disabled="$root.$data.fullscreenLoading" name="user_id"
                              label="User ID" required/>
                <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="create$.email"
                              prepend-icon="person"
                              name="login" label="Login"
                              type="email"></v-text-field>
                <v-text-field :disabled="$root.$data.fullscreenLoading" required v-model="create$.password"
                              id="password"
                              prepend-icon="lock" name="password"
                              label="Password"
                              type="password"></v-text-field>
                <v-text-field :disabled="$root.$data.fullscreenLoading" name="password_confirmation" required v-model="create$.password_confirmation"
                              id="password_confirmation"
                              prepend-icon="lock"
                              label="Confirm Password"
                              type="password"></v-text-field>
                <v-text-field v-model="create$.first_name" :disabled="$root.$data.fullscreenLoading" name="first_name"
                              label="first_name" type="text" required/>
                <v-text-field v-model="create$.middle_name" :disabled="$root.$data.fullscreenLoading" name="middle_name"
                              label="middle_name" type="text" required/>
                <v-text-field v-model="create$.last_name" :disabled="$root.$data.fullscreenLoading" name="last_name"
                              label="last_name" type="text" required/>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click.prevent="$router.push({path: '/forgot-password'})">Forgot Password?</v-btn>
                <v-btn type="submit" :disabled="$root.$data.fullscreenLoading" color="primary">Login</v-btn>
            </v-card-actions>
        </form>
    </div>
</template>
<script>
    import Auth from "./../plugin/auth";
    import Flash from "./../Noty/flash";
    export default{
        name: 'Register',
        data() {
            return {
                create$: {
                    email: null,
                    user_id: 0,
                    password: null,
                    password_confirmation: null,
                    first_name: null,
                    middle_name: null,
                    last_name: null
                }
            }
        },
        methods: {
            register()
            {
                var vm = this;
                if(!(vm.password === vm.password_confirmation)){
                    return
                }
                vm.$root.$data.fullscreenLoading = true
                axios
                    .post("/api/register", vm.create$)
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
