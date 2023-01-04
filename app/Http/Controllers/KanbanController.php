<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\KanbanRequest;
use App\Models\KanbanMaterial;
use App\Services\KanbanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KanbanController extends Controller
{

    public function __construct(
        private KanbanService $kanbanService
    ){}

  
    public function index(Request $request){

        if($request->ajax()) {
            return $this->kanbanService->get($request->all());
        }

        return view('pages/kanban/index');
    }

    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Kanban has been found',
                'data'      => $this->kanbanService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(KanbanRequest $request){
        try {

            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;
            if(Auth::user()->department_id != null){
                $input['department_id'] = Auth::user()->department_id;
            }


            //Add Data
            $create_kanban = $this->kanbanService->create($input);

            //Add Materials
            if($request->material_ids && $request->material_ids !=null && count($request->material_ids) > 0){
                foreach ($request->material_ids as $key => $value) {
                    $create_kanban_materials = new KanbanMaterial();
                    $create_kanban_materials->kanban_id = $create_kanban->id;
                    $create_kanban_materials->material_id = $value;
                    $create_kanban_materials->save();
                }
            }

            return $this->sendSuccess([
                'message'   => 'Kanban has been created',
                'data'      => $create_kanban
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(Request $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;
           
            return $this->sendSuccess([
                'message'   => 'Kanban has been updated',
                'data'      => $this->kanbanService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Kanban '.$request->name.' has been deleted',
                'data'      => $this->kanbanService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function changeStatus(Request $request){

        try {
            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;
           
            return $this->sendSuccess([
                'message'   => 'Status has been updated',
                'data'      => $this->kanbanService->update($input, $request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }


}
