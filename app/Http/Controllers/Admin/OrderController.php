<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $order = Order::where(function($q) use($request){
            if ($request->order_id)
            {
                $q->where('id',$request->order_id);
            }

            if ($request->resturant_id)
            {
                $q->where('resturant_id',$request->resturant_id);
            }

            if ($request->state)
            {
                $q->where('state',$request->state);
            }

            if ($request->from && $request->to)
            {
                $q->whereDate('created_at' , '>=' , $request->from);
                $q->whereDate('created_at' , '<=' , $request->to);
            }

        })->with('resturant')->latest()->paginate(20);
        return view('admin.orders.index',compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Order::with('resturant','products','client')->findOrFail($id);

        return view('admin.orders.show',compact('order'));
    }

    public function print_invoice($id){
        $order = Order::with('address','resturant','products','reviews','qualities','user','options')->findOrFail($id);
        return view('layouts.print',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
