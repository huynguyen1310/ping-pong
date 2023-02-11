import './bootstrap';

import Alpine from 'alpinejs';
import search from './alpine/search.js';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.data('search', search);

Alpine.start();
