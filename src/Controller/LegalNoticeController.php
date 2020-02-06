<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class LegalNoticeController extends BaseController
{
    /**
     * @Route("/legal/notice", name="legal_notice")
     */
    public function index()
    {
        return $this->render('legal_notice.html.twig');
    }
}
