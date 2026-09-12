<?php

namespace App\Http\Controllers;

use App\Actions\ImageActions;
use App\Models\ImageType;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{


    public function saveMultiFileJsonNew(Request $request)
    {
        $this->validate($request,['uploaded_files.*'=>'image']);

        $temp=session('tempMultiImage');
        if(! is_array($temp)){
            $temp=[];
        }
        $files=[];
        $urls=[];
        if($request->oldData){
            $data=json_decode($request->oldData);
            if(is_array($data)){
                $files=$data;
                foreach ($data as $d){
                    $urls[]=url('uploads/'.$d);
                }
            }
        }


        if(is_array($request->uploaded_files)){
            foreach ($request->uploaded_files as $key=>$file){
                if($name=self::SaveFileM($file)){
                    $files[]=$name;
                    $urls[]=['index'=>$request->indexing[$key],'file'=>$name];
                    session(['tempMultiImage'=>$temp]);
                }else{
                    return ['status'=>0,'errors'=>'ERROR'];
                }
            }

            return ['result'=>json_encode($files),'resultNames'=>$files,'files'=>$urls,'status'=>1];
        }

        return ['status'=>0,'errors'=>'ERROR'];

    }

    public static function SaveFileM($file){
        if (isset($file)){
            $name=time().'_'.rand(1,999999999).'.'.$file->getClientOriginalExtension();

            $path=realpath('public/uploads')?realpath('public/uploads'):realpath('uploads');

            $originalImage= $file;
            $img = Image::make($originalImage);
            $originalPath = $path.'/';
            $img->save($originalPath.$name);
            return $name;
        }
        return '';

    }
    public function saveFileJson(Request $request)
    {

        $this->validate($request,['uploaded_file'=>'image']);

        $temp=session('tempImage');
        if(! is_array($temp)){
            $temp=[];
        }
        if($name=ImageActions::SaveFile($request->uploaded_file)){
            $temp[]=$name;
            session(['tempImage'=>$temp]);
            return ['filelink'=>asset('uploads/'.$name),'file_name'=>$name,'status'=>1];
        }else{
            return ['status'=>0,'errors'=>'ERROR'];
        }

    }

    public function saveMultiFileJson(Request $request)
    {
        $this->validate($request,['uploaded_files.*'=>'image']);

        $temp=session('tempMultiImage');
        if(! is_array($temp)){
            $temp=[];
        }
        $files=[];
        $urls=[];
        if($request->oldData){
            $data=json_decode($request->oldData);
            if(is_array($data)){
                $files=$data;
                foreach ($data as $d){
                    $urls[]=url('uploads/'.$d);
                }
            }
        }


        if(is_array($request->uploaded_files)){
            foreach ($request->uploaded_files as $file){
                if($name=ImageActions::SaveFile($file)){
                    $files[]=$name;
                    $urls[]=asset('uploads/'.$name);
                    session(['tempMultiImage'=>$temp]);
                }else{
                    return ['status'=>0,'errors'=>'ERROR'];
                }
            }

            return ['result'=>json_encode($files),'resultNames'=>$files,'links'=>$urls,'my_server'=>url('/'),'status'=>1];
        }

        return ['status'=>0,'errors'=>'ERROR'];

    }







}
