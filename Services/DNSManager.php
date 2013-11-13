<?php
namespace MWSimple\Bundle\LinodeDNSManagerBundle\Services;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Hampel\Linode\Service\LinodeConfig;
use Hampel\Linode\Service\LinodeService;
use Hampel\Linode\Command\Domain;
use Hampel\Linode\Command\DomainResource;
use Guzzle\Http\Client;

class DNSManager {

	private $container;
	private $logger;
	private $ip_server;
	private $linode;

    public function __construct($container)
    {
        $this->container = $container;
        $this->logger = $this->container->get('logger');
		$this->ip_server = $this->container->getParameter('ip_server');
		// long-hand initialisation method
        $config = new LinodeConfig();
        $config->set($this->container->getParameter('api_key_linode'));
        $client = new Client();
        $this->linode = new LinodeService($client, $config);
        $this->linode->init();
    }

    public function listDomains()
    {
        $domain = new Domain($this->linode);
        $domains = $domain->listDomain();

        return $domains;
    }

    public function createDomain($domain, $type, array $options = array())
    {
        $domain = new Domain($this->linode);
        $response = $domain->create($domain, $type, $options);

        return $response;
    }

    public function createA($domainid, $hostname, $ipaddress)
    {
        $domain = new DomainResource($this->linode);
        $response = $domain->createA($domainid, $hostname, $ipaddress);

        return $response;
    }
}