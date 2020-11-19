require('./bootstrap');
window.Vue = require('vue');

import App from './components/App'
import Navbar from './components/parts/Navbar'
import Footer from './components/parts/Footer'
import ValidationErrors from './components/parts/ValidationErrors'

import Posts from './components/pages/posts/Index'


Vue.component('navbar0', Navbar);
Vue.component('footer0', Footer);
Vue.component('validation-errors', ValidationErrors);

Vue.component('posts', Posts);

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
