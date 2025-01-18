<?php

namespace App\Cells;



class MainCell {

    public function carousel ($data) : string {
        return view('cells/main/carousel', $data);
    }

    public function productStockBadge ($data) : string {
        return view('cells/main/product_stock_badge', $data);
    }

    public function labelBadge ($data) : string {
        return view('cells/main/label_badge', $data);
    }

    public function orderBadge ($data) : string {
        return view('cells/main/order_badge', $data);
    }

    public function divTitle ($data) : string {
        return view('cells/main/div_title', $data);
    }

    public function search ($data) {
        return view('cells/main/search', $data);
    }

    public function products ($data) {
        return view('cells/main/products', $data);
    }

    public function address ($data) {
        return view('cells/main/address', $data);
    }

    public function addAddress ($data) {
        return view('cells/main/add_address', $data);
    }

    public function createComment ($data) {
        return view('cells/main/create_comment', $data);
    }

    public function emptyCart () {
        return view('cells/main/empty_cart');
    }
    
}
