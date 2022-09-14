## Proof of concept for integrating maizzle into laravel

Use blade logic and blade components to render html. Blade converts your templates to valid php files which we pass through to maizzle for additionall proccessing

For demonstration purposes you can clone this repo and run the following to see it in action 

```php artisan maizzle:compile```

This is using ```npm i @maizzle/framework@next``` as a dependency

> Note: To include components we need to use this syntax ```@module(components.content)``` instead of ```<x-content />``` or some other built in laravel component syntax in order copy the html instead of including it as include only happens at runtime and we need the markup to pass to maizzle
we need to 

maizzle config is in the root of the project
