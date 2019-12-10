<?php
namespace form\src\Views;

use form\src\Helpers\AbstractController;
use form\src\Helpers\PageResponse;

/**
 * Class ErrorFound
 *
 * @package tdewmain\src\Views
 */
class ErrorFound extends AbstractController
{

    /**
     * @return PageResponse
     */
    public function show(): PageResponse
    {
        return new PageResponse('errorFound.twig', []);
    }
}