Getting Started With IRNewsBundle
=================================

## Prerequisites

This version of the bundle requires Symfony 2.1+.

## Installation

1. Download IRNewsBundle using composer
2. Enable the bundle
3. Create your Article class
4. Configure the IRNewsBundle
5. Import IRNewsBundle routing
6. Update your database schema
7. Enable the doctrine extensions

### Step 1: Download IRNewsBundle using composer

Add IRNewsBundle in your composer.json:

``` js
{
    "require": {
        "informaticrevolution/news-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update informaticrevolution/news-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IR\Bundle\NewsBundle\IRNewsBundle(),
    );
}
```

### Step 3: Create your Article class

##### Annotations

``` php
<?php
// src/Acme/NewsBundle/Entity/Article.php

namespace Acme\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\NewsBundle\Model\Article as BaseArticle;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_news_article")
 */
class Article extends BaseArticle
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/NewsBundle/Entity/Article.php

namespace Acme\NewsBundle\Entity;

use IR\Bundle\NewsBundle\Model\Article as BaseArticle;

/**
 * Article.
 */
class Article extends BaseArticle
{
}
```

In YAML:

``` yaml
# src/Acme/NewsBundle/Resources/config/doctrine/Article.orm.yml
Acme\NewsBundle\Entity\Article:
    type:  entity
    table: acme_news_article
    id:
        id:
            type: integer
            generator:
                strategy: AUTO          
```

In XML:

``` xml
<!-- src/Acme/NewsBundle/Resources/config/doctrine/Article.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\NewsBundle\Entity\Article" table="acme_news_article">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

### Step 4: Configure the IRNewsBundle

Add the bundle minimum configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
ir_news:
    db_driver: orm # orm is the only available driver for the moment 
    article_class: Acme\NewsBundle\Entity\Article
```

### Step 5: Import IRNewsBundle routing files

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_news_article:
    resource: "@IRNewsBundle/Resources/config/routing/article.xml"
    prefix: /admin/articles
```

### Step 6: Update your database schema

Run the following command:

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 7: Enable the doctrine extensions

**a) Enable the stof doctrine extensions bundle in the kernel**

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
    );
}
```

**b) Enable the sluggable and timestampable extension in your `config.yml` file**

``` yaml
# app/config/config.yml
stof_doctrine_extensions:
    orm:
        default:
            sluggable: true
            timestampable: true