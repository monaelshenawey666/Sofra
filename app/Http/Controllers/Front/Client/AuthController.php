<?php

namespace App\Http\Controllers\Front\Client;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function registerClient()
    {
        return view('front.client.register');
    }

    public function registerSaveClient(Request $request)
    {
        $validation = $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'region_id' => 'required',
            'email' => 'required|unique:clients,email',
            'password' => 'required|confirmed',
            'profile_image' => 'required',
        ]);
        $request->merge(array('password' => bcrypt($request->password)));
        $client = Client::create($request->except('profile_image'));
       // $client = Client::create($request->all());
        if ($request->hasFile('profile_image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/front/client/'; // upload path
            $logo = $request->file('profile_image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $client->update(['profile_image' => 'uploads/front/client/' . $name]);
        }
        // dd('done');
        flash()->success('تم إضافة العميل بنجاح');
        return view('front.client.login');
        //return back();
    }

    public function clientLogin()
    {
        return view('front.client.login');
    }

    public function clientLoginSave(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $client = Client::where('email', $request->input('email'))->first();
        if ($client) {
            if (auth()->guard('client-web')->attempt($request->only('email', 'password'))) {
                flash()->success('hello' . auth()->guard('client-web')->user()->name);
                // flash()->success('hello' . $client->name);
                return redirect('/');
            } else {
                flash()->error('error in login');
                return back();
            }
            flash()->error('لا يوجد حساب مرتبط بهذا الرقم');
            return back();
        }
    }


    public function clientLogout()
    {
        // todo check auth

        //  dd(auth()->guard('client-web')->user());
        auth()->guard('client-web')->logout();
        return redirect('/');
    }



    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);
        $user = Client::where('email', $request->email)->first();
        if ($user) {
            $code = rand(111111, 999999);
            $update = $user->update(['pin_code' => $code]);
            if ($update) {
                // send email
                Mail::to($user->email)
                    //->bcc('elshenaweymona92@gmail.com')
                    ->send(new ResetPassword($code));
            }
        }
    }


    public function updatClientAccount($id)
    {
        $client = Client::findOrFail($id);
        return view('front.client.update-my-account', compact('client'));
    }

    public function updatClientAccountSave(Request $request)
    {
        $validation = $this->validate($request, [
            'name' => 'required',
            //'password'      => 'required|confirmed',
        ]);
        $request->merge(array('password' => bcrypt($request->password)));
        //$client = Client::create($request->except('profile_image'));

        $client = $request->user();
        $client->update($request->except('profile_image'));

        if ($request->hasFile('profile_image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/front/client/'; // upload path
            $logo = $request->file('profile_image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $client->update(['profile_image' => 'uploads/front/client/' . $name]);
        }
        // dd('done');
        flash()->success('تم تعديل البيانات بنجاح ');
        //return view('front.client.login');
        return back();
    }
}
