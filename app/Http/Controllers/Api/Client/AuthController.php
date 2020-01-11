<?php

namespace App\Http\Controllers\Api\Client;

use App\Mail\ResetPassword;
use App\Models\Client;

use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'          => 'required',
            'phone'         => 'required',
            'region_id'     => 'required',
            'email'         => 'required|unique:clients,email',
            'password'      => 'required|confirmed',
            'profile_image' => 'required|image|mimes:png,jpeg',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $userToken = str_random(60);
        $request->merge(array('api_token' => $userToken));
        $request->merge(array('password' => bcrypt($request->password)));
        $user = Client::create($request->all());
        if ($request->hasFile('profile_image')) {

            $path = public_path();
            $destinationPath = $path . '/uploads/clients/'; // upload path
            $photo = $request->file('profile_image');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $user->profile_image = 'uploads/clients/' . $name;
        }

        $user->save();
        if ($user) {
            $data = [
                'api_token' => $userToken,
                'user'      => $user->fresh()->load('region')
            ];

            return responseJson(1, 'تم التسجيل بنجاح', $data);
        } else {
            return responseJson(0, 'حدث خطأ ، حاول مرة أخرى');
        }
    }

    public function login(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email'    => 'required',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $user = Client::where('email', $request->input('email'))->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // check if not activated
                $data = [
                    'api_token' => $user->api_token,
                    'user'      => $user->load('region'),
                ];
                return responseJson(1, 'تم تسجيل الدخول', $data);
            } else {
                return responseJson(0, 'بيانات الدخول غير صحيحة');
            }
        } else {
            return responseJson(0, 'بيانات الدخول غير صحيحة');
        }
    }

    public function profile(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'region_id'     => 'exists:regions,id',
            'password'      => 'confirmed',
            Rule::unique('users')->ignore($request->user()->id),
            'profile_image' => 'image|mimes:png,jpeg',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        if ($request->has('name')) {
            $request->user()->update($request->only('name'));
        }
        if ($request->has('email')) {
            $request->user()->update($request->only('email'));
        }
        if ($request->has('password')) {
            $request->merge(array('password' => bcrypt($request->password)));
            $request->user()->update($request->only('password'));
        }

        if ($request->has('phone')) {
            $request->user()->update($request->only('phone'));
        }

        if ($request->has('region_id')) {
            $request->user()->update($request->only('region_id'));
        }
        if ($request->has('address')) {
            $request->user()->update($request->only('address'));
        }

        $loginUser = $request->user();
        if ($request->hasFile('profile_image')) {
            if (file_exists($loginUser->profile_image)) {
                unlink($loginUser->profile_image);
            }
            $path = public_path();
            $destinationPath = $path . '/uploads/clients/'; // upload path
            $photo = $request->file('profile_image');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $loginUser->profile_image = 'uploads/clients/' . $name;
        }
        $loginUser->save();
        $data = [
            'user' => $request->user()->load('region')
        ];
        return responseJson(1, 'تم تحديث البيانات', $data);
    }

    public function resetpassword(Request $request)
{
    $validation = validator()->make($request->all(), [
        'email' => 'required'
    ]);
    if ($validation->fails()) {
        $data = $validation->errors();
        return responseJson(0, $validation->errors()->first(), $data);
    }
    $user = Client::where('email', $request->email)->first();
    if ($user) {
        $code = rand(111111, 999999);
        $update = $user->update(['pin_code' => $code]);
        if ($update) {
            // send email

            Mail::to($user->email)
                ->bcc('elshenaweymona92@gmail.com')
                ->send(new ResetPassword($code));

            return responseJson(1, 'برجاء فحص بريدك الالكتروني', [
                'pin_code' => $code
            ]);
        } else {
            return responseJson(0, 'حدث خطأ ، حاول مرة أخرى');
        }
    } else {
        return responseJson(0, 'لا يوجد أي حساب مرتبط بهذا البريد الالكتروني');
    }
}

    /**
     * @param Request $request
     * @return mixed
     */
    public function newpassword(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'pin_code'     => 'required',
            'password' => 'confirmed',
            'email'     => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $user = Client::where('pin_code', $request->pin_code)
            //->where('code', '!=', 0)->first();
            ->where('email',$request->email)->first();

        if ($user) {
            $update = $user->update(['password' => bcrypt($request->password),
                'pin_code' => null]);
            if ($update) {
                return responseJson(1, 'تم تغيير كلمة المرور بنجاح');
            } else {
                return responseJson(0, 'حدث خطأ ، حاول مرة أخرى');
            }
        } else {
            return responseJson(0, 'هذا الكود غير صالح');
        }
    }

    public function registerToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'type'  => 'required|in:android,ios',
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        Token::where('token', $request->token)->delete();

        $request->user()->tokens()->create($request->all());
        return responseJson(1, 'تم التسجيل بنجاح');
    }
}
