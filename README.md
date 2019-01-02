## Installation

### config.yml
```yaml
framework:
    serializer: { enabled: true }
    property_info: { enabled: true }
```

### Composer
You will need to add this to your composer.json:
```json
    "repositories": [
        {
            "type": "git",
            "url": "git@github.com:wkda/service-api-request.git"
        },
        {
            "type": "git",
            "url": "git@github.com:wkda/service-api-components-bundle.git"
        }
    ]
```

## Example EP Provider symfony.service declaration:
### tag
```yaml
{ name: 'auto1.api.endpoint_provider', priority: 0 }
```
### services.yml
```yaml
services:
    your_app.api.endpoint.provider:
        class: Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointProviderConfiguration
        arguments:
            - '@auto1.api.endpoint.factory'
            - '@your_app.api.endpoint_configuration.loader'
        tags:
            - { name: 'auto1.api.endpoint_provider', priority: 0 }

    your_app.api.endpoint_configuration.loader:
        class: Auto1\ServiceAPIComponentsBundle\Service\Endpoint\EndpointsConfigurationLoader
        arguments:
            - '%kernel.project_dir%/src/Resources/endpoints.yml'
```
### Super Quick Start:
Only for proof of concept etc.
```php
class YourProvider implements EndpointProviderInterface
{
    public function getEndpoints(): array
    {
        return [
            new EndpointImmutable(
                ...,
            ),
        ];
    }
}
```
```yaml
services:
    your_app.api.endpoint.provider:
        class: YourProvider
        tags:
            - { name: 'auto1.api.endpoint_provider', priority: 0 }
```

## Example of EP definition (yaml): 
```yaml
# Auth
- method:        'POST'
  baseUrl:       '%wkda.java_api.url%'
  path:          '/v1/auth/oauth/token'
  requestFormat: 'url'
  requestClass:  'Auto1\ServiceDTOCollection\Authentication\OAuth\Request\PostRefreshTokenRequest'
  responseClass: 'Auto1\ServiceDTOCollection\Authentication\OAuth\Response\Token'

- method:        'GET'
  baseUrl:       '%wkda.java_api.admin_url%'
  path:          '/v1/auth/user/admin/{userUuid}/roles'
  requestFormat: 'url'
  requestClass:  'Auto1\ServiceDTOCollection\Authentication\User\Request\GetUserRolesRequest'
  responseClass: 'Auto1\ServiceDTOCollection\Authentication\User\Response\UserRoles'

# CarLead
- method:        'GET'
  baseUrl:       '%wkda.java_api.url%'
  path:          '/v1/carlead/vin/{vin}'
  requestClass:  'Auto1\ServiceDTOCollection\CarLead\CarLeadRead\Request\GetCarDetailsByVinRequest'
  responseClass: 'Auto1\ServiceDTOCollection\CarLead\CarLeadRead\Response\CarLead[]'
```
### Alternative:
```yaml
# Auth
refreshToken:
    method:        'POST'
    baseUrl:       '%wkda.java_api.url%'
    path:          '/v1/auth/oauth/token'
    requestFormat: 'url'
    requestClass:  'Auto1\ServiceDTOCollection\Authentication\OAuth\Request\PostRefreshTokenRequest'
    responseClass: 'Auto1\ServiceDTOCollection\Authentication\OAuth\Response\Token'

getUserRoles:
    method:        'GET'
    baseUrl:       '%wkda.java_api.admin_url%'
    path:          '/v1/auth/user/admin/{userUuid}/roles'
    requestFormat: 'url'
    requestClass:  'Auto1\ServiceDTOCollection\Authentication\User\Request\GetUserRolesRequest'
    responseClass: 'Auto1\ServiceDTOCollection\Authentication\User\Response\UserRoles'

# CarLead
getCarLeadByVin:
    method:        'GET'
    baseUrl:       '%wkda.java_api.url%'
    path:          '/v1/carlead/vin/{vin}'
    requestClass:  'Auto1\ServiceDTOCollection\CarLead\CarLeadRead\Request\GetCarDetailsByVinRequest'
    responseClass: 'Auto1\ServiceDTOCollection\CarLead\CarLeadRead\Response\CarLead[]'
```

## Example of ServiceRequest implementation:
```php
class GetCarDetailsByVinRequest implements ServiceRequestInterface
{
    private $vin;

    public function setVin(string $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getVin()
    {
        return $this->vin;
    }
}

```

## Url resolution
For altering the default behaviour of Url resolution see `UrlResolverCompilerPass` and use `auto1.api.url_resolver` tag together with `priority`: 
```yaml
    # this is a default resolver
    auto1.api.url_resolver.parameter_aware:
        class: Auto1\ServiceAPIComponentsBundle\Service\UrlResolver\ParameterAwareUrlResolver
        arguments:
            - '@service_container'
        tags:
            - { name: 'auto1.api.url_resolver', priority: 0 }
```

## Debug:
To output all registered endpoints:
```bash
bin/console auto1.debug.endpoints
```

For more info - have a look at [admin-handover-protocol](https://github.com/wkda/admin-handover-protocol) usage:
- AbstractRepository;
- SearchFilters;
- PatchRequestFactory;
- Unicorns;
