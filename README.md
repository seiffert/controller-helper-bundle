SeiffertControllerHelperBundle
====================

This bundle provides simple helpers for Symfony2 controllers.

[![Build Status](https://travis-ci.org/seiffert/controller-helper-bundle.png?branch=master)](https://travis-ci.org/seiffert/controller-helper-bundle)

## Setup

Require the package via composer:

`composer.json`:

        "require": {
            ...
            "seiffert/controller-helper-bundle": "dev-master",
            ...
        }

Activate the bundle in your AppKernel:

**Note:** `SeiffertHelperBundle` has to be registered as well, since `SeiffertControllerHelperBundle` uses it as a dependency.

`app/AppKernel.php`:

        public function registerBundles()
        {
            $bundles = array(
                ...
                new Seiffert\HelperBundle\SeiffertHelperBundle(),
                new Seiffert\ControllerHelperBundle\SeiffertControllerHelperBundle(),
                ...
            );
            ...
        }

## Usage

The purpose of this bundle is to provide helper methods for controllers that have been specified as services. To avoid these controller having tons of dependencies, this bundle groups all those helpers a controller needs, and provides a single object which has all necessary helper methods. This helper object can be injected into your controllers like this:

**`services.yml`:**

    ...
    my.bundle.controller.default:
        class: %my.bundle.controller.default.class%
        arguments:
            - @seiffert.helper.controller

**`My\Bundle\Controller\DefaultController.php`:**

    <?php
    
    namespace My\Bundle\Controller;
    
    class DefaultController
    {
        private $h;
    
        public function __construct($helper)
        {
            $this->h = $helper;
        }
        
        public function indexAction()
        {
            return $this->h->render('MyBundle:Default:index.view.html');
        }
    }

## Available Helpers

Currently, there are only a couple of helpers provided by this bundle. You can expect the number of helpers to increase in the near future.

* DoctrineHelper: (these methods throw a `MissingDependencyException` if Doctrine is not active)
    * `getEntityManager()`
    * `persist($entity = null)`
    * `flush($entity = null)`
    * `getRepository($entityName)`
* FlashMessageHelper:
    * `addFlashMessage($type, $message)`
* FormHelper: (this method throws a `MissingDependencyException` if no form factory can be found)
    * `createForm(FormTypeInterface $type, $data = null, array $options = array())`
* RouterHelper:
    * `generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)`
* SecurityHelper: (this method throws a `MissingDependencyException` if no authenticated user can be found)
    * `getCurrentUser()
* TemplateHelper: (these methods throw a `MissingDependencyException` if no active templating engine can be found)
    * `render($template, $arguments = array(), Response $response = null)`
    * `renderView($template, $arguments = array())`
    * `stream($template, $arguments = array(), StreamedResponse $response = null)`
