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
    //Domain
    public function listDomains()
    {
        $domain = new Domain($this->linode);
        $domains = $domain->listDomain();

        return $domains;
    }

    public function findDomain($domain_name)
    {
        $domain = new Domain($this->linode);
        $domain_single = $domain->findDomain($domain_name);

        return $domain_single;
    }

    public function createDomain($domain_name, $type, array $options = array())
    {
        $domain = new Domain($this->linode);
        $response = $domain->create($domain_name, $type, $options);

        return $response;
    }

    public function updateDomain($domainid, array $options = array())
    {
        $domain = new Domain($this->linode);
        $response = $domain->update($domainid, $options);

        return $response;
    }

    public function deleteDomain($iddomain)
    {
        $response = null;
        $domain = new Domain($this->linode);
        $response = $domain->delete($iddomain);

        return $response;
    }

    public function deleteDomainByName($domain_name)
    {
        $response = null;
        $domain = new Domain($this->linode);
        $domain_single = $this->findDomain($domain_name);
        if (!empty($domain_single)) {
            $domainid = $domain_single->getDomainId();
            $response = $domain->delete($domainid);
        }

        return $response;
    }
    //DomainResource
    public function createA($domainid, $hostname, $ipaddress = null)
    {
        if ($ipaddress == null) {
            $ipaddress = $this->ip_server;
        }
        $domain = new DomainResource($this->linode);
        $response = $domain->createA($domainid, $hostname, $ipaddress);

        return $response;
    }

    public function updateDomainResource($domainid, $resourceid, array $options = array())
    {
        $domain = new DomainResource($this->linode);
        $response = $domain->update($domainid, $resourceid, $options);

        return $response;
    }

    public function deleteDomainResource($domainid, $resourceid)
    {
        $domain = new DomainResource($this->linode);
        $response = $domain->delete($domainid, $resourceid);

        return $response;
    }
}