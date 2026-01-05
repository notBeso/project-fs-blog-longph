import 'bootstrap/dist/css/bootstrap.css';
import BootstrapVueNext from 'bootstrap-vue-next';
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';
import { createApp , ref } from 'vue';
import App from './app/pages/index.vue';
import router from './router';

const app = createApp(App);

app.use(router);
app.use(BootstrapVueNext);
app.mount('#app');
