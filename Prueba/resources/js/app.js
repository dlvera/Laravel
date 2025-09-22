import './bootstrap';
import { createApp } from 'vue';
import UsersTable from './components/UsersTable.vue';
import LocationSelects from './components/LocationSelects.vue';

const app = createApp({});

app.component('users-table', UsersTable);
app.component('location-selects', LocationSelects);

app.mount('#app');