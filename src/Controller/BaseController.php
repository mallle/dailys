<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    /**
     * @return Null|User
     */
    protected function getUser(): ?User
    {
        return parent::getUser();
    }


}