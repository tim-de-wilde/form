<?php
namespace form\src\Modules\Form\Helpers;


use form\src\Helpers\AbstractFormType;

/**
 * Class InputFormType
 *
 * @package form\src\Modules\Form\Helpers
 */
class InputFormType extends AbstractFormType
{
    public const FIELD_VALUE = 'value';

    /**
     * @return String
     */
    public function template(): String
    {
        return '_textInput.html.twig';
    }

}