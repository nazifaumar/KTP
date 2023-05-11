<?php

namespace App\Http\Controllers;

use App\Models\Ktp;
use App\Helpers\formatAPI;
use Exception;
use Illuminate\Http\Request;

class KtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ktp::all();
        if($data){
            return formatAPI::createAPI(200,'sukses',$data);
        }else{
            return formatAPI::createAPI(400,'gagal');
        }
    }

    public function store(Request $request)
    {
        try{
            //untuk create data ke database
            $penduduk = Ktp::create($request->all());


            //get data siswa 
            $data = Ktp::where('nik','=',$penduduk->nik)->get();

            //check data isid_siswa valid?return data :failed 
            if($data){
                return formatAPI::createAPI(200,'Success',$data);
            }
            else{
                return formatAPI::createAPI(400,'Failed');
    
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400,'Failed');
        } 
    }

    public function show($nik)
    {
        try{
            $penduduk = Ktp::where('id', '=', $nik)->first();
            if($penduduk){
                return formatAPI::createAPI(200,'Success',$penduduk);
            }
            else{
                return formatAPI::createAPI(400,'Failed');
    
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400,'Failed', $error);
        }
    }

    public function update(Request $request, $nik)
    {
       try{
        $penduduk = Ktp::findorfail($nik);
        $penduduk->update($request->all());

        $data = Ktp::where('id', '=' ,$penduduk->nik)->get();
            if($data){
                return formatAPI::createAPI(200,'Success',$data);
            }
            else{
                return formatAPI::createAPI(400,'Failed');

            }
       }catch(Exception $error){
        return formatAPI::createAPI(400,'Failed',$error);
       }
    }

    public function destroy($nik)
    {
        try{
        $penduduk = Ktp::findorfail($nik);
        $data = $penduduk->delete();

            if($data){
                return formatAPI::createAPI(200,'Success',$data);
            }
            else{
                return formatAPI::createAPI(400,'Failed');

            }
       }catch(Exception $error){
        return formatAPI::createAPI(400,'Failed', $error);
       }
    }

   
}
