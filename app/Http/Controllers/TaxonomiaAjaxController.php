<?php
         
namespace App\Http\Controllers;
          
use App\Taxonomia;
use Illuminate\Http\Request;
use DataTables;
        
class TaxonomiaAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = taxonomia::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editTaxonomia">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTaxonomia">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('taxonomiaAjax',compact('taxonomias'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Taxonomia::updateOrCreate(['id' => $request->taxonomia_id],
                ['name' => $request->name, 'filum' => $request->filum, 'familia' => $request->familia]);        
   
        return response()->json(['success'=>'Taxonomia saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Taxonomia  $taxonomia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $taxonomia = Taxonomia::find($id);
        return response()->json($taxonomia);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taxonomia  $taxonomia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Taxonomia::find($id)->delete();
     
        return response()->json(['success'=>'Taxonomia deleted successfully.']);
    }
}