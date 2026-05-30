<?php

namespace App\Pages;

use App\Server\Controller;

class PageController extends Controller
{
    public function home()                  { return view('home'); }
    public function products()              { return view('products.index'); }
    public function productShow($id)        { return view('products.show', compact('id')); }
    public function cart()                  { return view('cart.index'); }
    public function checkout()              { return view('checkout.index'); }
    public function auctions()              { return view('auctions.index'); }
    public function auctionShow($id)        { return view('auctions.show', compact('id')); }
    public function live()                  { return view('live.index'); }
    public function collection()            { return view('collection.index'); }
    public function orders()                { return view('orders.index'); }
    public function psa()                   { return view('psa.index'); }
    public function tracking($id)           { return view('tracking.show', compact('id')); }
    public function profile()               { return view('profile.show'); }
}
