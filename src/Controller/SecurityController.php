<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SecurityController extends AbstractController {
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(IriConverterInterface $iriConverter)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->json([
                'error' => 'Invalid login reuqest'
            ], 400);
        }

        return $this->json([
            'location_user' => $iriConverter->getIriFromItem($this->getUSer()),
            'location_individual' => $iriConverter->getIriFromItem($this->getUser()->getIndividual()),
        ]);
    }

    /**
     * @Route("/api/logout", name="api_logout")
     */
    public function logout()
    {
        throw new \Exception('shouldnot be reached');
    }
}