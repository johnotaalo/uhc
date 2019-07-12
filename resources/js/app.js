/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('highcharts-vue');


window.Vue = require('vue');

import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'
import HighchartsVue from 'highcharts-vue';
import VueNumeric from 'vue-numeric'

import vSelect from 'vue-select'

// load these modules as your need
import loadStock from 'highcharts/modules/stock.js';
import loadMap from 'highcharts/modules/map.js';
import loadGantt from 'highcharts/modules/gantt.js';
import loadDrilldown from 'highcharts/modules/drilldown.js';
// some charts like solid gauge require `highcharts-more.js`, you can find it in official document.
import loadHighchartsMore from 'highcharts/highcharts-more.js';
import loadSolidGauge from 'highcharts/modules/solid-gauge.js';

import numFormat from 'vue-filter-number-format';
Vue.filter('numFormat', numFormat);



Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.component('v-select', vSelect)
Vue.use(VueNumeric)

Vue.use(HighchartsVue);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import '../../public/dashboard/fonts/feather/feather.min.css'
import '../../public/dashboard/css/theme.min.css'

Vue.component('top-bar', require('./components/menus/TopBar.vue').default)

import App from './views/App'
import Home from './views/dashboard/Home'
import Enrollment from './views/dashboard/Enrollment'
import Utilization from './views/dashboard/Utilization'
import ServiceDelivery from './views/dashboard/ServiceDelivery'
import FinancialHealth from './views/dashboard/FinancialHealth'
import UploadData from './views/dashboard/UploadData'
import Settings from './views/dashboard/Settings'
// Test Pages
import TestEnrollment from './views/dashboard/test/TestEnrollment'
import TestUtilization from './views/dashboard/test/TestUtilization'
import TestServiceDelivery from './views/dashboard/test/TestServiceDelivery'
import TestFinancialHealth from './views/dashboard/test/TestFinancialHealth'
import TestUploadData from './views/dashboard/test/TestUploadData'
import TestSettings from './views/dashboard/test/TestSettings'
import TestDataManagement from './views/dashboard/test/TestDataManagement'

 const router = new VueRouter({
 	mode: 'history',
 	linkExactActiveClass: "active",
 	routes: [
	 	{
	 		path: '',
	 		name: 'enrollment',
	 		component: Enrollment
	 	},
	 	{
	 		path: 'enrollment',
	 		name: 'enrollment',
	 		component: Enrollment
	 	},
	 	{
	 		path: 'utilization',
	 		name: 'utilization',
	 		component: Utilization
	 	},
	 	{
	 		path: 'service-delivery',
	 		name: 'serviceDelivery',
	 		component: ServiceDelivery
	 	},
	 	{
	 		path: 'financial-health',
	 		name: 'financialHealth',
	 		component: FinancialHealth
	 	},
	 	{
	 		path: 'upload-data',
	 		name: 'uploadData',
	 		component: UploadData
	 	},
	 	{
	 		path: 'settings',
	 		name: "settings",
	 		component: Settings
	 	},
	 	{
	 		path: '/test/',
	 		name: 'test.enrollment',
	 		component: Enrollment
	 	},
	 	{
	 		path: '/test/enrollment',
	 		name: 'test.enrollment',
	 		component: TestEnrollment
	 	},
	 	{
	 		path: '/test/utilization',
	 		name: 'test.utilization',
	 		component: TestUtilization
	 	},
	 	{
	 		path: '/test/service-delivery',
	 		name: 'test.serviceDelivery',
	 		component: TestServiceDelivery
	 	},
	 	{
	 		path: '/test/financial-health',
	 		name: 'test.financialHealth',
	 		component: TestFinancialHealth
	 	},
	 	{
	 		path: '/test/upload-data',
	 		name: 'test.uploadData',
	 		component: TestUploadData
	 	},
	 	{
	 		path: '/test/settings',
	 		name: "test.settings",
	 		component: TestSettings
	 	},
	 	{
	 		path: '/test/data/management',
	 		name: 'test.datamanagement',
	 		component: TestDataManagement
	 	}
 	]
 });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router
});
