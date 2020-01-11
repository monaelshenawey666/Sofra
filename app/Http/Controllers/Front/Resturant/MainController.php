<?php

namespace App\Http\Controllers\Front\Resturant;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    //


    public  function myProducts(Request $request)
    {
        //$products=Product::findOrFail($id)->paginate(10);
        $products = $request->user()->products()->latest()->paginate(20);
        return view('front.resturant.my-products',compact('products'));
    }
    public  function addNewProduct()
    {
        return view('front.resturant.add-new-product');
    }
    public  function addNewProductSave(Request $request)
    {
        $validation = $this->validate($request, [
            'name'           => 'required',
            // 'category_id'    => 'required|exists:categories,id',
            'price'          => 'required|numeric',
            'image'          => 'required|image|mimes:png,jpeg,jpg',
            'description'    => 'required',
        ]);
        //  $products = $request->user()->products()->create($request->all());
        // $products = Product::create($request->all());
        $product = $request->user()->products()->create($request->all());
        if ($request->hasFile('image')) {
            //dd('fjsdbjkdfs');
            $path = public_path();
            $destinationPath = $path . '/uploads/front/products/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $product->image = 'uploads/front/products/'.$name;
            // dd($product->image);
            $product->save();
        }
        // dd('done');
        flash()->success('تم إضافةالمنتج بنجاح');
        return back();

    }

    public  function myOffers(Request $request)
    {
        $offers = $request->user()->offers()->latest()->paginate(20);
        return view('front.resturant.my-offers',compact('offers'));
    }
    public  function addNewOffer()
    {
        return view('front.resturant.add-new-offer');
    }
    public  function addNewOfferSave(Request $request)
    {
        $validation = $this->validate($request, [

            'description'    => 'required',
            'name'        => 'required',
            'price'       => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d',
            'image'       => 'required|image|mimes:jpeg,jpg,png',
        ]);

        $offer = $request->user()->offers()->create($request->all());
        if ($request->hasFile('image')) {
            //dd('fjsdbjkdfs');
            $path = public_path();
            $destinationPath = $path . '/uploads/front/products/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $offer->image = 'uploads/front/offers/'.$name;
            // dd($offer->image);
            $offer->save();
        }
        // dd('done');
        flash()->success('تم اضافه العرض بنجاح');
        return back();

    }

    public  function currentorders(Request $request)
    {
      // $orders = $request->user()->orders()->where(state=='pending')->latest()->paginate(20);
       $orders = $request->user()->orders()->latest()->paginate(20);
        return view('front.resturant.current-orders',compact('orders'));
    }
    public  function previoustorders(Request $request)
    {
        // $orders = $request->user()->orders()->where(state=='pending')->latest()->paginate(20);
        $orders = $request->user()->orders()->latest()->paginate(20);
        return view('front.resturant.previous-orders',compact('orders'));
    }




}
