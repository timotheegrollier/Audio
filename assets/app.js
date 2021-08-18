import jquery from 'jquery';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';

// Import Nosleep for upload

import NoSleep from 'nosleep.js';


import './flash_timeout'
import './image_preview'
import './upload_form'
import './sound_constraint'


var noSleep = new NoSleep();
