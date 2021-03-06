<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('scope:read-general')->only(['show']);
        $this->middleware('can:view,seller')->only(['show']);
    }

    public function index()
    {
        $this->allowedAdminAction();

        $sellers = Seller::has('products')->get();

        return $this->ShowAll($sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        return $this->ShowOne($seller);
    }
}
