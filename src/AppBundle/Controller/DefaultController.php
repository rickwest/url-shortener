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
        $form = $this->createForm(UrlShortenerType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var UrlShortener $urlShortener */
            $urlShortener = $form->getData();

            $existingUrl = $this->getShortener()->isExistingUrl($urlShortener->getUrl());

            if ($existingUrl) {
                return $this->json([
                    'title' => 'youRL already exists!',
                    'subtitle' => 'Copy the existing short youRL and get to work!',
                    'url' => $this->generateUrl('redirect', ['shortCode' => $existingUrl->getShortCode()], UrlGeneratorInterface::ABSOLUTE_URL)
                ]);
            }

            $shortCode = $this->getShortener()->generateShortCode();

            $urlShortener
                ->setShortcode($shortCode)
                ->setCreated(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($urlShortener);
            $em->flush();

            $shortUrl = $this->generateUrl('redirect', ['shortCode' => $shortCode], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->json([
                'title' => 'Short youRL created successfully!',
                'subtitle' => 'Boom!',
                'url' => $shortUrl
            ]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{shortCode}", name="redirect")
     */
    public function redirectAction($shortCode) {
        return $this->redirect($this->getShortener()->getUrlFromShortCode($shortCode));
    }
}