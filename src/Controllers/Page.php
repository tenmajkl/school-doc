<?php

namespace App\Controllers;

use Lemon\Kernel\Application;

class Page
{
    public function first(Application $app)
    {
        $categories = require $app->file('storage.categories', 'php');

        return redirect('/'.$categories[0]['items'][0][1]);
    }

    public function handle(Application $app, $page) 
    {
        $file = preg_replace('/^([a-z]+)-/', '$1.', $page);
        return template('page', 
            categories: require $app->file('storage.categories', 'php'),
            content: file_get_contents($app->file('storage.materials.5.'.$file, 'md')),
        );
    }
}
