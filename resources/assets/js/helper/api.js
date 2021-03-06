/**
 * Created by Edward Lance Lorilla on 5/10/2018.
 */

import Auth from '../plugin/auth'
export function get(url) {
    return axios({
        method: 'GET',
        url: url,
        headers: {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}

export function post(url, payload) {
    return axios({
        method: 'POST',
        url: url,
        data: payload,
        headers: {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}
export function put(url, payload) {
    return axios({
        method: 'PUT',
        url: url,
        data: payload,
        headers: {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}
// delete is reserved keyword
export function del(url) {
    return axios({
        method: 'DELETE',
        url: url,
        headers: {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}

export function interceptors(cb) {
    axios.interceptors.response.use((res) => {
        return res;
}, (err) => {
        cb(err)
        return Promise.reject(err)
    })
}
