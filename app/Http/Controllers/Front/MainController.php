<?php

namespace App\Http\Controllers\Front;

use App\Models\City;
use App\Models\Contact;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Resturant;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class mainController extends Controller
{
    //
    public  function home(Request $request)
    {
       // return view('front.home');
        $cities=City::get();

        $resturants=Resturant::where(function ($query) use ($request) {
//            if ($request->name) {
//                $query->where('name',$request->name);
//            }
            if ($request->name) {
                $query->where(function ($q2) use ($request) {
                    $q2->where('name', 'LIKE', '%' . $request->name . '%');
                });
            }
            if ($request->city) {
                $query->whereHas('region',function ($que) use ($request){
                    $que->where('city_id',$request->city);
                });
            }
        })->paginate(5);
        return view('front.home',compact('cities','resturants'));
    }

    public  function allOffers()
    {
        $offers=Offer::all();
        return view('front.all-offers',compact('offers'));
    }
    public  function resturantDetails($id)
    {
       // $resturant = $request->user();
        $resturants = Resturant::find($id);
        $products=$resturants->products()->paginate(10);
        //$products = $request->user()->products()->latest()->paginate(20);
        return view('front.resturant-details',compact('products','resturants'));
    }
    public  function productDetails($id)
    {
        $contacts=Contact::all();
        $product=Product::findOrFail($id);
        return view('front.product-details',compact('product','contacts'));
    }
    public  function contactUs()
    {
        return view('front.contact-us');
    }
    public function contactUsSave(Request $request)
    {
        $validation = $this->validate($request, [
            'name'          => 'required',
            'email'       => 'required',
            'phone' => 'required',
            'message' => 'required',
            //'state'    => 'required',
            'state'    => 'required|in:Complaint,Suggestion,Enquiry',
        ]);
        $contact = Contact::create($request->all());
        flash()->success('تم إضافة رسالتك بنجاح');
        return back();

    }

    public  function ratesAverage(Request $request)
    {
        $rates = Review::all();
        $rates->avg('rate');
        return view('front.home')->withValue($rates);

      //  $rates = $request->user()->reviews()->avrage();
    }


}


