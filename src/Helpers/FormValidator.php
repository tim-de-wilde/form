<?php


namespace form\src\Helpers;


use form\config\LocalConfig;
use form\src\Modules\Form\Helpers\ZipCodeAndHouseNrType;

/**
 * Class FormValidatorMap
 *
 * @package form\src\Helpers
 */
class FormValidator
{
    /**Simple empty check**/
    public const TYPE_EMPTY = 'empty';

    /**Email validator**/
    public const TYPE_EMAIL = 'email';

    /**Address validator, will check postcode.nl if it exists**/
    public const TYPE_ADDRESS = 'address';

    /**Name validator**/
    public const TYPE_INITIAL_AND_FIRSTNAME = 'initialAndFirstName';

    /**Phone number**/
    public const TYPE_PHONENR = 'phonenr';

    /**Password**/
    public const TYPE_PASSWORD = 'password';

    /**
     * @param FormItem $item
     *
     * Validation process. True is returned if the value meets the validator, otherwise it will return a string containing the error.
     * In case of multiple validators it will give the first error it meets
     *
     * @return string|bool
     */
    public function validate(FormItem $item)
    {
        $validators = $item->getValidators();
        $value = $item->getData();

        foreach ($validators as $type) {
            //Validation for multiple values
            if (\is_array($value)) {
                switch ($type) {
                    case self::TYPE_EMPTY:
                        $empty = false;
                        if (empty($value)) {
                            $empty = true;
                        } else {
                            foreach ($value as $v) {
                                if (empty($v)) {
                                    $empty = true;
                                }
                            }
                        }

                        if ($empty) {
                            return 'Lege waarde';
                        }
                        break;
                    case self::TYPE_INITIAL_AND_FIRSTNAME:
                        $end = end($value);
                        $start = reset($value);

                        if (empty($start) || empty($end) || strpos(end($value), substr(reset($value), 0, 1)) !== 0) {
                            return 'Voorletter komt niet overeen met voornaam';
                        }

                        break;
                    case self::TYPE_ADDRESS:
                        //This validator is only used for the ZipCodeandHouseNrType
                        if (!$this->validatePostcode($value[ZipCodeAndHouseNrType::FIELD_POSTCODE])) {
                           return 'Postcode ongeldig';
                        }
                        break;
                }
            }

            //Validation for single values
            elseif (\is_string($value)) {
                switch ($type) {
                    case self::TYPE_EMPTY:
                        if (empty($value)) {
                            return 'Lege waarde';
                        }
                        break;

                    case self::TYPE_EMAIL:
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            return 'Ongeldige email';
                        }
                        break;

                    case self::TYPE_PHONENR:
                        if (!$this->validateNLNumber($value)) {
                            return 'Ongeldig telefoonnummer';
                        }
                        break;
                    case self::TYPE_PASSWORD:
                        if (\strlen($value) < 12) {
                            return 'Wachtwoord moet ten minste uit 12 karakters bestaan';
                        }
                        break;
                }
            }
        }
        return true;
    }


    /**
     * @param string $number
     *
     * @return bool
     */
    private function validateNLNumber(string $number): bool
    {
        $regex = '^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$^';

        return preg_match($regex, $number);
    }

    /**
     * @param $postcode
     *
     * @return bool
     */
    private function validatePostcode(String $postcode): bool
    {
        $pattern = '{
                    \A                        
                    [1-9][0-9]{3}               
                    (                               
                        [A-RT-Z] [A-Z]             
                        |                          
                        [S] [BCE-RT-Z]                
                    )          
                    \z                            
                }x';

        if ($postcode <= '9999XL' && preg_match($pattern,$postcode)) {
            $localConfig = LocalConfig::getConfig();
            $api = new PostCodeApi($localConfig['postcode_api_key'], $localConfig['postcode_url']);

            $result = $api->getPostcode($postcode);

            if ($result !== null) {
                return true;
            }
        }
        return false;
    }
}