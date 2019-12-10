<?php

use form\config\LocalConfig;
use form\src\Helpers\AutoRoute;
use form\src\Views\ErrorFound;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

include __DIR__ . '/vendor/autoload.php';

try {
    session_start();

    // Global constants
    include __DIR__ . '/src/Helpers/constants.php';

    //Local config
    include __DIR__ . '/config/LocalConfig.php';

    //setup Propel
    include __DIR__ . '/propel/generated-conf/config.php';

    //Router
    include __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
    $altoRouter = new AltoRouter();
    $altoRouter->setBasePath('/Form');

    include __DIR__ . '/src/Helpers/AutoRoute.php';
    $autoRoute = new AutoRoute($altoRouter);

    include __DIR__ . '/vendor/twig/twig/src/Loader/FilesystemLoader.php';
    include __DIR__ . '/vendor/twig/twig/src/Environment.php';

    $twigLoader = new FilesystemLoader(__DIR__ . '/src/Templates');
    $twig = new Environment(
        $twigLoader
//    [
//        'cache' => __DIR__ . '/src/Templates/compilation_cache'
//    ]
    );
    $twig->addExtension(new \Twig\Extension\DebugExtension());

    LocalConfig::setTwigEnvironment($twig);

    $autoRoute->route();
} catch (Throwable $e) {
    var_dump($e);
    (new ErrorFound)->render();
}