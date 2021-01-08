require('./bootstrap')
window.Vue = require('vue')


import Home from './components/Home.vue'


import VueAxios from 'vue-axios'
import axios from 'axios'

import Toast from "vue-toastification"
import "vue-toastification/dist/index.css"

import VueCookies from 'vue-cookies'

Vue.use(VueCookies)
Vue.use(Toast)
Vue.use(VueAxios, axios)

Vue.prototype.$authUser = window.user


const app = new Vue({
    el: '#app',
    components: { Home }
})
