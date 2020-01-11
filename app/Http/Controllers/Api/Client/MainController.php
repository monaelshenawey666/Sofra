<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Product;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    //
    public function newOrder(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'resturant_id'     => 'required|exists:resturants,id',
            'products'             => 'required|array',
            'products. *'           => 'required|exists:products,id',
            'quantities'        => 'required|array',
            'notes'             => 'required|array',
            'address_delivery'           => 'required',
            'payment_method_id' => 'required|exists:payment_methods,id',
            //            'need_delivery_at' => 'required|date_format:Y-m-d',// H:i:s
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $resturant = Resturant::find($request->resturant_id);

//        // restaurant closed
        if ($resturant->is_open == false) {
            return responseJson(0, 'عذرا المطعم غير متاح في الوقت الحالي');
        }

        // client
        // set defaults
        //$order = Order::create($request->all());
        $order = $request->user()->orders()->create([
            'resturant_id'     => $request->resturant_id,
            'note'              => $request->note,
            'state'             => 'pending', // db default
            'address_delivery'           => $request->address_delivery,
            'payment_method_id' => $request->payment_method_id,
        ]);

        $cost = 0;
        $delivery_cost = $resturant->delivery_fee;
       // dd($delivery_cost);

        if ($request->has('products')) {
            $counter = 0;
            foreach ($request->products as $productId) {
                $product = Product::find($productId);
                $order->products()->attach([
                    $productId => [
                        'quantity' => $request->quantities[$counter],
                        'price'    => $product->price,
                        'note'     => $request->notes[$counter],
                    ]
                ]);
                $cost += ($product->price * $request->quantities[$counter]);
                $counter++;
            }
        }

        // minimum charge
        if ($cost >= $resturant->minimum_charger) {
            $total = $cost + $delivery_cost; // 200 SAR
           $commission = settings()->commission * $cost; // 20 SAR  // 10 // 0.1  // $total; edited to remove delivery cost from percent.
            $net = $total - settings()->commission;
            $update = $order->update([
                'cost'          => $cost,
                'delivery_cost' => $delivery_cost,
                'total'         => $total,
                'commission'    => $commission,
                'net'           => $net,
            ]);
         //   $request->user()->cart()->detach();
            /* notification */
            $notification = $resturant->notifications()->create([
                'title'      => 'لديك طلب جديد',
               // 'title_en'   => 'You have New order',
                'content'    => 'لديك طلب جديد من العميل ' . $request->user()->name,
                //'content_en' => 'You have New order by client ' . $request->user()->name,
                'action'     => 'new order',
                'order_id'   => $order->id,

            ]);

            $tokens = $resturant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            //dd($tokens);
            if (count($tokens)) {

                $title = $notification->title;
                $content = $notification->content;
                $data = [
                    'order_id' => $order->id,
                ];
                $send = notifyByFirebase($title, $content, $tokens, $data);
                //dd($send);
                info("firebase result: " . $send);
                //dd($send);
            }

            return responseJson(1, 'تم الطلب بنجاح', $order->fresh()->load('products', 'resturant.region', 'resturant.categories', 'client'));
        } else {
            $order->products()->delete();
            $order->delete();
            return responseJson(0, 'الطلب لابد أن لا يكون أقل من ' . $resturant->minimum_charger . ' ريال');
        }
    }

    public function myOrders(Request $request)
    {
        $orders = $request->user()->orders()->where(function ($order) use ($request) {
            if ($request->has('state') && $request->state == 'completed') {
                $order->whereIn('state',['rejected','delivered','declined']);
            } elseif ($request->has('state') && $request->state == 'current') {
                $order->where('state','=','accepted');
            } elseif ($request->has('state') && $request->state == 'pending') {
                $order->where('state', '=', 'pending');
            }
        })->with('resturant', 'products')->latest('updated_at')->paginate(20);
        return responseJson(1, 'تم التحميل', $orders);
    }

    public function showOrder(Request $request)
    {
        $order = $request->user()->orders()->with('resturant', 'products')->find($request->order_id);
        return responseJson(1, 'تم التحميل', $order);
    }

//    public function confirmOrder(Request $request)
//    {
//        $order = $request->user()->orders()->find($request->order_id);
//        if (!$order) {
//            return responseJson(0, 'لا يمكن الحصول على البيانات');
//        }
//
//        if ($order->state == 'pending' || $order->state == 'rejected' || $order->state == 'declined'||$order->state == 'accepted') {
//            return responseJson(0, 'لا يمكن تأكيد استلام الطلب ');
//        }
//        /*if ($order->delivery_confirmed_by_client == 1) {
//            return responseJson(1, 'تم تأكيد الاستلام');
//        }*/
//        $order->update(['state' => 'delivered']);
//        $resturant = $order->restaurant;
//        $resturant->notifications()->create([
//            'title'      => 'تم تأكيد توصيل طلبك من العميل',
//            'title_en'   => 'Your order is delivered to client',
//            'content'    => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
//            'content_en' => 'Order no. ' . $request->order_id . ' is delivered to client',
//            'order_id'   => $request->order_id,
//            'action'     => 'confirm order delivery'
//        ]);
//
//        $tokens = $resturant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
//        $audience = ['include_player_ids' => $tokens];
//        $contents = [
//            'en' => 'Order no. ' . $request->order_id . ' is delivered to client',
//            'ar' => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
//        ];
//        $send = notifyByOneSignal($audience, $contents, [
//            'user_type' => 'restaurant',
//            'action'    => 'confirm-order-delivery',
//            'order_id'  => $request->order_id,
//        ]);
//        $send = json_decode($send);
//
//        return responseJson(1, 'تم تأكيد الاستلام');
//    }

//    public function declineOrder(Request $request)
//    {
//        $order = $request->user()->orders()->find($request->order_id);
//        if (!$order) {
//            return responseJson(0, 'لا يمكن الحصول على البيانات');
//        }
//        if ($order->state == 'accepted') {
//            return responseJson(0, 'لا يمكن الغاء الطلب ، الطلب فى مرحلة التجهيز');
//        }
//        if ($order->state == 'declined') {
//            return responseJson(1, 'هذا الطلب ملغى');
//        }
//        $order->update(['state' => 'declined']);
//        $restaurant = $order->restaurant;
//        $notification = $restaurant->notifications()->create([
//            'title'      => 'تم الغاء الطلب من العميل',
//            //'title_en'   => 'Your order delivery is declined by client',
//            'content'    => 'تم الغاء الطلب رقم ' . $request->order_id . 'من العميل',
//            //'content_en' => 'Delivery if order no. ' . $request->order_id . ' is declined by client',
//            'order_id'   => $request->order_id,
//            'action'     => 'decline order'
//        ]);
//
//        $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
//        if (count($tokens)) {
//
//            $title = $notification->title;
//            $content = $notification->content;
//            $data = [
//                'order_id' => $order->id,
//            ];
//            $send = notifyByFirebase($title, $content, $tokens, $data);
//            // dd($send);
//            info("firebase result: " . $send);
//            //dd($send);
//        }
//
//        return responseJson(1, 'تم الغاء الطلب');
//    }

    public function review(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'rate'          => 'required',
            'comment'       => 'required',
            'resturant_id' => 'required|exists:resturants,id',

        ]);
        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }

        $resturant = Resturant::find($request->resturant_id);
        if (!$resturant) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        $request->merge(['client_id' => $request->user()->id]);
        $clientOrdersCount = $request->user()->orders()
            ->where('resturant_id', $resturant->id)
            ->where('state', 'accepted')
            ->count();
        if ($clientOrdersCount == 0) {
            return responseJson(0, 'لا يمكن التقييم الا بعد تنفيذ طلب من المطعم');
        }
        $checkOrder = $request->user()->orders()
            ->where('resturant_id', $resturant)
            ->where('state', 'accepted')
            ->count();
        if ($checkOrder > 0) {
            return responseJson(0, 'لا يمكن التقييم الا بعد بيان حالة استلام الطلب');
        }
        $old_reviews = $request->user()->reviews()->where('resturant_id', $request->resturant_id)->first();
        if (count($old_reviews)) {
            $old_reviews->update($request->all());
            return responseJson(1, 'لديك تقييم من قبل,,,وتم تحديثه حاليا', [
                'review' => $old_reviews
            ]);
        }
        $review = $request->user()->reviews()->create($request->all());

        $avgRate = $resturant->reviews()->avg('rate');
        $resturant->update(['rate' => $avgRate]);
        return responseJson(1, 'تم التقييم بنجاح', [
            'review' => $review
        ]);

    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->with('order')->latest()->paginate(20);
        return responseJson(1, 'تم التحميل', $notifications);
    }
}
