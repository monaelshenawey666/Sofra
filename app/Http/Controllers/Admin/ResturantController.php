<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResturantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $resturants = Resturant::where(function ($q) use ($request) {
            if ($request->name) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('name', 'LIKE', '%' . $request->name . '%');
                });
            }
            if ($request->city_id) {
                $q->whereHas('region',function ($q2) use($request){
                    // search in restaurant region "Region" Model
                    $q2->whereCityId($request->city_id);
                });
            }

        })->paginate(20);
        //dd($resturants);
           // ->with('region.city')->latest()->paginate(20);
        return view('admin.resturants.index', compact('resturants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $resturant = Resturant::find($id);
        if (!$resturant) {
            $data = [
                'status' => 0,
                'msg' => 'no resturant ',
            ];
            return response()->json($data, 200);
        }
        if (count($resturant->orders) > 0) {
            $data = [
                'status' => 0,
                'msg' => 'لا يمكن حذف المطعم ، لان به طلبات مسجلة',
                'id' => $resturant->id
            ];
            return response()->json($data, 200);
        }

        $resturant->categories()->detach();
        $resturant->products()->delete();
        $resturant->offers()->delete();


        $resturant->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $resturant->id
        ];
        return response()->json($data, 200);
    }




    public function activate($id)
    {
        $resturant = Resturant::findOrFail($id);
        $resturant->activated = 1;
        $resturant->save();
        flash()->success('تم التفعيل');
       return back();
       // return redirect(route('resturants.index'));

    }

    public function deActivate($id)
    {
        $resturant = Resturant::findOrFail($id);
        $resturant->activated = 0;
        $resturant->save();
        flash()->success('تم الإيقاف');
        return back();
    }

}
