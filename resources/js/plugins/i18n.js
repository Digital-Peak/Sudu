/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

import {createI18n} from 'vue-i18n';
import store from './store';

const locales = require.context('../locales', true, /[A-Za-z0-9-_,\s]+\.json$/i);
const messages = {};
locales.keys().forEach(key => {
	const matched = key.match(/([A-Za-z0-9-_]+)\./i);
	if (matched && matched.length > 1) {
		const locale = matched[1];
		messages[locale] = locales(key);
	}
});

export default createI18n({
	locale: store.state.config.locale || 'en',
	fallbackLocale: store.state.config.fallbackLocale || 'en',
	silentTranslationWarn: true,
	messages: messages
});
