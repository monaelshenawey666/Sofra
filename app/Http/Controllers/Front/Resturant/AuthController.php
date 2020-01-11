<?php

namespace App\Http\Controllers\Front\Resturant;

use App\Models\City;
use App\Models\Client;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function registerResturant()
    {
        return view('front.resturant.register');
    }

    public function registerSaveResturant(Request $request)
    {
        $validation = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:resturants,email',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'delivery_fee' => 'required|numeric',
            //'time_of_preparation'   => 'required',
            'minimum_charger' => 'required',
            'whatsNum' => 'required',
            'region_id' => 'required',
            // 'delivery_phone' =>'required',
            'image' => 'required',
            'categories' => 'required|array'
        ]);
        $request->merge(array('password' => bcrypt($request->password)));
        $resturant = Resturant::create($request->except('image'));
        $resturant->categories()->attach($request->categories);

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/front/resturants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $resturant->update(['image' => 'uploads/front/resturants/' . $name]);
        }
        // dd('done');
        flash()->success('تم إضافة المطعم بنجاح');
        //return view('front.login');
        return back();
    }

    public function resturantLogin()
    {
        return view('front.resturant.login');
    }

    public function resturantLoginSave(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $resturant = Resturant::where('email', $request->input('email'))->first();
        if ($resturant) {
            //dd($resturant);
            if (auth()->guard('restaurant-web')->attempt($request->only('email', 'password'))) {
                flash()->success('Hello' . auth()->guard('restaurant-web')->user()->name);
                //flash()->success('hello' . $resturant->name);
                return redirect('resturant/my-products');
                //return view('front.resturant.my-products');
            } else {
                flash()->error('error in login');
                return back();
            }
        }
        flash()->error('لا يوجد حساب مرتبط بهذا الرقم');
        return back();
    }

    public function resturantLogout()
    {
        // todo check auth
        auth()->guard('restaurant-web')->logout();
//        dd(auth()->guard('restaurant-web')->user());
        return redirect('/');

    }


}
