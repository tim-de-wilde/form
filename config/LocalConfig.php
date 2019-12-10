<?php
namespace form\config;

use Twig\Environment;

/**
 * Class LocalConfig
 *
 * @package tdewmain\src\Helpers
 */
class LocalConfig
{
    /**@var Environment**/
    private static $twigEnvironment;

    /**
     * @return array
     */
    public static function getConfig(): array
    {
        return [
            'postcode_url' => 'http://json.api-postcode.nl',
            'postcode_api_key' => ''
        ];
    }

    /**
     * @return Environment
     */
    public static function getTwigEnvironment(): Environment
    {
        return static::$twigEnvironment;
    }

    /**
     * @param Environment $twigEnvironment
     */
    public static function setTwigEnvironment(Environment $twigEnvironment
    ): void {
        static::$twigEnvironment = $twigEnvironment;
    }
}