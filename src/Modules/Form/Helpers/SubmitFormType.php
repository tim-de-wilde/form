<?php


namespace form\src\Modules\Form\Helpers;


use form\src\Helpers\AbstractFormType;

/**
 * Class SubmitFormType
 *
 * @package form\src\Modules\Form\Helpers
 */
class SubmitFormType extends AbstractFormType
{
    public const FIELD_VALUE = 'value';

    /**
     * @return String
     */
    public function template(): String
    {
        return '_submitInput.html.twig';
    }
}