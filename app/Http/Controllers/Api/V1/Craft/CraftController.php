<?php

namespace App\Http\Controllers\Api\V1\Craft;

use App\Contracts\CrudInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Craft\CrafRequest;
use App\Traits\Response;
use App\Models\Craft;
use Exception;
use App\Http\Requests\Api\V1\Craft\CraftRequest;
use App\Services\Crud;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CraftController extends Controller
{
    use Response;

    public $model = Craft::class;

    public function __construct(private CrudInterface $CrudInterface){
        $this->CrudInterface->boot(model:$this->model);
    }
    public function index()
    {
        $crafts =DB::table('craft')->get();
        if($crafts->count() !== 0){
            return $response = [
                "message" => "all crafts here " ,
                "status" => 200 ,
                "data" => $crafts
            ];
        }else{
            return $message = "No Crafts here !" ;
        }
    }



    public function store(Request $request)
    {
        $newCraft = $request->validate([
            'name' => 'required|string'
        ]);
        if($newCraft){
            DB::table("craft")->insert([
                "name" => $request->name
            ]) ;

            return $response = [
                "message" => "Craft added" ,
                "status" => 200 ,
                "data" => $newCraft
            ] ;
        }else{
            return $message = "try again" ;
        }
    }


    public function show(string $id)
    {
        $data = $this->CrudInterface->show($id , []);

        if(!$data){
            return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:'data not found');
        }

        return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);

    }


    public function update(Request $request, string $id)
    {
        $craft = DB::table("craft")->where("id" , "=" , $id)->update([
            "name" =>$request->name
        ]);

        if($craft){
            return $response = [
                'message' =>"craft updated" ,
                'data' => $craft
            ];
        }else{
            return $res = "error";
        }
    }
    public function destroy(string $id)
    {
        $find = DB::table("craft")->where("id" , "=" , $id)->delete();
        return $message = "Craft Deleted !";
}
}
