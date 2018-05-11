<template>
    <form @submit.prevent="login">
        <v-card-text>

            <v-text-field :disabled="$root.$data.loading" required v-model="email" prepend-icon="person" name="login" label="Login"
                          type="email"></v-text-field>
            <v-text-field :disabled="$root.$data.loading" required v-model="password" id="password" prepend-icon="lock" name="password"
                          label="Password"
                          type="password"></v-text-field>

        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="submit" v-if="!$root.$data.loading" color="primary">Login</v-btn>
            <v-progress-circular v-else  indeterminate color="primary"></v-progress-circular>
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
                vm.$root.$data.loading = true
                axios
                    .post("/api/login", a)
                    .then(function (_ref) {
                        Auth.set(_ref.data.api_token, _ref.data.id, _ref.data)
                    })
                    .catch(function (_ref2) {
                        if (_ref2.response) {
                            _.forEach(_ref2.response.data, function (value, key) {
                                if (_.isObject(value)) {
                                    _.forEach(value, function (error, key) {
                                        if (_.isArray(error)) {
                                            _.forEach(error, function (err, key) {
                                                Flash(err, 'warning')
                                            })
                                        } else {
                                            Flash(error, 'warning')
                                        }
                                    });
                                } else {
                                    Flash(value, 'warning')
                                }
                            });
                        }
                        vm.$root.$data.loading = false
                    });
            }
        }
    }
</script>
