<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\RequestStack;

class ResponseService
{
    /**
     * @var RequestStack
     */
    private $request;

    /**
     * ResponseService constructor.
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    function send($response){
        $response->prepare($request);
        $response->send();
    }

    function sendAndDie($response){
        $response->prepare($this->request);
        $response->send();
        die;
    }
}