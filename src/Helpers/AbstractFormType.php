<?php
namespace form\src\Helpers;


/**
 * Class AbstractFormType
 *
 * @package form\src\Helpers
 */
abstract class AbstractFormType
{
    /**
     * @return String
     */
    abstract public function template(): String;
}