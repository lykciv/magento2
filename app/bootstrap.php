<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

/**
 * Environment initialization
 */
error_reporting(E_ALL);
#ini_set('display_errors', 1);
umask(0);

/* PHP version validation */
if (version_compare(phpversion(), '5.4.11', '<') === true) {
    if (PHP_SAPI == 'cli') {
        echo 'Magento supports PHP 5.4.11 or newer. Please read http://www.magento.com/install.';
    } else {
        echo <<<HTML
<div style="font:12px/1.35em arial, helvetica, sans-serif;">
    <div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
        <h3 style="margin:0;font-size:1.7em;font-weight:normal;text-transform:none;text-align:left;color:#2f2f2f;">
        Whoops, it looks like you have an invalid PHP version.</h3>
    </div>
    <p>Magento supports PHP 5.4.11 or newer.
</div>
HTML;
    }
    exit(1);
}

require_once __DIR__ . '/autoload.php';
require_once BP . '/app/functions.php';

if (!empty($_SERVER['MAGE_PROFILER'])) {
    \Magento\Framework\Profiler::applyConfig($_SERVER['MAGE_PROFILER'], BP, !empty($_REQUEST['isAjax']));
}
if (ini_get('date.timezone') == '') {
    date_default_timezone_set(\Magento\Framework\Stdlib\DateTime\TimezoneInterface::DEFAULT_TIMEZONE);
}
