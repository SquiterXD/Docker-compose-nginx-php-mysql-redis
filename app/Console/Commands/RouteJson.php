<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Route;

class RouteJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'My route json command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routes = $this->generateRoutes();
        $this->writeJson($routes, './resources/js/routes.json');

        $routes = $this->generateVariableRouter();
        $this->writeJs($routes, './resources/js/router.js');

        return;
    }

    public function generateRoutes()
    {
        $routes = [];
        $table = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            try {
                if (is_null($route->getName())) {
                    continue;
                }
                if (isset($routes[$route->getName()])) {
                    $this->comment("Overwriting duplicate named route: " . $route->getName());
                }

                $controller = get_class($route->getController());
                $action = $route->getActionMethod();
                $key = "$controller.$action";
                if (!isset($table[$key])) {
                    $table[$key] = "/" . $route->uri();
                }

                $routes[$route->getName()] = $table[$key];
                $methods = implode('|', $route->methods());
                $this->comment("- set {$route->getName()} \t\t: {$methods} /{$route->uri()}");
            } catch (\Exception $e) {
                continue;
            }
        }
        return $routes;
    }

    public function generateVariableRouter()
    {
        $routes = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            try {
                if (is_null($route->getName())) {
                    continue;
                }
                $name = $route->getName();
                $uri = "/" . $route->uri();
                $methods = implode('|', $route->methods());

                $controller = get_class($route->getController());
                $action = $route->getActionMethod();

                //$key = "$methods:$uri";
                $key = "$controller.$action";

                if (!isset($routes[$key])) {
                    $routes[$key] = [];
                }
                $routes[$key][$name] = $uri;
            } catch (\Exception $e) {
                continue;
            }
        }
        foreach ($routes as $key => $routeSet) {
            $firstUri = null;
            foreach ($routeSet as $name => $uri) {
                if (is_null($firstUri)) {
                    $firstUri = $uri;
                }
                $routes[$key][$name] = $firstUri;
            }
        }
        //print_r($routes);
        return $routes;
    }

    protected function writeJson($routes, $filename)
    {
        if (!$handle = fopen($filename, 'w')) {
            $this->error("Cannot open file: $filename");
            return;
        }

        // Write $somecontent to our opened file.
        if (fwrite($handle, json_encode($routes)) === FALSE) {
            $this->error("Cannot write to file: $filename");
            return;
        }

        $this->info("Wrote routes to: $filename");

        fclose($handle);

    }

    protected function writeJs($routes, $filename)
    {
        $header = file_get_contents(resource_path('js/template/router.js'));
        if (!$handle = fopen($filename, 'w')) {
            $this->error("Cannot open file: $filename");
            return;
        }

        $vars = [];
        foreach ($routes as $key => $routeSet) {
            foreach ($routeSet as $name => $uri) {
                $nameCamel = str_replace("/", ".", $name);
                $nameCamel = $this->toCamel($nameCamel);
                //print_r("$nameCamel => $uri \n");
                //$this->set_nested_array_value($json, $nameCamel, $uri);
                $vars[implode("_", explode('.', $nameCamel))] = [$name, $uri, $key];
            }
        }

        $output = "$header\n\n//=== generate ===\n\n";
        foreach ($vars as $varName => $data) {
            [$name, $uri, $key] = $data;
            $output .= "export const $varName = '$name'; //uri: $uri -> $key()\n";
        }

        if (fwrite($handle, $output) === FALSE) {
            $this->error("Cannot write to file: $filename");
            return;
        }

        $this->info("Wrote routes to: $filename");

        fclose($handle);

    }

    private function toCamel($string)
    {
        return $this->kebabToCamel($this->snakeToCamel($string));
    }

    private function snakeToCamel($string)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }

    private function kebabToCamel($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }

}
