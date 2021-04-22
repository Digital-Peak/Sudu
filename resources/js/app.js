/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

import './plugins/config';
import {createApp} from 'vue';
import router from './plugins/router';
import store from './plugins/store';
import i18n from './plugins/i18n';
import App from './App';

const app = createApp(App);
app.directive('focus', {
	mounted(el) {
		el.focus()
	}
});
app.use(router);
app.use(store);
app.use(i18n);
app.mount('.dp-app');
