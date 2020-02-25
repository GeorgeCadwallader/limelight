import './lib/jQuery';
import 'bootstrap';

/**
 * Yii2 js
 */
import 'vendor/yiisoft/yii2/assets/yii.js';
import 'vendor/yiisoft/yii2/assets/yii.activeForm.js';
import 'vendor/yiisoft/yii2/assets/yii.validation.js';
import 'vendor/yiisoft/yii2/assets/yii.gridView.js';

import 'vendor/kartik-v/yii2-krajee-base/src/assets/js/kv-widgets.min.js';
import 'vendor/kartik-v/yii2-widget-datepicker/src/assets/js/bootstrap-datepicker.min.js';
import 'vendor/kartik-v/yii2-widget-datepicker/src/assets/js/datepicker-kv.min.js';
import 'vendor/kartik-v/yii2-widget-datepicker/src/assets/css/bootstrap-datepicker3.css';

import 'vendor/kartik-v/yii2-widget-select2/src/assets/js/select2-krajee.js';

/**
 * Override to krajee select 2 stuff to work with webpack
 */
import './lib/select2-krajee';

/**
 * Yii2 components
 */
import './lib/yii-confirm';
import './components/yii2.forms';

import '../scss/main.scss';