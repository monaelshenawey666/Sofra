<?php

namespace App\Http\Controllers\Api\Resturant;

use App\Mail\ResetPassword;
use App\Models\Resturant;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'            => 'required',
            'email'           => 'required|unique:resturants,email',
            'password'        => 'required|confirmed',
            'phone'           => 'required',
            'delivery_fee'   => 'required|numeric',
            'time_of_preparation'   => 'required',
            'minimum_charger' => 'required|numeric',
            'whatsNum'        => 'required',
            'region_id'       => 'required',
            'delivery_phone' =>'required',
            'image'           => 'required|image|mimes:png,jpg',
            'categories' => 'required|array'
        ]);


        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $userToken = str_random(60);
        $request->merge(array('api_token' => $userToken));
        $request->merge(array('password' => bcrypt($request->password)));
        $user = Resturant::create($request->all());
        $user->categories()->attach($request->categories);

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/resturants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $user->update(['image' => 'uploads/resturants/' . $name]);
        }

        if ($user) {
            $data = [
                'api_token' => $userToken,
               // 'data'      => $user->load('region', 'categories')
            ];
            return responseJson(1, 'تم إرسال طلبك للادارة بنجاح');
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

        $user = Resturant::where('email', $request->input('email'))->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
//                if (($user->total_commissions - $user->total_payments) > 400)
//                {
//                    return responseJson(0,'الحساب موقوف لتخطي العمولات التي لم تسدد الحد المطلوب');
//                }
//                if (($user->total_commissions - $user->total_payments) > 400) {
//                    $data = [
//                        'api_token' => $user->api_token,
//                        'user'      => $user
//                    ];
//                    return responseJson(
//                        -1,
//                        'تم ايقاف حسابك مؤقتا الى حين سداد العموله لوصولها للحد الاقصى ، يرجى مراجعة صفحة العمولة او مراجعة ادارة التطبيق شاكرين لكم استخدام تطبيق سفرة',
//                        $data
//                    );
//                }

//                if ($user->activated == 0) {
//                    return responseJson(0, 'الحساب موقوف .. تواصل مع الإدارة');
//                }
                $data = [
                    'api_token' => $user->api_token,
                    'user' => $user,
                    //'user'      => $user->load('region', 'categories'),
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
            'password' => 'confirmed',
            'image'    => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
            // 'email'    => Rule::unique('restaurants')->ignore($request->user()->id),
            'email'    => 'email|unique:resturants,email,'.auth()->user()->id
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
        if ($request->has('phone')) {
            $request->user()->update($request->only('phone'));
        }
        if ($request->has('region_id')) {
            $request->user()->update($request->only('region_id'));
        }
        if ($request->has('whatsNum')) {
            $request->user()->update($request->only('whatsapp'));
        }
        if ($request->has('delivery_fee')) {
            $request->user()->update($request->only('delivery_cost'));
        }
        if ($request->has('mini')) {
            $request->user()->update($request->only('minimum_charger'));
        }
        if ($request->has('time_of_preparation')) {
            $request->user()->update($request->only('delivery_time'));
        }

//        if ($request->has('availability')) {
//            $request->user()->update($request->only('availability'));
//        }
        $user = $request->user();
       // $user->update($request->except('image'));
        if ($request->hasFile('image')) {
            if(file_exists($user->image)){
                unlink($user->image);
            }
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $request->user()->update(['image' => 'uploads/resturants/' . $name]);
        }

        $data = [
            'user' => $request->user()->load('region')
        ];
        if($request->user()->save()) {
            return responseJson(1, 'تم تحديث البيانات', $data);
        }
        else{
            return responseJson(0,'fail');
        }
    }




    public function reset(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email' => 'required'
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        $user = Resturant::where('email', $request->email)->first();
        if ($user) {
            $code = rand(111111, 999999);
            $update=$user->update(['pin_code'=>$code]);
            if ($update) {
                // send email
                Mail::to($user->email)
                    ->bcc('elshenaweymona92@gmail.com')
                    ->send(new ResetPassword($code));

                return responseJson(1, 'برجاء فحص بريدك الالكتروني', [
                    'pin_code' => $code,
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
    public function password(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'pin_code'     => 'required',
            'email'     => 'required',
            'password' => 'confirmed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $user = Resturant::where('pin_code', $request->pin_code)
            //->where('pin_code', '!=', 0)->first();
            ->where('email',$request->email)->first();

        if ($user) {
            $update = $user->update([
                'password' => bcrypt($request->password),
                'pin_code' => null]);
//            $user->password=bcrypt($request->password);
//            $user->pin_code=null;
            if ($update)
            {
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




>php artisan make:request Api/Provider/DeleteOfferRequest
>php artisan make:resource Provider/UserResourcer
php artisan make:controller Dashboard/OfferController




}
