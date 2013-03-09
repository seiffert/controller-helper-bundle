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
