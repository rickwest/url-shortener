<?php

namespace AppBundle\Shortener;

use Doctrine\Bundle\DoctrineBundle\Registry;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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
        $urlShortener = $this->registry->getRepository('AppBundle:UrlShortener');
        return $urlShortener->findOneByUrl($url);
    }

    public function isGenuineUrl($url) {
        $client = new Client();
        try {
            $res = $client->request('GET', $url);
            return $res->getStatusCode() === 200;
        } catch (RequestException $e) {
            return false;
        }
    }
}