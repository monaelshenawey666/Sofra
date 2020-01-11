<?php

namespace App\Http\Controllers\Api\Resturant;

use App\Models\Offer;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    //

    public function myOrders(Request $request)
    {
       // $orders = Order::all();
        $orders = $request->user()->orders()->where(function ($order) use ($request) {
            if ($request->has('state') && $request->state == 'completed') {
                $order->whereIn('state', ['rejected', 'delivered', 'declined']);
            } elseif ($request->has('state') && $request->state == 'current') {
                $order->where('state', '=', 'accepted');
            } elseif ($request->has('state') && $request->state == 'pending') {
                $order->where('state', '=', 'pending');
            }
        })->paginate(20);
            //->with('client', 'items', 'restaurant')->latest('updated_at')->paginate(20);
        return responseJson(1, 'تم التحميل', $orders);
    }

    public function showOrder(Request $request)
    {
        $order = Order::with('products', 'client', 'resturant')->find($request->order_id);
        return responseJson(1, 'تم التحميل', $order);
    }

    public function acceptOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state == 'accepted') {
            return responseJson(1, 'تم قبو9ل الطلب');
        }
        $order->update(['state' => 'accepted']);
        $client = $order->client;
        $notification = $client->notifications()->create([
            'title'      => 'تم قبول طلبك',
            'title_en'   => 'Your order is accepted',
            'content'    => 'تم قبول الطلب رقم ' . $request->order_id,
            'content_en' => 'Order no. ' . $request->order_id . ' is accepted',
            'order_id'   => $request->order_id,
            'action'     => 'accept order',
        ]);

        $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        // notifications with OneSignal
        /*  $audience = ['include_player_ids' => $tokens];
          $contents = [
              'en' => 'Order no. ' . $request->order_id . ' is accepted',
              'ar' => 'تم قبول الطلب رقم ' . $request->order_id,
          ];
          $send = notifyByOneSignal($audience, $contents, [
              'user_type'     => 'client',
              'action'        => 'accept-order',
              'order_id'      => $request->order_id,
              'restaurant_id' => $request->user()->id,
          ]);
          $send = json_decode($send);*/
        // Notifications with Firebase

        if (count($tokens)) {

            $title = $notification->title;
            $content = $notification->content;
            $data = [
                'order_id' => $order->id,
            ];
            $send = notifyByFirebase($title, $content, $tokens, $data);
            // dd($send);
            info("firebase result: " . $send);
            //dd($send);
        }
        return responseJson(1, 'تم قبول الطلب');
    }

    public function rejectOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state == 'accepted') {
            $order->update(['state' => 'rejected',
                'refuse_reason' => $request->refuse_reason,
            ]);
            return responseJson(1, 'ناسف لرفض طلبك');
        }
        elseif ($order->state == 'pending' && $order->refuse_reason ==null) {

            $order->update(['state' => 'rejected']);
            $client = $order->client;
            $notification = $client->notifications()->create([
                'title'    => 'تم رفض طلبك',
                //'title_en'   => 'Your order is rejected',
                'content'  => 'تم رفض الطلب رقم ' . $request->order_id,
                //'content_en' => 'Order no. ' . $request->order_id . ' is rejected',
                'order_id' => $request->order_id,
                'action'   => "reject order",
            ]);

            $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();

            if (count($tokens)) {

                $title = $notification->title;
                $content = $notification->content;
                $data = [
                    'order_id' => $order->id,
                ];
                $send = notifyByFirebase($title, $content, $tokens, $data);
                // dd($send);
                info("firebase result: " . $send);
                //dd($send);
            }
            return responseJson(1, 'تم رفض الطلب');
        }
        else{
            return responseJson(0,'تم رفض الطلب');
        }

    }

    public function confirmOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state != 'accepted') {
            return responseJson(0, 'لا يمكن تأكيد الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['state' => 'delivered']);
        $client = $order->client;
        $client->notifications()->create([
            'title'      => 'تم تأكيد توصيل طلبك',
            'title_en'   => 'Your order is delivered',
            'content'    => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id,
            'content_en' => 'Order no. ' . $request->order_id . ' is delivered to you',
            'order_id'   => $request->order_id,
            'action'     => "confirm order",
        ]);

        $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. ' . $request->order_id . ' is delivered to you',
            'ar' => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id,
        ];
//        $send = notifyByOneSignal($audience, $contents, [
//            'user_type'     => 'client',
//            'action'        => 'confirm-order-delivery',
//            'order_id'      => $request->order_id,
//            'resturant_id' => $request->user()->id,
//        ]);
//        $send = json_decode($send);
        return responseJson(1, 'تم تأكيد الاستلام');
    }




////////////////////////////////////////////////////////////////////////////////
    public function myOffers(Request $request)
    {
       //$offers=Offer::all();
        $offers = $request->user()->offers()->with('resturant')->latest()->paginate(20);
        return responseJson(1, '', $offers);
    }

    public function newoffer(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'        => 'required',
            'price'       => 'required|numeric',
           // 'offer_price' => 'numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d',
            'image'       => 'required|image|mimes:jpeg,jpg,png',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        /*if($request->starting_at){
            $request->starting_at = Carbon::now()->toDateString();
        }

        if($request->ending_at){
            $request->ending_at = Carbon::now()->toDateString();
        }*/
        $offer = $request->user()->offers()->create($request->all());

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $offer->image = 'uploads/offers/' . $name;
        }
        $offer->save();

        return responseJson(1, 'تم الاضافة بنجاح', $offer);
    }

    public function updateOffer(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'offer_id'      => 'required',
           // 'name'        => 'required',
            //'price'       => 'required|numeric',
           // 'start_date' => 'required|date_format:Y-m-d',
           // 'end_date'   => 'required|date_format:Y-m-d',
           // 'description' =>'required',
            //'image'       => 'image|max:2048',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        $offer = $request->user()->offers()->find($request->offer_id);

        if (!$offer) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }

       // $offer->update($request->all());
        $offer->update($request->except('image'));

        if ($request->hasFile('image')) {
            if(file_exists($offer->image)){
                unlink($offer->image);
            }
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $offer->update(['image' => 'uploads/offers/' . $name]);
        }

            return responseJson(1, 'تم التعديل بنجاح', $offer);
    }

    public function deleteOffer(Request $request)
    {
        $offer = $request->user()->offers()->find($request->offer_id);
        if (!$offer) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        $offer->delete();
        return responseJson(1, 'تم الحذف بنجاح');
    }



    ///////////////////////////////////////////////////////////////////////
    public function myProducts(Request $request)
    {
        $products = $request->user()->products()->where('category_id', $request->category_id)
            //->enabled()->latest()->paginate(20);
        ->paginate(10);
        return responseJson(1, 'تم التحميل', $products);
    }

    public function newProduct(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'           => 'required',
            'category_id'    => 'required|exists:categories,id',
            'price'          => 'required|numeric',
            'image'          => 'required|image|max:2048',
            'description'    => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
//        if ($request->offer_price >= $request->price) {
//            return responseJson(0, 'يجب أن يكون السعر فى العرض أقل من سعر المنتج');
//        }
        $products = $request->user()->products()->create($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/products/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $products->update(['image' => 'uploads/products/' . $name]);
        }

        return responseJson(1, 'تم الاضافة بنجاح', $products->load('category'));
    }

    public function updateProduct(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'product_id'      => 'required',
            //'name'           => 'required',
           // 'category_id'    => 'required|exists:categories,id',
           // 'price'          => 'required|numeric',
           // 'image'          => 'image|max:2048',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
//        if ($request->offer_price >= $request->price) {
//            return responseJson(0, 'يجب أن يكون السعر فى العرض أقل من سعر المنتج');
//        }
        $product = $request->user()->products()->find($request->product_id);

        if (!$product) {
            return responseJson(0, 'لا يمكن الحصووول على البيانات');
        }
        $product->update($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/products/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $product->update(['image' => 'uploads/products/' . $name]);
        }

        return responseJson(1, 'تم التعديل بنجاح', $product);
    }

    public function deleteProduct(Request $request)
    {
        $product = $request->user()->products()->find($request->product_id);
        if (!$product) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if (count($product->orders) > 0) {
            //$product->update(['disabled' => 1]);
            return responseJson(1, 'لا يمكن حذف هذا المنتج');
        }

        $product->delete();
        return responseJson(1, 'تم الحذف بنجاح');
    }

    //////////////////////////////////////////////////////////////////



    public function myCategories(Request $request)
    {
        $categories = $request->user()->categories()->paginate(20);
        return responseJson(1, 'تم التحميل', $categories);
    }
    public function newCategory(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'  => 'required',
            //'photo' => 'required|image|max:2048',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $category = $request->user()->categories()->create($request->all());
//        if ($request->hasFile('photo')) {
//            $path = public_path();
//            $destinationPath = $path . '/uploads/categories/'; // upload path
//            $photo = $request->file('photo');
//            $extension = $photo->getClientOriginalExtension(); // getting image extension
//            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
//            $photo->move($destinationPath, $name); // uploading file to given path
//            $category->update(['photo' => 'uploads/categories/' . $name]);
//        }

        return responseJson(1, 'تم الاضافة بنجاح', $category->load('resturants'));
    }

    public function updateCategory(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'        => 'required',
            //'photo'       => 'image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $category = $request->user()->categories()->find($request->category_id);

        if (!$category) {
            return responseJson(0, 'تعذر الحصول على بيانات');
        }
        $category->update($request->all());
//        $category->update($request->except('photo'));
//        if ($request->hasFile('photo')) {
//            if (file_exists($category->photo))
//                unlink($category->photo);
//            $path = public_path();
//            $destinationPath = $path . '/uploads/categories/'; // upload path
//            $photo = $request->file('photo');
//            $extension = $photo->getClientOriginalExtension(); // getting image extension
//            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
//            $photo->move($destinationPath, $name); // uploading file to given path
//            $category->update(['photo' => 'uploads/categories/' . $name]);
//            $category->save();
//        }

        return responseJson(1, 'تم التعديل بنجاح', $category);
    }

    public function deleteCategory(Request $request)
    {
        $category = $request->user()->categories()->find($request->category_id);
        if (!$category) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        $category->delete();
        return responseJson(1, 'تم الحذف بنجاح');
    }


    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(20);
        //with('order')->latest()->paginate(20);
        return responseJson(1, 'تم التحميل', $notifications);
    }



}
