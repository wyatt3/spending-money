require('./bootstrap')

import { createApp } from 'vue'
import UserInformation from './components/UserInformation.vue'

const app = createApp({})

app.component('user-information', UserInformation)

app.mount('#app')
