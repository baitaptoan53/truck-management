import { createApp } from 'vue'
import router from './router/index.js'

import App from './App.vue'
// bootstrap
import 'bootstrap/dist/css/bootstrap.min.css'
//theme
import 'primevue/resources/themes/lara-light-indigo/theme.css'

import 'primeicons/primeicons.css' //icons
//core
import 'primevue/resources/primevue.min.css'
// Import PrimeVue components
import PrimeVue from 'primevue/config'
import Button from 'primevue/button'
import AutoComplete from 'primevue/autocomplete'
import Accordion from 'primevue/accordion'
import AccordionTab from 'primevue/accordiontab'
import Avatar from 'primevue/avatar'
import AvatarGroup from 'primevue/avatargroup'
import Badge from 'primevue/badge'
import BadgeDirective from 'primevue/badgedirective'
import BlockUI from 'primevue/blockui'
import Breadcrumb from 'primevue/breadcrumb'
import Calendar from 'primevue/calendar'
import Card from 'primevue/card'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import ColumnGroup from 'primevue/columngroup' // optional
import Row from 'primevue/row'
import InputText from 'primevue/inputtext' // optional
import Password from 'primevue/password'
import Checkbox from 'primevue/checkbox'
import Toast from 'primevue/toast'
import StyleClass from 'primevue/styleclass'

import CodeHighlight from '@/components/CodeHighlight.vue'
import BlockViewer from '@/components/BlockViewer.vue'

import '@/assets/styles.scss'

const app = createApp(App)
app.use(PrimeVue, { ripple: true })
app.component('CodeHighlight', CodeHighlight)
app.component('BlockViewer', BlockViewer)
app.directive('styleclass', StyleClass)

// Register PrimeVue components
app.component('Button', Button)
app.component('Accordion', Accordion)
app.component('AccordionTab', AccordionTab)
app.component('AutoComplete', AutoComplete)
app.component('Avatar', Avatar)
app.component('AvatarGroup', AvatarGroup)
app.component('Badge', Badge)
app.component('BlockUI', BlockUI)
app.component('Breadcrumb', Breadcrumb)
app.component('Calendar', Calendar)
app.component('Card', Card)
app.component('DataTable', DataTable)
app.component('Column', Column)
app.component('ColumnGroup', ColumnGroup)
app.component('Row', Row)
app.component('InputText', InputText)
app.component('Password', Password)
app.component('Checkbox', Checkbox)
app.component('Toast', Toast)

app.use(router)

app.mount('#app')
