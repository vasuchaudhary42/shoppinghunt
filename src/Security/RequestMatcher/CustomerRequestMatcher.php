<?php


namespace App\Security\RequestMatcher;


use App\Services\RequestMatcherService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

class CustomerRequestMatcher
{
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;


    /**
     * CustomerRequestMatcher constructor.
     * @param ParameterBagInterface $parameterBag
     */
    function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }


    /**
     * @return bool true if the request matches, false otherwise
     */
    public function matches(Request $request)
    {
        $app_locales = $this->parameterBag->get('app_locales');
        $pathInfo =  explode('/',$request->getPathInfo());
        if(count($pathInfo) > 1){
            array_shift($pathInfo);
            if(isset($pathInfo[0]) && in_array($pathInfo[0], $app_locales)){
                return true;
            }
        }
        return false;
    }
}