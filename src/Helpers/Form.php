<?php
namespace form\src\Helpers;

/**
 * Class Form
 *
 * @package form\src\Helpers
 */
class Form
{
    /**@var FormItem[] $items**/
    private $items;

    /**@var bool $valid**/
    private $valid = true;

    /**@var bool $isSubmitted**/
    private $isSubmitted = false;

    /**
     * @param String     $name
     * @param String     $class
     * @param array|null $validators
     *
     * @return Form
     */
    public function add(String $name, String $class, ?array $validators = null): Form
    {
        /**@var AbstractFormType $formType**/
        $formType = new $class();

        $this->items[$name] = new FormItem(
            $name,
            $formType->template(),
            $validators ?? []
        );

        return $this;
    }

    /**
     * @param String $name
     *
     * @return FormItem
     */
    public function getItemByName(String $name): FormItem
    {
        foreach ($this->items as $item) {
            if ($item->getName() === $name) {
                return $item;
            }
        }
        //to prevent null pointer warnings
        return new FormItem('', '');
    }

    /**
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return $this->isSubmitted;
    }

    /**
     * @param bool $isSubmitted
     */
    public function setIsSubmitted(bool $isSubmitted): void
    {
        $this->isSubmitted = $isSubmitted;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }


    /**Validates the form & updates it with errors**/
    public function validate(): void
    {
        $items = $this->items;
        $validator = new FormValidator();

        $isValid = true;
        if ($this->isSubmitted()) {
            foreach ($items as $item) {
                $response = $validator->validate($item);
                if (\is_string($response)) {
                    $item->setInputError($response);
                    $isValid = false;
                }
            }
        }

        $this->setItems($items);
        $this->valid = $isValid;
    }

    /**
     * @return FormItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $formItems
     */
    public function setItems(array $formItems): void
    {
        $this->items = $formItems;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $array = [];

        foreach ($this->items as $item) {
            $array[$item->getName()] = $item->getData();
        }

        return $array;
    }
}