Usage in Lumen
===

A few minor additions have to be made to allow this to work with the Lumen framework.

While some might find it odd to use view methods odd in an API framework, there is the need if your app renders things
pretty error pages, confirmation pages or formatted emails.

bootstrap/app.php
---
Since Lumen does not use View normally, the alias must be created to allow DbView to function.

```php
...
$app->withFacades(true, [
    'Illuminate\Support\Facades\View'          => 'View',
    'Flynsarmy\DbBladeCompiler\Facades\DbView' => 'DbView'
]);

// Only include the confiuration if you have created a custom version in /config
$app->configure('db-blade-compiler');

$app->register(Flynsarmy\DbBladeCompiler\DbBladeCompilerServiceProvider::class);
...
```

config/db-blade-compiler.php
---
The configuration file is only needed if you need to change the default behavior of the compiler.

Out of the box the compiler uses `storage_path('app/db-blade-compiler/views')` for it's cache directory. Since this does
not exist and Lumen uses `storage_path('framework/views')` as it's view cache directory, I changed the setting in the
configuration file.
```php
...
	'storage_path' => storage_path('framework/views')
...
```
