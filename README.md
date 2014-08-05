SimplePageBundle
================

This bundle provides base classes to manage static page in your project and gives your users the mean to edit and change them with an admin interface.
It was developed because a lot people asked for this simple functions and I was tired to implement it again and again with little difference.

Installation
------------

Add `jbouzekri/simplepage-bundle` as a dependency in [composer.json](composer.json).

``` yml
"jbouzekri/simplepage-bundle": "1.*"
```

Enable the bundle in your AppKernel :

``` php
$bundles = array(
    ...
    new Jb\Bundle\SimplePageBundle\JbSimplePageBundle()
);
```

And import the route in app/config/routing.yml :

``` yml
simple_page_route_imported:
    resource: "@JbSimplePageBundle/Resources/config/routing.yml"
```

*Important* : If you use the doctrine provider, the base page entity use the [doctrine extension of gedmo](https://packagist.org/packages/gedmo/doctrine-extensions).
You must have the timestampable and sluggable extension enabled (to enable it easily, you can use the [wrapper created by stof](https://github.com/stof/StofDoctrineExtensionsBundle)).

The bundle provides 2 page providers. The first one use Doctrine and store the page in the database. With this one, you can have an administration interface. The
second one use the translator service to load page content but cannot be use with the admin interface.

With the default configuration, the doctrine provider is used with the default entity Jb\Bundle\SimplePageBundle\Entity\Page.

You can access the admin interface via the route /admin/page and the front page via the route /page/{slug}.

Doctrine provider reference
---------------------------

``` yml
jb_simple_page:
    entity: Jb\Bundle\SimplePageBundle\Entity\Page
    provider: doctrine
    form: jb_simple_page_default_form
    router:
        root_prefix: page
        admin_prefix: admin
    front:
        view_template: "JbSimplePageBundle:Front:view.html.twig"
        layout_template: "::base.html.twig"
    admin:
        index_template: "JbSimplePageBundle:Admin:index.html.twig"
        edit_template: "JbSimplePageBundle:Admin:edit.html.twig"
        layout_template: "::base.html.twig"
```

* jb_simple_page.entity : the entity loaded
* form : the name of the form (defined as a service) to used in admin interface
* router.root_prefix : the route prefix used in the front and between the admin prefix and the slug in the admin
* router.admin_prefix : the route prefix used in the admin interface (placed before the root prefix)
* front.view_template : template to render page in front
* front.layout_template : layout template to extend in front
* admin.index_template : list page template in admin interface
* admin.edit_template : edit/create page template in admin interface
* admin.layout_template : layout template to extend in admin interface

Translator provider reference
---------------------------

``` yml
jb_simple_page:
    provider: translator
    router:
        root_prefix: page
    front:
        view_template: "JbSimplePageBundle:Front:view.html.twig"
        layout_template: "::base.html.twig"
    translator:
        translation_domain: jb_simple_page
        pages:
            - slug-value
            ...
```

* router.root_prefix : the route prefix used in the front and between the admin prefix and the slug in the admin
* front.view_template : template to render page in front
* front.layout_template : layout template to extend in front
* translator.translation_domain : the translation domain to load page content
* translator.pages : list of the page availables.

In your translation file (translation_domain.locale.yml for example), for each page defined in translator.pages, you can defined :

``` yml
slug-value:
    title: The title
    content: The content (html tags are not stripped or escaped)
    meta_title: the meta title
    meta_description: the meta description
```

You can override the TranslatorPageBuilder service if you want to add some fields.

Override
--------

All services are defined with parameters for their class configuration. You can override them in your bundles.
Moreover, some semantic configuration parameters allow you to change the templates.
If it is not enough, you can use Symfony bundle inheritance to override some parts of the bundle

License
-------

[MIT](LICENSE)