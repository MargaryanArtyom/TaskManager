import './bootstrap';
import '../sass/app.scss'
import Router from '@/router'
import store from '@/store'

import Toast from "@brackets/vue-toastification";
import "@brackets/vue-toastification/dist/index.css";

import { createApp } from 'vue/dist/vue.esm-bundler';

const app = createApp({})
app.use(Router)
app.use(store)
app.use(Toast)
app.mount('#app')
