/**
 * Created by Edward Lance Lorilla on 5/10/2018.
 */
import { EventBus } from './../bus/event-bus.js';
export default {
    state: {
        api_token: null,
        user_id: null,
        user: null
    },
    initialize() {
        this.state.api_token = localStorage.getItem('api_token') ?  window.atob(localStorage.getItem('api_token')) : ''
        this.state.user_id = parseInt(localStorage.getItem('user_id'))
        this.state.user = JSON.parse(localStorage.getItem('user'))
    },
    updateProfile(api_token, user_id, auth){
        this.setAllItem(api_token, user_id, auth)
        this.initialize()
    },
    setAllItem(api_token, user_id, auth){
        localStorage.setItem('api_token', api_token ? window.btoa(api_token) : '')
        localStorage.setItem('user_id', user_id)
        localStorage.setItem('user', JSON.stringify(auth) )
    },
    set(api_token, user_id, auth) {
        this.setAllItem(api_token, user_id, auth)
        this.initialize()
        EventBus.$emit('userLoggedIn');

    },
    check () {
        return !! this.state.api_token &&  (this.state.api_token.length === 60) &&  (this.state.api_token === this.state.user.api_token) && _.isNumber(this.state.user_id) && _.isObject(this.state.user);
    },
    remove() {
        localStorage.removeItem('api_token')
        localStorage.removeItem('user')
        localStorage.removeItem('user_id')
        this.initialize()
        EventBus.$emit('userLoggedOut');
    }
}