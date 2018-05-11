require("./bootstrap");
import auth from "./plugin/auth";
auth.initialize()
window.Vue = require("vue");
import Vuetify from 'vuetify'
import VueRouter from "vue-router";
import App from "./views/Layout.vue";
import { EventBus } from "./bus/event-bus.js";
Vue.use(Vuetify)
Vue.use(VueRouter);
let routes = [
    {
        name: 'dashboard',
        title: 'Dashboard',
        path: "/dashboard",
        component: require("./views/Dashboard.vue"),
        meta: {visible: true, title: 'Dashboard', icon: 'dashboard', requiresAuth: true}
    },
    {
        name: 'hrmd',
        title: 'HRMD',
        path: "/",
        component: require("./views/Home.vue"),
        meta: {visible: true, title: 'HRMD', icon: 'assignment_ind', requiresAuth: true}
    },
    {
        name: 'records',
        title: 'Records',
        path: "/about",
        component: require("./views/About.vue"),
        meta: {visible: true, title: 'Records', icon: 'assignment', requiresAuth: false}
    },
    {
        name: 'login',
        title: 'Login',
        path: "/login",
        component: require("./views/Login.vue"),
        meta: {visible: false, title: 'Login', icon: 'perm_identity', requiresAuth: false}
    }
];
const router = new VueRouter({ routes });

router.beforeEach((a, b, c) => {
    document.title = a.meta.title
    a.matched.some(d => !1 == d.meta.requiresAuth)
    ? auth.check() && "login" === a.name ? c({ name: "dashboard" }) : c()
    : a.matched.some(d => d.meta.requiresAuth)
    ? auth.check() ? c() : c({ name: "login" })
    : c();
});




new Vue({
    computed:{
      isAuth(){
          return this.authenticated
      }
    },
    data() {
        return {
            authenticated: auth.check(),
            user_id: auth.state.user_id,
            user: auth.state.user,
            drawer: null,
            loading: false
        };
    },
    beforeDestroy() {
        EventBus.$off("userLoggedIn", () => {
            (this.authenticated = !1), (this.user = null);
        });
    },
    mounted() {

        EventBus.$on("userLoggedIn", () => {
            (this.$router.push({name: 'dashboard'})), (this.loading = false), (this.authenticated = auth.check()), (this.user_id =  auth.state.user_id) ,(this.user = auth.state.user);
        });
    },
    router,
    render: b => b(App)
}).$mount("#app");
