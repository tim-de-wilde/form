<?php

namespace form\src\Views;

use form\src\Helpers\AbstractController;
use form\src\Helpers\PageResponse;

/**
 * Class PageNotFound
 *
 * @package tdewmain\src\Views
 */
class PageNotFound extends AbstractController
{
    /**
     * @return PageResponse
     */
    public function show(): PageResponse
    {
        return new PageResponse('notFound.twig', []);
    }
}
