require('./bootstrap');
window.Vue = require('vue');

import App from './components/App'
import Navbar from './components/parts/Navbar'
import Footer from './components/parts/Footer'
import ValidationErrors from "./components/parts/ValidationErrors";

import Posts from './components/pages/posts/Index'


Vue.component('navbar-section', Navbar)
Vue.component('footer-section', Footer)
Vue.component('validationErrors', ValidationErrors)
Vue.component('posts', Posts)

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
