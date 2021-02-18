<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\UrlType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File as File;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", methods={"GET", "POST"}, name="index")
     * @param Request $request
     * @return Response
     */

    public function run(
        Request $request
    ): Response
    {
        $form = $this->createForm(UrlType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $request->get('url')['url'];

            $loader = new \Twig\Loader\FilesystemLoader('/home/innate/Documents/symfony-phantomjs/news-website/templates/', 'templates/download.html.twig');
            $twig = new \Twig\Environment($loader);
            echo $twig->render('download.html.twig', ['url' => $url]);

            $html = exec("/home/innate/Documents/phantomJs/phantomjs/bin/phantomjs /home/innate/Documents/phantomJs/phantomjs/scrapper.js $url 2>&1");
            if ($html !== 'error') {
                $content = file_get_contents($html);
                exec("convert example-php.jpeg mypdf.pdf");
                echo $content;
            }
            die;
//            return $this->render('/home/innate/Documents/symfony-phantomjs/news-website/public/example-php.html');
            echo json_encode($html);

        }

        return $this->render('@Twig/base.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/downloadImage", methods={"GET", "POST"}, name="image")
     */
    public function downloadImage(): Response
    {
        $pngFile = new File('example-php.jpeg');

        return $this->file($pngFile);
    }

    /**
     * @Route("/downloadPdf", methods={"GET", "POST"}, name="pdf")
     */
    public function downloadPdf(): Response
    {
        $pdfFile = new File('mypdf.pdf');

        return $this->file($pdfFile);
    }
}