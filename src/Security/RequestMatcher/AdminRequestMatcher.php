<?php


namespace App\Security\RequestMatcher;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;

class AdminRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    /**
     * AdminRequestMatcher constructor.
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
                if(isset($pathInfo[1])){
                    if($pathInfo[1] == 'api' && isset($pathInfo[2]) && $pathInfo[2] == 'admin'){
                        return true;
                    }elseif ($pathInfo[1] == 'admin'){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}