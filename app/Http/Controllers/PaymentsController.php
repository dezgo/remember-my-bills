<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

/**
 * Class PaymentsController
 * @package App\Http\Controllers
 */
class PaymentsController extends Controller
{

    /**
     * Ensure users are authenticated before using this controller
     * @param null $payments
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $payments = Auth::user()->payments->sortByDesc('payment_date');

        return view('payments.index', compact('payments'));
    }
}