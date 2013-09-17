
Bootnova is an eclipse.org theme that's using boostrap. The look and feel is based of the original "Nova" theme, created by Nathan Gervais.

Read the Bootstrap [Getting Started page](http://getbootstrap.com/getting-started/) for information on the framework contents, templates and examples, and more.


## Requirements

You will need to install [composer](http://www.getcomposer.org) to update the CSS of this theme (styles.less > bootstrap.min.css).

* composer

## General steps to get going

* Clone the repo: `git clone git://git.eclipse.org/gitroot/www.eclipse.org/eclipse.org-common.git`.
* Fetch dependencies with [composer](http://www.getcomposer.org): `composer install`.
* Set up your Eclipse environment. This includes git, PHP and apache.


## Bugs and feature requests

Have a bug or a feature request? [Please open a new issue](https://bugs.eclipse.org/bugs/buglist.cgi?product=Community&component=Website&resolution=---).

## How to use
On a page using the eclipse.org-common $App Class:

```php
$theme = 'bootnova';
$App->generatePage($theme, $Menu, $Nav, $pageAuthor, $pageKeywords, $pageTitle, $html);
```

## Links

* [Using Phoenix](http://wiki.eclipse.org/Using_Phoenix)
* [Phoenix Documentation](http://wiki.eclipse.org/Phoenix_Documentation)




