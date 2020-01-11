<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $transactions = Transaction::where(function($q) use($request) {
            if ($request->has('resturant_id')){
                $q->where('resturant_id',$request->resturant_id);
            }
        })->latest()->paginate(20);
        return view('admin.transactions.index',compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Transaction $model)
    {
        //
        return view('admin.transactions.create',compact('model'));

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
        $this->validate($request, [
            'resturant_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        $transaction = new Transaction;
        $transaction->resturant_id = $request->resturant_id;
        $transaction->amount = $request->amount;
        $transaction->note = $request->note;
        $transaction->save();

        flash()->success('تم إضافة العملية المالية بنجاح');
        return redirect('admin/transaction');
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
        $model=Transaction::findOrFail($id);
        return view('admin.transactions.edit',compact('model'));
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
        $this->validate($request,['resturant_id'=>'required','amount'=>'required|numeric' ]);
        $transaction=Transaction::findOrFail($id);
        $transaction->update($request->all());
        flash()->success('تم تعديل العمليه الماليه بنجاح');
        return  redirect('admin/transaction');

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
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return response()->json($data, 200);
    }
}
