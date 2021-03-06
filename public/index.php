<?php

use App\Kernel;
use App\LegacyBridge;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

session_start();

// Simulate a legacy session content
$_SESSION['foo'] = 'bar';

/**
 * @var App\Kernel $kernel
 *
 * The kernel will always be available globally, allowing you to
 * access it from your existing application and through it the
 * service container. This allows for introducing new features in
 * the existing application.
 */
global $kernel;

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();

$response = $kernel->handle($request);

/*
 * LegacyBridge will take care of figuring out whether to boot up the
 * existing application or to send the Symfony response back to the client.
 */

// $scriptFile = LegacyBridge::prepareLegacyScript($request, $response, __DIR__);

// if ($scriptFile !== null) {
//     ob_start();
//     require $scriptFile;
//     ob_end_flush();
// } else {
$response->send();
// }

$kernel->terminate($request, $response);