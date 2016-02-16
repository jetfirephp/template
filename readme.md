## JetFire Template

A template engine selector. For the moment only Twig and Php template engine are supported.

### Installation

Via [composer](https://getcomposer.org)

```bash
composer require jetfirephp/template
```

### Usage

To use the autoloader, first instantiate it, then register it with SPL autoloader stack:

```php
require_once __DIR__ . '/vendor/autoload.php';

// create your view object
$view = new \JetFire\Template\View();

// set your template options
$view->setPath(__DIR__.'/Views/');
$view->setData([
    'name' => 'JetFire'
]);
$view->setExtension('.html.twig');

// load a template
$view->setTemplate('index'); // search for index.html.twig

// or load a content
$view->setContent('<html><body>Hello Wolrd !</body></html>');

// And select a template engine to render your view
// For twig templating
$template = new \JetFire\Template\Twig\TwigTemplate($view);
// For php templating
$template = new \JetFire\Template\Php\PhpTemplate($view);

echo $template->render();

```

### License

The JetFire Routing is released under the MIT public license : http://www.opensource.org/licenses/MIT. 