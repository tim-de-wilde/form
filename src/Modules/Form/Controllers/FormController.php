<?php
namespace form\src\Modules\Form\Controllers;

use form\config\LocalConfig;
use form\src\Helpers\AbstractFormController;
use form\src\Helpers\FormValidator;
use form\src\Helpers\PageResponse;
use form\src\Helpers\PostCodeApi;
use form\src\Modules\Form\Helpers\FirstNameAndInitialType;
use form\src\Modules\Form\Helpers\InputFormType;
use form\src\Modules\Form\Helpers\SubmitFormType;
use form\src\Modules\Form\Helpers\ZipCodeAndHouseNrType;
use formResults\formResultsQuery;

/**
 * Class Form
 *
 * @package form\src\Modules\Form\Controllers
 */
class FormController extends AbstractFormController
{
    /**
     * @return PageResponse
     */
    public function show(): PageResponse
    {
        $this->form
            ->add(
                'Voornaam',
                FirstNameAndInitialType::class,
                [FormValidator::TYPE_EMPTY, FormValidator::TYPE_INITIAL_AND_FIRSTNAME]
            )
            ->add(
                'Achternaam',
                InputFormType::class,
                [FormValidator::TYPE_EMPTY]
            )
            ->add(
                'Postcode',
                ZipCodeAndHouseNrType::class,
                [FormValidator::TYPE_ADDRESS, FormValidator::TYPE_EMPTY]
            )
            ->add('Email',
                  InputFormType::class,
                  [FormValidator::TYPE_EMPTY, FormValidator::TYPE_EMAIL]
            )
            ->add('Phonenumber',
                  InputFormType::class,
                  [FormValidator::TYPE_EMPTY, FormValidator::TYPE_PHONENR]
            )
            ->add('Password',
                  InputFormType::class,
                  [FormValidator::TYPE_EMPTY, FormValidator::TYPE_PASSWORD]
            )
            ->add('Submit',
                  SubmitFormType::class
            );

        return new PageResponse('basic_form.html.twig', []);
    }

    public function process(): void
    {
        $form = $this->form;
        $config = LocalConfig::getConfig();

        if ($form->isValid()) {
            $postcode = $form->getItemByName('Postcode')->getData()[ZipCodeAndHouseNrType::FIELD_POSTCODE];
            $api = new PostCodeApi($config['postcode_api_key'], $config['postcode_url']);
            /**@var Object $fullpostcode**/
            $fullpostcode = $api->getPostcode($postcode);

            $dataArray = $form->getData();

            $record = formResultsQuery::create()
                ->filterByFirstname($dataArray['Voornaam'][FirstNameAndInitialType::FIELD_VOORNAAM])
                ->filterByLastname($dataArray['Achternaam'])
                ->filterByEmail($dataArray['Email'])
                ->filterByPhonenumber($dataArray['Phonenumber'])
                ->filterByPassword(password_hash($dataArray['Password'], PASSWORD_DEFAULT))
                ->filterByPostcode($fullpostcode->postcode)
                ->filterByCity($fullpostcode->city)
                ->filterByProvince($fullpostcode->province)
                ->findOneOrCreate();

            $record->save();
            echo "<script>alert('Form Saved!')</script>";
        }
    }
}