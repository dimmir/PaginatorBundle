# PaginatorBundle

Flexible pagination bundle for Symfony 3.
This bundle provides an easy way to add pagination support to the collection of your API.
It easy used with FOSRestBundle

## Installation:

You can install this bundle using composer:

```sh
composer require dimmir/paginator-bundle
```

Add the bundle to your AppKernel.php file:

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new DMR\Bundle\PaginatorBundle\PaginatorBundle(),
        // ...
    );
}
```

## Configuration

```yaml
dmr_paginator:
    items_per_page: 25                                  # default number items per page
    max_items_per_page: ~                               # The maximum number of items per page.
    page_request_parameter_name: page                   # The name of current page for query parameter
    client_items_per_page: false                        # To allow the client to set the number of items per page.
    items_per_page_request_parameter_name: itemsPerPage # The name of items per page query parameter
    options:                                            # options fo Paginator
        fetch_join_collection: true                     # The option fetchJoinCollection for Doctrine ORM Paginator
```

## Usage

Currently paginator can paginate:

- `Doctrine\ORM\QueryBuilder`

Example for used with FOSRestBundle:


```php
// AppBundle\Controller\UserController.php

    /**
     * @View()
     */
    public function cgetAction (Request $request)
    {
        $queryBuilder = $this->getDoctrine()->getManager()
                    ->getRepository('AppBundle:User')->createQueryBuilder('u');

        $paginator = $this->get('dmr_paginator.service')->pagination($queryBuilder);

        return new SliderRepresentation($paginator);
    }
```

### Representations

DMR\Bundle\PaginatorBundle\Representation\CollectionRepresentation:

```json
{
  "items": [
    {
      "id": 1,
      ...
    },
    ...
  ],
  "pagination": {
    "page": 1,
    "itemsPerPage": 25,
    "totalItemsCount": 40,
    "pagesCount": 2
  }
}
```

DMR\Bundle\PaginatorBundle\Representation\SliderRepresentation:

```json
{
  "items": [
    {
      "id": 1,
      ...
    },
    ...
  ],
  "previus": 1,
  "next": 3
}
```
