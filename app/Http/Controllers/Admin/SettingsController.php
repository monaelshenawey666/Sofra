<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Setting $model)
    {
        //
        if ($model->all()->count() > 0) {
            $model = Setting::find(1);
        }

        return view('admin.settings.view', compact('model'));
    }

//    public function view(Setting $model)
//    {
//        if ($model->all()->count() > 0) {
//            $model = Setting::find(1);
//        }
//
//        return view('admin.settings.view', compact('model'));
//    }

    public function update(Request $request)
    {

        $rules = [
            'facebook'  => 'required',
            'about_app' => 'required',
            'terms'     => 'required',
        ];
        $messages = [
            'facebook.required'  => 'حقل الفيس بوك  مطلوب',
            'about_app.required' => 'حقل عن التطبيق مطلوب',
            'terms.required'     => 'حقل الشروط والأحكام مطلوب',
        ];
        $this->validate($request, $rules, $messages);
        if (Setting::all()->count() > 0) {
            Setting::find(1)->update($request->all());
        } else {
            Setting::create($request->all());
        }

        flash()->success('تم الحفظ بنجاح');
        return back();
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
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
