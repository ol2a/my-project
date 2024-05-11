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
        $data = $this->CrudInterface->index([]);

        return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);
    }



    public function store(CrafRequest $request)
    {
        try{
            DB::beginTransaction();

            $data = $this->CrudInterface->store($request->validated());

            DB::commit();

            return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);

        }catch(Exception $e){
            DB::rollBack();
            return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:$e->getMessage());
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


    public function update(CrafRequest $request, string $id)
    {
        try{
            $data = $this->CrudInterface->show($id , []);

            if(!$data){
                return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:'data not found');
            }

            DB::beginTransaction();

            $data->update($request->validated());

            DB::commit();

            return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);

        }catch(Exception $e){
            DB::rollBack();
            return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:$e->getMessage());
        }
    }

}
