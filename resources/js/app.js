import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';


// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
  })

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

// new Vue({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => require(`./Pages/${name}.vue`),
//     // resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//     setup({ el, app, props, plugin }) {
//         return createApp({ render: () => h(app, props) })
//             .use(plugin)
//             .use(ZiggyVue, Ziggy)
//             .mount(el);
//     },
// });

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    // resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.globEager('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(vuetify)

            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

// require('./bootstrap');

// import Vue from 'vue';
// import Vuetify from 'vuetify';

// import { createInertiaApp } from '@inertiajs/inertia-vue3';
// import { InertiaProgress } from '@inertiajs/progress';

// import 'vuetify/dist/vuetify.min.css';

// Vue.mixin({ methods: { route } });
// Vue.use(createInertiaApp);
// Vue.use(InertiaProgress);
// Vue.use(Vuetify)

// const app = document.getElementById('app');

// new Vue({
//     vuetify: new Vuetify(),
//     render: (h) =>
//         h(InertiaApp, {
//             props: {
//                 initialPage: JSON.parse(app.dataset.page),
//                 resolveComponent: (name) => require(`./Pages/${name}`).default,
//             },
//         }),
// }).$mount(app);