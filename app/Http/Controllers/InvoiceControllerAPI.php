<?php
/**
 * Created by PhpStorm.
 * User: ciscomen
 * Date: 18/12/2018
 * Time: 22:00
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\Invoice as InvoiceResource;
use Illuminate\Support\Facades\DB;

use App\Invoice;
use App\StoreInvoiceRequest;

class InvoiceControllerAPI extends Controller
{
    public function all(Request $request)
    {
        if ($request->has('page')) {
            return InvoiceResource::collection(Invoice::orderBy('date','desc')->paginate(5));
        } else {
            return InvoiceResource::collection(Invoice::orderBy('date','desc')->get());
        }

    }
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return InvoiceResource::collection(Invoice::orderBy('date','desc')->paginate(5));
        } else {
            return InvoiceResource::collection(Invoice::whereNotIn('state', ['paid'])->orderByRaw('state')->orderBy('date','desc')->get());
        }

    }
    public function paid(Request $request)
    {
        if ($request->has('page')) {

            return InvoiceResource::collection(Invoice::where('state', ['paid'])->orderBy('date','desc')->paginate(5));
        } else {
            return InvoiceResource::collection(Invoice::where('state', ['paid'])->orderBy('date','desc')->get());
        }

    }
    public function notpaid(Request $request)
    {
        if ($request->has('page')) {

            return InvoiceResource::collection(Invoice::where('state', ['not paid'])->orderBy('date','desc')->paginate(5));
        } else {
            return InvoiceResource::collection(Invoice::where('state', ['not paid'])->orderBy('date','desc')->get());
        }

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'state' => 'required|in:paid,not paid,pending'
        ]);
        $invoice = invoice::findOrFail($id);
        $invoice->update($request->all());
        return new InvoiceResource($invoice);
    }
}