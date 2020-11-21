require('./bootstrap'); // bootstrap, jquery, axios
window.Vue = require('vue');

import App from './components/App'
import Navbar from './components/parts/Navbar'
import Footer from './components/parts/Footer'
import ValidationErrors from "./components/parts/ValidationErrors";
import Posts from './components/pages/posts/Index'

Vue.component('v-navbar', Navbar);
Vue.component('v-footer', Footer);
Vue.component('v-validation-errors', ValidationErrors);
Vue.component('v-posts', Posts);


const app = new Vue({
    el: '#app',
    render: h => h(App)
});
