<?php

namespace form\src\Helpers;

use form\config\LocalConfig;
use Twig\Environment;

/**
 * Class AbstractPage
 *
 * @package Helpers
 */
abstract class AbstractController
{
    /**@var array $pageVars**/
    public $pageVars;

    /**@var array $additionalVars**/
    protected $additionalVars;


    public function __construct()
    {
        $this->additionalVars['ROOT'] = LOCAL_ROOT;
    }

    /**
     * @return PageResponse
     */
    abstract public function show(): PageResponse;

    public function render(): void
    {
        $this->renderTwig($this->show());
    }

    /**
     * @param PageResponse $response
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function renderTwig(PageResponse $response): void
    {
        /**@var Environment $twig * */
        $twig = LocalConfig::getTwigEnvironment();

        echo $twig->render(
            $response->getTwig(),
            array_merge(
                $response->getVariables(),
                $this->additionalVars ?? [],
                [
                    'ROOT' => LOCAL_ROOT
                ]
            )
        );
    }
}
