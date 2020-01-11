<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Offer;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Region;
use App\Models\Resturant;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    //
    public function cities(Request $request)
    {
        $cities = City::where(function ($q) use ($request) {
            if ($request->has('name')) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            }
        })->paginate(10);
        //$cities=City::all();
        return responseJson(1, 'تم التحميل', $cities);
    }

    public function regions(Request $request)
    {
        $regions = Region::where(function ($q) use ($request) {
            if ($request->has('name')) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            }
        })->where('city_id', $request->city_id)->get();
        return responseJson(1, 'تم التحميل', $regions);
    }

    public function categories(Request $request)
    {
        $categories = Category::whereHas('resturants',function ($q)use($request){
            $q->where('resturant_id',$request->resturant_id);
        })->get();
//        if ($request->input('prepend') == 1)
//        {
//            $categories = $this->prependToCategories($categories);
//        }
      //  $categories = Category::all();

        return responseJson(1, 'تم التحميل', $categories);
    }


    public function resturants(Request $request)
    {
        $resturants = Resturant::where(function ($q) use ($request) {
            if ($request->keyword) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('name', 'LIKE', '%' . $request->keyword . '%');
                });
            }

            if ($request->region_id) {
                $q->where('region_id', $request->region_id);
            }

            /*if ($request->categories) {
                $q->whereHas('categories', function ($q2) use ($request) {
                    $q2->whereIn('categories.id', $request->categories);
                });
            }*/


        })->paginate(10);
        //dd($resturants);
        if ($resturants->count()) {
            return responseJson(1, 'تم التحميل', $resturants);
        }
        return responseJson(0, 'لا يوجد نتائج بحث');
        /*
         *->orderByRating()
         * ->sortByDesc(function ($restaurant) {
            return $restaurant->reviews->sum('rate');
        })
         * */

    }

    public function resturant(Request $request)
    {
        $resturant = Resturant::with('region')->find($request->resturant_id);
        if (!$resturant) {
            return responseJson(0, 'لايوجد مطعم بهذا الرقم');
        }
        return responseJson(1, 'تم التحميل', $resturant);
    }

    public function products(Request $request)
    {
        $products = Product::with('resturant','category')->where('resturant_id', $request->resturant_id)
            ->where('category_id', $request->category_id)->paginate(10);
           // ->enabled()->paginate(20);
       // $items2 = Product::where('resturant_id',$request->resturant_id)->paginate(20);
       // $offers = Product::where('resturant_id', $request->resturant_id)
        //    ->offered()->latest()->paginate(10);

//        if ($request->category_id == -1) {
//
//            return responseJson(1, 'done', $offers);
//        }
//        if ($request->category_id == 0) {
//
//            return responseJson(1, 'done', $items2);
//        }
        return responseJson(1, 'تم التحميل', $products);
    }

//    public function latestOffers(Request $request)
//    {
//        $offers = Item::where('restaurant_id', $request->restaurant_id)
//            ->offered()->latest()->paginate(10);
//
//        return responseJson(1, 'تم التحميل', $offers);
//    }


    public function offers(Request $request)
    {
//        $offers = Offer::where(function ($offer) use ($request) {
//            if ($request->has('resturant_id')) {
//                $offer->where('resturant_id', $request->resturant_id);
//            }
//        })->has('resturant')->with('resturant')->latest()->paginate(20);

        $offers=Offer::with('resturant')->where('resturant_id',$request->resturant_id)->paginate(10);

//        $resturant = Resturant::find($request->resturant_id);
//        if (!$resturant) {
//            return responseJson(0, 'no data');
//        }
//        $offers = $resturant->offers()->paginate(10);

        return responseJson(1, 'تم التحميل', $offers);
    }


    public function offer(Request $request)
    {
        $offer = Offer::with('resturant')->find($request->offer_id);
        if (!$offer) {
            return responseJson(0, 'no data');
        }
        return responseJson(1, 'success', $offer);
    }
    public function paymentMethods()
    {
        $methods = PaymentMethod::all();
        return responseJson(1, 'تم التحميل', $methods);
    }


    public function reviews(Request $request)
    {
//        $resturant = Resturant::find($request->resturant_id);
//        if (!$resturant) {
//            return responseJson(0, 'no data');
//        }
//        $reviews = $resturant->reviews()->paginate(10);
       $reviews=Review::with('resturant')->where('resturant_id', $request->resturant_id)->paginate(10);
        return responseJson(1, 'successss', $reviews);

    }

    public function contact(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'state'    => 'required|in:Complaint,Suggestion,Enquiry',
          //  'state'    => 'required',
            'name'    => 'required',
            'email'   => 'required',
            'phone'   => 'required',
            'message' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $contact = Contact::create($request->all());

        return responseJson(1, 'تم الارسال بنجاح', $contact);
    }

    public function settings()
    {
        $settinges = Setting::first();
        return responseJson(1, 'success', $settinges);
       // return responseJson(1, 'success', settings());
    }
}
