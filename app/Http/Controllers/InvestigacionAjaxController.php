<?php
         
namespace App\Http\Controllers;
          
use App\Investigacion;
use Illuminate\Http\Request;
use DataTables;
        
class InvestigacionAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = investigacion::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editInvestigacion">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteInvestigacion">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('investigacionAjax',compact('investigacions'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Investigacion::updateOrCreate(['id' => $request->investigacion_id],
                ['nombre' => $request->nombre, 'fecha' => $request->fecha, 'descripcion' => $request->descripcion]);        
   
        return response()->json(['success'=>'Investigacion saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inestigacion  $investigacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $investigacion = Investigacion::find($id);
        return response()->json($investigacion);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inestigacion  $investigacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Investigacion::find($id)->delete();
     
        return response()->json(['success'=>'Investigacion deleted successfully.']);
    }
}