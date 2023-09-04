<?php

namespace App\Controllers;

use Lemon\Kernel\Application;
use Lemon\Support\CaseConverter;
use Lemon\Support\Filesystem;

class Update
{
    public function handle(Application $app)
    {
        $file = $app->file('storage.materials'); 

        if (is_dir($file)) {
            Filesystem::delete($file);
        }

        exec('git clone '.env('GITHUB_URL').' '.$file);

        $categories = [];

        $materials = $file.DIRECTORY_SEPARATOR.'5';
        foreach (scandir($materials) as $dir) {
            $category = ['title' => $dir, 'items' => []];
            $directory = $materials.DIRECTORY_SEPARATOR.$dir;
            if ($dir === '..' || $dir === '.' || !is_dir($directory)) {
                continue;
            }
            foreach (scandir($directory) as $file) { 
                if ($file === '..' || $file === '.') {
                    continue;
                }
                $slug = '';
                if (!preg_match('/^(\d\d)-([^\.]+)\.md$/', $file, $slug)) {
                    continue;
                }
                $name = implode(' ', CaseConverter::toArray($slug[2]));
                $category['items'][] = [$name, $dir.'-'.$slug[1].'-'.$slug[2]]; 
            }
            $categories[] = $category;
        }

        file_put_contents($app->file('storage.categories', 'php'), 
            '<?php return '.var_export($categories, true).';'
        ); 
    }
}
