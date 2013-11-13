<?php

namespace MWSimple\Bundle\LinodeDNSManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Hampel\Linode\Service\LinodeConfig;
use Hampel\Linode\Service\LinodeService;
use Hampel\Linode\Command\Domain;
use Guzzle\Http\Client;

class DNSManagerController extends Controller
{
	private $ip_server;
	private $linode;

    public function init(){
        $this->ip_server = $this->container->getParameter('ip_server');
        // long-hand initialisation method
        $config = new LinodeConfig();
        $config->set($this->container->getParameter('api_key_linode'));
        $client = new Client();
        $this->linode = new LinodeService($client, $config);
        $this->linode->init();
    }
    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
        $this->init();
        $domain = new Domain($this->linode);
        $domains = $domain->listDomain();
        var_dump($domains);
        return array('domains' => $domains);
    }
}
