<?php


namespace form\src\Modules\Form\Helpers;


use form\src\Helpers\AbstractFormType;

/**
 * Class FirstNameAndInitial
 *
 * @package form\src\Modules\Form\Helpers
 */
class FirstNameAndInitialType extends AbstractFormType
{
    public const FIELD_VOORLETTER = 'voorletter';

    public const FIELD_VOORNAAM = 'voornaam';

    /**
     * @return String
     */
    public function template(): String
    {
        return '_firstNameAndInitial.html.twig';
    }
}