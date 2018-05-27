//TODO: theme/marrom
require("./bootstrap");
import auth from "./plugin/auth";
auth.initialize()
window.Vue = require("vue");
import Chart from 'chart.js'
import VueChartkick from 'vue-chartkick'

import Vuetify from 'vuetify'
import VueRouter from "vue-router";
import App from "./views/Layout.vue";
import { EventBus } from "./bus/event-bus.js";
import moment from 'moment'
Object.defineProperty(Vue.prototype, '$moment', {
    get(){
        return this.$root.moment
    }
})
Vue.use(VueChartkick, {adapter: Chart})
Vue.use(Vuetify)
Vue.use(VueRouter);
let routes = [{
        name: 'dashboard',
        title: 'Dashboard',
        path: "/",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
           resolve(require("./views/Dashboard.vue"))
        })},
        meta: {name: 'dashboard', visible: true, title: 'Dashboard', icon: 'dashboard', requiresAuth: true}
    },{
        title: 'User',
        path: "/user",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/User.vue"))
        })},
        meta: {name: 'user', visible: true, title: 'User', icon: 'person', requiresAuth: true},
        children:[
            {
                name: 'edit',
                title: 'Edit User',
                path: "",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./User/EditUser.vue"))})},
                meta: {name: 'edit', visible: true, title: 'Edit User', icon: 'person', requiresAuth: true},
            },
            {
                name: 'change-password',
                title: 'Change Password',
                path: "change-password",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./User/ChangePassword.vue"))})},
                meta: { name: 'change-password',visible: true, title: 'Change Password', icon: 'lock', requiresAuth: true},
            },
            {
                title: 'Contribution',
                path: "contribution",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./User/Contribution/index.vue"))})},
                meta: {name: 'contribution',visible: true, title: 'Contribution', icon: 'account_balance_wallet', requiresAuth: true}
            },
            {
                title: 'Performance',
                path: "performance",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./User/Performance/index.vue"))})},
                meta: {name: 'performance',visible: true, title: 'Performance', icon: 'bar_chart', requiresAuth: true}
            },
        ]
    },
    {
        title: 'Log Activity',
        path: "/log-activity",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./LogActivity/index.vue"))})},
        meta: { employeeAuth: false, name: 'log-activity',visible: true, title: 'Log Activity', icon: 'history', requiresAuth: true}
    },
    {

        title: 'Announcement',
        path: "/announcement",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/Announcement.vue"))})},
        meta: {name: 'announcement',visible: true, title: 'Announcement', icon: 'announcement', requiresAuth: true},
        children:[
            {
                name: 'indexAnnouncement',
                title: 'Manage Announcement',
                path: "",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Announcement/Index.vue"))})},
                meta: {name: 'announcement',visible: true, title: 'Mannage Announcement ', icon: 'announcement', requiresAuth: true}
            },
            {
                beforeEnter(a, b, c) { 1 == auth.state.user.user_type ? c() : c({ path: "/not-found" }); },
                name: 'createAnnouncement',
                title: 'Create Announcement',
                path: "create",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Announcement/create.vue"))})},
                meta: {name: 'createAnnouncement',visible: true, title: 'Create Announcement', icon: 'announcement', requiresAuth: true}
            },
            {
                beforeEnter(a, b, c) { 1 == auth.state.user.user_type ? c() : c({ path: "/not-found" }); },
                name: 'editAnnouncement',
                title: 'Edit Announcement',
                path: "edit/:id",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Announcement/edit.vue"))})},
                meta: {name: 'editcreateAnnouncement',visible: true, title: 'Edit Announcement', icon: 'edit', requiresAuth: true}
            },

        ]
    },
    {
        beforeEnter(a, b, c) { 1 == auth.state.user.user_type ? c() : c({ path: "/not-found" }); },
        title: 'Performances',
        path: "/performances",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/Performance.vue"))})},
        meta: {name: 'performances',visible: true, title: 'Performances', icon: 'bar_chart', requiresAuth: true},
        children:[
            {
                name: 'indexPerformance',
                title: 'Manage Performance',
                path: "",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Performance/Index.vue"))})},
                meta: {name: 'announcement',visible: true, title: 'Mannage Performance', icon: 'announcement', requiresAuth: true}
            },
            {
                name: 'createPerformance',
                title: 'Create Performance',
                path: "create",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Performance/create.vue"))})},
                meta: {name: 'createPerformance',visible: true, title: 'Create Performance', icon: 'announcement', requiresAuth: true}
            },
            {
                name: 'editPerformance',
                title: 'Edit Performance',
                path: "edit/:id",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Performance/edit.vue"))})},
                meta: {name: 'editcreatePerformance',visible: true, title: 'Edit Performance', icon: 'edit', requiresAuth: true}
            },

        ]
    },

    {
        beforeEnter(a, b, c) { 1 == auth.state.user.user_type ? c() : c({ path: "/not-found" }); },
        title: 'Employees',
        path: "/employees",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/Employees.vue"))})},
        meta: {name: 'employees', visible: true, title: 'Employees', icon: 'people', requiresAuth: true},
        children:[
            {
                name: 'index',
                title: 'Manage Employee',
                path: "",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Employee/Index.vue"))})},
                meta: {name: 'hrmd',visible: true, title: 'Employees ', icon: 'assignment_ind', requiresAuth: true}
            },
            {
                title: 'Create employee',
                path: "create",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Employee/create.vue"))})},
                meta: {name: 'createEmployee',visible: true, title: 'Create Employee', icon: 'assignment_ind', requiresAuth: true}
            },
            {
                title: 'Edit employee',
                path: "edit/:id",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Employee/router.vue"))})},
                meta: {name: 'editEmployee',visible: true, title: 'Edit Employee', icon: 'edit', requiresAuth: true},
                children:[
                    {
                        title: 'Edit Employee',
                        path: "",
                        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Employee/edit.vue"))})},
                        meta: {name: 'editEmployee',visible: true, title: 'Edit Employee', icon: 'edit', requiresAuth: true},
                    },
                    {
                        title: 'Contribution',
                        path: "contribution",
                        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Employee/Contribution/index.vue"))})},
                        meta: {name: 'contribution',visible: true, title: 'Contribution', icon: 'account_balance_wallet', requiresAuth: true}
                    },
                    {
                        title: 'Performance',
                        path: "performance",
                        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Employee/Performance/index.vue"))})},
                        meta: {name: 'performance',visible: true, title: 'Performance', icon: 'bar_chart', requiresAuth: true}
                    },
                ]
            },

        ]
    },

    {
        beforeEnter(a, b, c) { 1 == auth.state.user.user_type ? c() : c({ path: "/not-found" }); },
        title: 'Contribution',
        path: "/contributions",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/Home.vue"))})},
        meta: {name: 'hrmd',visible: true, title: 'HRMD', icon: 'assignment_ind', requiresAuth: true},
        children:[
            {
                name: 'indexContributions',
                title: 'Manage Contributions',
                path: "",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Contribution/index.vue"))})},
                meta: {name: 'announcement',visible: true, title: 'Mannage Contributions', icon: 'announcement', requiresAuth: true}
            },
            {
                name: 'createContributions',
                title: 'Create Contributions',
                path: "create",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Contribution/create.vue"))})},
                meta: {name: 'createPerformance',visible: true, title: 'Create Contributions', icon: 'announcement', requiresAuth: true}
            },
            {

                name: 'editContributions',
                title: 'Edit Contributions',
                path: "edit/:id",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Contribution/edit.vue"))})},
                meta: {name: 'editcreateContributions',visible: true, title: 'Edit Contributions', icon: 'edit', requiresAuth: true}
            },
        ]
    },
    {
        name: 'forgot-password',
        title: 'Forgot Password',
        path: "/forgot-password",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Auth/ForgotPassword.vue"))})},
        meta: {name: 'forgot-password',visible: true, title: 'Forgot Password', requiresAuth: false}
    },
    {
        name: 'reset-password',
        title: 'Reset Password',
        path: "/Reset-password",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Auth/ResetPassword.vue"))})},
        meta: {name: 'reset-password',visible: true, title: 'Reset Password', requiresAuth: false}
    },
    {
        title: 'Documents',
        path: "/documents",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/About.vue"))})},
        meta: {name: 'documents',visible: true, title: 'Documents', icon: 'assignment', requiresAuth: true},
        children:[
            {
                name: 'indexDocuments',
                title: 'Manage Documents',
                path: "",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Documents/Index.vue"))})},
                meta: {name: 'announcement',visible: true, title: 'Mannage Documents', icon: 'announcement', requiresAuth: true}
            },
            {
                name: 'createDocuments',
                title: 'Create Documents',
                path: "create",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Documents/create.vue"))})},
                meta: {name: 'createPerformance',visible: true, title: 'Create Documents', icon: 'announcement', requiresAuth: true}
            },
            {
                name: 'editDocuments',
                title: 'Edit Documents',
                path: "edit/:id",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Documents/edit.vue"))})},
                meta: {name: 'editcreateDocuments',visible: true, title: 'Edit Documents', icon: 'edit', requiresAuth: true}
            },

        ]
    },
    {
        name: 'login',
        title: 'Login',
        path: "/login",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/Login.vue"))})},
        meta: {name: 'login',visible: false, title: 'Login', icon: 'perm_identity', requiresAuth: false}
    },
    {
        name: 'Not Found',
        title: 'Not Found ',
        path: "/not-found",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/404.vue"))})},
        meta: {name: 'Not Found',visible: false, title: 'Not Found', requiresAuth: false}
    },
    {
        beforeEnter(a, b, c) { 1 == auth.state.user.user_type ? c() : c({ path: "/not-found" }); },
        title: 'categories',
        path: "/categories",
        component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./views/Categories.vue"))})},
        meta: {name: 'login',visible: false, title: 'Login', icon: 'perm_identity', requiresAuth: false},
        children:[
            {
                name: 'indexCategories',
                title: 'Manage Categories',
                path: "",
                component: resolve => { require.ensure(["./views/Dashboard.vue"], () => {
            resolve(require("./Categories/index.vue"))})},
                meta: {name: 'indexCategories',visible: true, title: 'Manage Categories', icon: '', requiresAuth: true}
            },
        ]
    },

];
const router = new VueRouter({
    routes,
    linkExactActiveClass: 'active'
});
import {
    Loading,
    Input,
    InputNumber,
    Select,
    Option,
    OptionGroup,
    Icon,
    Button,
    DatePicker,
    Row,
    Col,
    Aside,
    Main,
    Container,
    Menu,
    Alert,
    Submenu,
    MenuItem,
    Breadcrumb,
    Upload,
    BreadcrumbItem
} from 'element-ui';
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'

// configure language
locale.use(lang)

Vue.use(Loading.directive);
Vue.use(Alert);
Vue.use(DatePicker);
Vue.use(Button);
Vue.use(Input);
Vue.use(InputNumber);
Vue.use(Select);
Vue.use(Option);
Vue.use(OptionGroup);
Vue.use(Icon);
Vue.use(Row);
Vue.use(Col);
Vue.use(Container);
Vue.use(Menu);
Vue.use(Submenu);
Vue.use(MenuItem);
Vue.use(Breadcrumb);
Vue.use(BreadcrumbItem);
Vue.use(Upload);

router.beforeEach((a, b, c) => {
    document.title = a.meta.title
    a.matched.some(d => !1 == d.meta.requiresAuth)
    ? auth.check() && "login" === a.name
        ? ((document.title = 'Login'), c({ name: "dashboard" }))
        : ((document.title = a.meta.title), c())
    : a.matched.some(d => d.meta.requiresAuth)
    ? auth.check()
        ? c()
        : ((document.title = a.meta.title), c({ name: "login" }))
    : c();
});



import {get, post} from './helper/api'
import Flash from './Noty/flash'

const app = new Vue({
    computed:{
      isAuth(){
          return this.authenticated
      }
    },
    data() {
        return {
            isDisabled: false,
            customFilter (item, queryText, itemText) {
                const hasValue = val => val != null ? val : ''
                const text = hasValue(item.title)
                const query = hasValue(queryText)
                return text.toString()
                        .toLowerCase()
                        .indexOf(query.toString().toLowerCase()) > -1
            },
            moment,
            dialog: false,
            fullscreenLoading: false,
            authenticated: auth.check(),
            user_id: auth.state.user_id,
            user: auth.state.user,
            drawer: null,
            loading: false,
            users:[],
            logActivity:[],
            announcements:[],
            performances:[],
            documents:[],
            categories:[],
            transactions: [],
            contributions: []
        };
    },
    beforeDestroy() {
        EventBus.$off("userLoggedIn", () => {
            (this.authenticated = !1), (this.user = null);
        });
        EventBus.$off("userLoggedIn", () => {
            (this.authenticated = !1), (this.user = null);
        });
    },
    mounted() {
        var vm = this
        vm.fullscreenLoading = true
        EventBus.$on("userLoggedOut", () => {
            this.authenticated = auth.check()
            this.user_id =  auth.state.user_id
            this.user = auth.state.user;
            vm.users =  []
            vm.logActivity = []
        });
        EventBus.$on("userLoggedIn", () => {
            vm.authenticated = auth.check()
            vm.user_id =  auth.state.user_id
            vm.user = auth.state.user;
            if(vm.authenticated){
                vm.initialize()
            }else{
                vm.fullscreenLoading = false
            }
        });
        if(vm.isAuth){
            vm.initialize()
        }else{
            vm.fullscreenLoading = false
        }
    },
      methods:{
        initialize(){
            var vm = this
            axios.all([
                get('/api/user'),
                get('/api/users'),
                get('/api/log-activity'),
                get('/api/announcements'),
                get('/api/performances'),
                get('/api/documents'),
                get('/api/categories'),
                get('/api/transactions'),
                get('/api/contributions'),
            ]).then(axios.spread(function (user, users, logs, announcements, performances, documents, categories, transactions, contributions) {
                vm.user = user.data
                vm.users =  users.data
                vm.logActivity = logs.data
                vm.announcements = announcements.data
                vm.performances = performances.data
                vm.documents = documents.data
                vm.categories = categories.data
                vm.transactions = transactions.data
                vm.contributions = contributions.data
                vm.fullscreenLoading = false
            })).catch(function (_ref2) {
                vm.fullscreenLoading = false
                vm.errorResponse(_ref2)
            });
        },
        successResponse(response){
            Flash("You've Successfully " + response, 'success' )
        },
          dataURItoBlob(dataURI) {
              var byteString = atob(dataURI.split(',')[1]);
              var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
              var ab = new ArrayBuffer(byteString.length);
              var ia = new Uint8Array(ab);
              for (var i = 0; i < byteString.length; i++) {
                  ia[i] = byteString.charCodeAt(i);
              }
              var blob = new Blob([ab], {type: mimeString});
              return blob;
          },
        errorResponse(_ref2){
            var vm = this

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
                if(_ref2.response.status === 401){
                    vm.fullscreenLoading = true
                    vm.drawer = false
                    post('/api/logout').then((res) => {
                        auth.remove()
                    Flash('You have successfully logged out.')
                    vm.$router.push('/login')
                    vm.fullscreenLoading = false

                })
                }
            }
            vm.fullscreenLoading = false
        }
      },
    router,
    render: b => b(App)
}).$mount("#app");
