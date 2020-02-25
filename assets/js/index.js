import './lib/jQuery';
import 'bootstrap';

/**
 * Yii2 js
 */
import '../../vendor/yiisoft/yii2/assets/yii.js';
import '../../vendor/yiisoft/yii2/assets/yii.activeForm.js';
import '../../vendor/yiisoft/yii2/assets/yii.validation.js';
import '../../vendor/yiisoft/yii2/assets/yii.gridView.js';

/**
 * Override to krajee select 2 stuff to work with webpack
 */
import './lib/select2-krajee';

/**
 * Yii2 components
 */
import './lib/yii-confirm';
import './components/yii2.forms';

import '../../vendor/kartik-v/yii2-krajee-base/src/assets/js/kv-widgets.js';
import '../../vendor/kartik-v/yii2-krajee-base/src/assets/css/kv-widgets.css';

// import '../../vendor/kartik-v/yii2-widget-datepicker/src/assets/js/bootstrap-datepicker.js';
// import '../../vendor/kartik-v/yii2-widget-datepicker/src/assets/js/datepicker-kv.js';
// import '../../vendor/kartik-v/yii2-widget-datepicker/src/assets/css/bootstrap-datepicker4.css';

import '../../vendor/kartik-v/yii2-widget-select2/src/assets/js/select2-krajee.js';
import '../../vendor/kartik-v/yii2-widget-select2/src/assets/css/select2-krajee.css';

import '../scss/main.scss';