<?php
namespace form\src\Helpers;

/**
 * Class AbstractResponse
 *
 * @package tdewmain\src\Helpers
 */
class PageResponse
{
    private $twig;
    private $variables;

    /**
     * AbstractResponse constructor.
     *
     * @param String $twig
     * @param array  $variables
     */
    public function __construct(String $twig, array $variables)
    {
        $this->twig = $twig;
        $this->variables = $variables;
    }

    /**
     * @return String
     */
    public function getTwig(): String
    {
        return $this->twig;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }
}
