<?php

namespace MWSimple\Bundle\LinodeDNSManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DNSManagerController extends Controller
{
    private $mws_dns_manager;

    public function init(){
        $this->mws_dns_manager = $this->get('mws_dns_manager');
    }

    /**
    * @Route("/", name="mws-linode-dns-manager")
    * @Template()
    */
    public function indexAction()
    {
        return array('index' => 'Welcome');
    }

    /**
    * @Route("/list", name="mws-ldm-list")
    * @Template()
    */
    public function listAction()
    {
        $this->init();
        $domains = $this->mws_dns_manager->listDomains();

        return array('domains' => $domains);
    }
}
