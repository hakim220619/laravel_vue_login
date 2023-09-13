/* eslint-disable import/order */
import '@/@iconify/icons-bundle'
import App from '@/App.vue'
import vuetify from '@/plugins/vuetify'
import { loadFonts } from '@/plugins/webfontloader'
import router from '@/router'
import '@core-scss/template/index.scss'
import '@layouts/styles/index.scss'
import '@styles/styles.scss'
import axios from 'axios'
import { createPinia } from 'pinia'
import { createApp } from 'vue'
import VueAxios from 'vue-axios'

import store from "@/store"
import 'es6-promise/auto'
import 'sweetalert2/dist/sweetalert2.min.css'
import VueSweetalert2 from 'vue-sweetalert2'

loadFonts()


// Create vue app
const app = createApp(App)

// console.log(store.getters);
// Use plugins
app.use(vuetify)
app.use(createPinia())
app.use(VueAxios, axios);
app.use(VueSweetalert2);
app.use(router)
app.use(store)



// Mount vue app
app.mount('#app')
