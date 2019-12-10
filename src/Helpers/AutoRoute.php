<?php

namespace form\src\Helpers;


use form\src\Views\PageNotFound;

/**
 * Class AutoRoute
 *
 * @package tdewmain\src\Helpers
 */
class AutoRoute
{
    private $router;

    /**
     * AutoRoute constructor.
     *
     * @param \AltoRouter $router
     */
    public function __construct(\AltoRouter $router)
    {
        $this->router = $router;
    }

    /**
     * @throws \Exception
     */
    public function route(): void
    {
        $modules = glob(__DIR__ . '/../Modules/*', GLOB_ONLYDIR);
        foreach ($modules as $module) {
            $xml = simplexml_load_string(
                file_get_contents("$module/Routes/routes.xml")
            );

            foreach ($xml->route as $route) {
                $arr = (array)$route;
                    $this->router->map(
                        $arr['method'],
                        $arr['route'],
                        function ($params) use ($arr) {
                            /**@var AbstractController $controller * */
                            $controller = new $arr['controller']();
                            $controller->pageVars = array_merge($params, $_GET, $_POST);
                            $controller->render();
                        });
            }
        }
        $this->dispatch();
    }

    private function dispatch(): void
    {
        $match = $this->router->match();

        if ($match !== false) {
            /** @noinspection OffsetOperationsInspection */
            $match['target']($match['params']);
            return;
        }
        
        (new PageNotFound())->render();
    }
}
