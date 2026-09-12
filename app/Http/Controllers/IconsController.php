<?php

namespace App\Http\Controllers;
use BladeUI\Icons\IconsManifest;
use Illuminate\Http\Request;
use function Composer\Autoload\includeFile;

class IconsController extends Controller
{

    public function index()
    {

        $icons=$this->getRequire(app()->bootstrapPath('cache/blade-icons.php'));

        if(isset($icons['line-awesome-icons'])){
            $icons['lineawesome']=$icons['line-awesome-icons'];
            unset($icons['line-awesome-icons']);

        }
        if(isset($icons['fontawesome-solid'])){
            $icons['fas']=$icons['fontawesome-solid'];
            unset($icons['fontawesome-solid']);

        }
        if(isset($icons['fontawesome-brands'])){
            $icons['fab']=$icons['fontawesome-brands'];
            unset($icons['fontawesome-brands']);

        }
        if(isset($icons['fontawesome-regular'])){
            $icons['far']=$icons['fontawesome-regular'];
            unset($icons['fontawesome-regular']);

        }
//        dd($icons);
      return view('icons',compact('icons'));


    }
    public function getRequire($path, array $data = [])
    {
        if (is_file($path)) {
            $__path = $path;
            $__data = $data;

            return (static function () use ($__path, $__data) {
                extract($__data, EXTR_SKIP);

                return require $__path;
            })();
        }

        return [];
    }

}
