<?php

namespace AppBundle\Shortener;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Shortener {

    /** @var  Registry */
    private $registry;

    public function __construct(Registry $registry) {
        $this->registry = $registry;
    }

    public function generateShortCode() {
        return base64_encode(random_int(999,999999));

    }

    public function getUrlFromShortCode($shortCode) {
        $rep = $this->registry->getRepository('AppBundle:UrlShortener');
        $url = $rep->findOneByShortCode($shortCode);

        if(!$url){
            throw new NotFoundHttpException();
        }

        return $url->getUrl();
    }

    public function isExistingUrl($url) {
        $rep = $this->registry->getRepository('AppBundle:UrlShortener');
        $existingUrl = $rep->findOneByUrl($url);

        if ($existingUrl) {
            return true;
        } else {
            return false;
        }
    }
}