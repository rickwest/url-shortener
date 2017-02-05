<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UrlShortener;
use AppBundle\Form\UrlShortenerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller {

    public function getShortener() {
        return $this->get('app.shortener');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $urlShortener = new UrlShortener();
        $form = $this->createForm(UrlShortenerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->getData()->getUrl();

            $existingUrl = $this->getShortener()->isExistingUrl($url);

            if ($existingUrl){
                return $this->render('default/existingUrl.html.twig', [
                    'existingUrl' => $existingUrl
                ]);
            }

            $shortCode = $this->getShortener()->generateShortCode();

            $urlShortener
                ->setUrl($url)
                ->setShortcode($shortCode)
                ->setCreated(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($urlShortener);
            $em->flush();

            $shortUrl = $this->generateUrl('redirect', ['shortCode' => $shortCode], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->render('default/shortUrl.html.twig', [
                'shortUrl' => $shortUrl
            ]);
        }

        $vars = [
            'form' => $form->createView()
        ];

        return $this->render('default/index.html.twig', $vars);
    }

    /**
     * @Route("/{shortCode}", name="redirect")
     */
    public function redirectAction($shortCode) {
        return $this->redirect($this->getShortener()->getUrlFromShortCode($shortCode));
    }

}