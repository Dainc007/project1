import './bootstrap';
import '../css/app.css';
import '@formkit/themes/genesis'

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import {plugin as formKitPlugin, defaultConfig} from '@formkit/vue'
import {pl} from '@formkit/i18n'
import { i18nVue } from 'laravel-vue-i18n'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(i18nVue, {
                resolve: async lang => {
                    const languages = import.meta.glob('../../lang/*.json');
                    return await languages[`../../lang/${lang}.json`]();
                }
            })
            .use(formKitPlugin, defaultConfig({
                locales: {pl},
                locale: 'pl',
            }))
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
