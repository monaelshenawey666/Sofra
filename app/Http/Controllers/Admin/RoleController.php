<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\Models\Role;


/**
 * @property  model
 */
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Role $model
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.roles.create');
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $rules = [
            'name'             => 'required|unique:roles,name,',
            'display_name'     => 'required',
            'permissions_list' => 'required|array',
        ];
        $messages = [
            'name.required'         => 'الاسم مطلوب',
            'name.unique'           => 'الاسم مستخدم من قبل',
            'display_name.required' => 'الاسم المعروض مطلوب',
            'permissions_list'      => 'required|array',
        ];
        $this->validate($request, $rules, $messages);

        $record = Role::create($request->all());
        $record->permissions()->attach($request->permissions_list);
        flash()->success('تم إضافة الرتبة بنجاح');
        return redirect(route('role.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model = Role::findOrFail($id);
        return view('admin.roles.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name'            => 'required|unique:roles,name,'.$id,
            'display_name'    => 'required',
            'permissions_list' => 'required|array',
        ];
        $messages = [
            'name.required'         => 'الاسم مطلوب',
            'name.unique'           => 'الاسم مستخدم من قبل',
            'display_name.required' => 'الاسم المعروض مطلوب',
            'permissions_list' => 'required|array',
        ];
        $this->validate($request, $rules, $messages);

        $role = Role::findOrFail($id);
        $role->update($request->all());
        $role->permissions()->sync($request->permissions_list);

        flash()->success('تم تعديل الرتبة بنجاح');
        return redirect('admin/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $role = Role::findOrFail($id);

        $role->delete();
        $data = [
            'status' => 1,
            'msg'    => 'تم الحذف بنجاح',
            'id'     => $id
        ];
        return Response::json($data, 200);

    }
}
