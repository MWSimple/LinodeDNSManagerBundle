# LinodeDNSManagerBundle

This bundle Linode DNS Manager

## Installation

### Using composer

Add following lines to your `composer.json` file:

### Symfony 2.3.*

```json
"require": {
	...
	"mwsimple/linode-dns-manager": "9999999-dev"
}
```

Execute:

```cli
php composer.phar update "mwsimple/linode-dns-manager"
```

Add it to the `AppKernel.php` class:

```php
	// ...
	new MWSimple\Bundle\CrudGeneratorBundle\MWSimpleLinodeDNSManagerBundle(),
```

### Configure routing

You can configure `routing.yml`

```yaml
    mw_simple_linode_dns_manager:
	    resource: "@MWSimpleLinodeDNSManagerBundle/Controller/"
	    type:     annotation
	    prefix:   /dnsmanager/
```

### Configure parameters

You can configure `parameters.yml`

```yaml
    api_key_linode: apikeylinode
    ip_server:      ipserverlinode
```

## Author

Gonzalo Alonso - gonkpo@gmail.com
