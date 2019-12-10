<?php


namespace form\src\Helpers;


/**
 * Class FormType
 *
 * @package form\src\Helpers
 */
class FormItem
{
    /**@var String $name**/
    private $name;
    /**@var String $template**/
    private $template;
    /**@var array $validators**/
    private $validators;

    /**@var String $inputError
     * Will be changed by controller to the return value of a failed validator
     **/
    private $inputError;

    private $data;

    /**
     * FormType constructor.
     *
     * @param String $name
     * @param String $template
     * @param array  $validators
     */
    public function __construct(
        String $name,
        String $template,
        array $validators = null
    )
    {
        $this->name = $name;
        $this->template = $template;
        $this->validators = $validators;
    }

    /**
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getTemplate(): String
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getValidators(): array
    {
        return $this->validators;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return String|null
     */
    public function getInputError(): ?String
    {
        return $this->inputError;
    }

    /**
     * @param String $inputError
     */
    public function setInputError(String $inputError): void
    {
        $this->inputError = $inputError;
    }
}