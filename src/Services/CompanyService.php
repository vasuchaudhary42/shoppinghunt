<?php
namespace App\Services;
use App\Entity\Company;
use App\Exception\AjaxException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

    class CompanyService
    {
        private $company = null;
        /**
         * @var RequestStack
         */
        private $request;
        /**
         * @var EntityManagerInterface
         */
        private $e;
        /**
         * @var ParameterBagInterface
         */
        private $parameterBag;

        function __construct(EntityManagerInterface $e,RequestStack $request, ParameterBagInterface $parameterBag)
        {
            $this->request = $request->getMasterRequest();
            $this->e = $e;
            $this->parameterBag = $parameterBag;
        }

        function getCompany(){
            if(isset($this->company) && $this->company){
                return $this->company;
            }

            $httpHost = $this->request->getHttpHost();
            $arr = explode('.',$httpHost);

            if(count($arr) == 4){
                $subDomain = $arr[1];
                $domain    = $this->parameterBag->get('domain');
                if("www.$subDomain.$domain.com" === $httpHost){
                    $this->company = $this->e->getRepository(Company::class)->findOneBy(['domain' => strtolower($subDomain)]);
                    if(isset($this->company) && $this->company){
                        return $this->company;
                    }
                }
            }

            AjaxException::init(AjaxException::DOMAIN_NOT_FOUND, Response::HTTP_BAD_REQUEST)->sendExceptionResponseAndExit();
            return null;
        }
    }