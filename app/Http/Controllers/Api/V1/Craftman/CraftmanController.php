<?php

namespace App\Http\Controllers\Api\V1\Craftman;

use App\Contracts\CrudInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Craftman\CraftmanRequest;
use App\Models\Craftman;
use App\Traits\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;

class CraftmanController extends Controller
{
    use Response;

    public $model = Craftman::class;

    public function __construct(private CrudInterface $CrudInterface){
        $this->CrudInterface->boot(model:$this->model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = DB::table("craftmen")->get();
        return $all ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = $request->validate([
            "name" =>"required" ,
            "email" =>"required|email",
            "address"=>"required" ,
            "national_id" =>"required" ,
            "phone_number" =>"required"
        ]);
        if($new){
            $newMan = DB::table("craftmen")->insert([
                "name" =>$request->name ,
                "email"=>$request->email ,
                "address" => $request->address ,
                "national_id" =>$request->national_id ,
                "phone_numper" => $request->phone_number
        ]) ;
                return $res = [
                    "message" => "new craft man added" ,
                    "status" => 200 ,
                    "data" => $newMan
                ];
        }else{
            return $message = "Error" ;
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


            $data = $this->CrudInterface->show($id , []);

            if(!$data){
                return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:'data not found');
            }

            return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = $request->validate([
            "name" =>"required" ,
            "email" =>"required|email",
            "address"=>"required" ,
            "national_id" =>"required" ,
            "phone_number" =>"required"
        ]);
        $updatecraftman = DB::table("craftmen")->where("id" , "=" , $id)->update([
                "name" =>$request->name ,
                "email"=>$request->email ,
                "address" => $request->address ,
                "national_id" =>$request->national_id ,
                "phone_numper" => $request->phone_number
        ]) ;

        if($updatecraftman){
            return $message = "craft man data  updated";
        }
        else{
            return $message = "failed to update" ;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $getCraftman = DB::table("craftmen")->where("id" , "=" ,$id)->delete();
       if($getCraftman){
        return $message = "Deleted !" ;
       }else{
        return $message = "Error !" ;
       }
    }
}
