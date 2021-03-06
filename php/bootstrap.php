<?php
/**
 * api
 * @author zsx<zsx@zsxsoft.com>
 * @package api/route/error
 * @php >= 5.3
 */
namespace AppChecker;

use AppChecker\ErrorHandler;
use AppChecker\Install;
use AppChecker\Log;
use AppChecker\Run;
use Symfony\Component\Console\Application;

spl_autoload_register(function ($class) {
    $className = str_replace('\\', '/', str_replace('AppChecker\\', '', $class));
    $fileName = '/lib/' . $className . '.php';

    if (is_readable(dirname(__FILE__) . $fileName)) {
        include dirname(__FILE__) . $fileName;
    }
});

$path = $config->ZBPPath;
if (!is_dir($path) || !chdir($path)) {
    echo 'Cannot open your Z-BlogPHP index.php: ' . $path;
    exit;
}

require 'zb_system/function/c_system_base.php';
Log::Log('Loading Z-BlogPHP...', false);

if (!defined('ZC_VERSION_FULL')) {
    Log::Error('Only support Z-BlogPHP 1.5+!');
}



$zbp->Load();
ErrorHandler::Hook();
ob_flush();

$application = new Application();
$application->add(new Run());
$application->add(new Install());
$application->run();
