/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

import {createWebHistory, createRouter} from 'vue-router';
import store from './store';

const Media = () => import('../pages/Media');
const User = () => import('../pages/User');
const Users = () => import('../pages/Users');

export default createRouter({
	history: createWebHistory(store.state.config.webBase),
	routes: [
		{path: '/media/:pathMatch(.*.png)', component: Media},
		{path: '/media/:pathMatch(.*.jpg)', component: Media},
		{path: '/media/:pathMatch(.*)*', component: Media},
		{path: '/user', component: User},
		{path: '/user/:id', component: User, props: true},
		{path: '/users', component: Users},
		{path: '/', redirect: '/media/'}
	]
});
