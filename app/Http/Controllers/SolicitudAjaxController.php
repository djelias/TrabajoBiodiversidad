<?php
         
namespace App\Http\Controllers;
          
use App\Solicitud;
use Illuminate\Http\Request;
use DataTables;
        
class SolicitudAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = solicitud::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editSolicitud">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteSolicitud">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('solicitudAjax',compact('solicituds'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Solicitud::updateOrCreate(['id' => $request->solicitud_id],
                ['nombre' => $request->nombre, 'docente' => $request->docente, 'costo' => $request->costo]);        
   
        return response()->json(['success'=>'Solicitud saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Taxonomia  $taxonomia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $solicitud = Solicitud::find($id);
        return response()->json($solicitud);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taxonomia  $taxonomia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Solicitud::find($id)->delete();
     
        return response()->json(['success'=>'Solicitud deleted successfully.']);
    }
}