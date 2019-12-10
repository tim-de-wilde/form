<?php

namespace form\src\Helpers;


/**
 * Class AbstractFormController
 *
 * @package form\src\Helpers
 */
abstract class AbstractFormController extends AbstractController
{
    /**@var Form $form **/
    public $form;

    public function __construct()
    {
        $this->form = new Form();

        parent::__construct();
    }

    abstract public function process(): void;

    public function render(): void
    {
        $response = $this->show();
        $this->handleForm();
        $this->additionalVars['form'] = $this->form;

        $this->renderTwig(
            $response,
            $this->additionalVars
        );
    }

    private function handleForm(): void
    {
        $isSubmitted = ($_SERVER['REQUEST_METHOD'] === 'POST');
        $form = $this->form;

        $form->setIsSubmitted($isSubmitted);

        if ($form->isSubmitted()) {
            /**@var array $data * */
            $data = $_POST;
            $items = $form->getItems();

            foreach ($items as $item) {
                if (array_key_exists($item->getName(), $data)) {
                    $item->setData($data[$item->getName()]);
                }
            }

            $form->setItems($items);
            $form->validate();
            $this->process();
        }
    }
}