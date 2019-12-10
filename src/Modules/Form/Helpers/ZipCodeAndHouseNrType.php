<?php
namespace form\src\Modules\Form\Helpers;


use form\src\Helpers\AbstractFormType;

/**
 * Class ZipCodeAndHouseNrType
 *
 * @package form\src\Modules\Form\Helpers
 */
class ZipCodeAndHouseNrType extends AbstractFormType
{
    public const FIELD_POSTCODE = 'postcode';

    public const FIELD_HOUSENR = 'housenr';

    /**
     * @return String
     */
    public function template(): String
    {
        return '_zipcodeHousenr.html.twig';
    }
}