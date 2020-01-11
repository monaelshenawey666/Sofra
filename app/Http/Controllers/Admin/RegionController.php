<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use App\Models\City;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $regions = Region::paginate(20);
        return view('admin.regions.index',compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Region $model)
    {
        //
        return view('admin.regions.create',compact('model'));

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
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required'
        ]);

        Region::create($request->all());

        flash()->success('تم إضافة المنطقة بنجاح');
        return redirect('admin/region');
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
        $model = Region::findOrFail($id);

        return view('admin.regions.edit',compact('model'));
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
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required'
        ]);

        Region::findOrFail($id)->update($request->all());

        flash()->success('تم تعديل بيانات المنطقة بنجاح.');
        return redirect('admin/region');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region = Region::find($id);
       if(count($region->resturants)>0)
        {
            $data = [
                'status' => 0,
                'msg' => 'لا يمكن مسح المنطقة ، يوجد مطاعم مسجلة بها'
            ];
            return response()->json($data, 200);
        }
        $region->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return Response::json($data, 200);


    }
}
