<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FileController extends AbstractController{

    /**
     * @Route("/api/upload-file", name="file.upload", methods={"POST"})
     * @param Request $request
     */
    public function uploadFile(Request $request)
    {
        dump($request);
    }

}