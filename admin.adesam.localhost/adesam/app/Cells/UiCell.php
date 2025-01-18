<?php

namespace App\Cells;



class UiCell {

    public function occasionBadge ($data) : string {
        return view('cells/ui/occasion_badge', $data);
    }

    public function productStockbadge ($data) : string {
        return view('cells/ui/product_stock_badge', $data);
    }

    public function productVisibiltybadge ($data) : string {
        return view('cells/ui/product_visibility_badge', $data);
    }

    public function tagBadge ($data) : string {
        return view('cells/ui/tag_badge', $data);
    }

    public function orderBadge ($data) : string {
        return view('cells/ui/order_badge', $data);
    }

    public function deliveryBadge ($data) : string {
        return view('cells/ui/delivery_badge', $data);
    }

    public function paymentBadge ($data) : string {
        return view('cells/ui/payment_badge', $data);
    }

    public function calendarBadge ($data) : string {
        return view('cells/ui/calendar_badge', $data);
    }

    public function tagModal ($data) : string {
        return view('cells/ui/tag_modal', $data);
    }

    public function titleHeader ($data) : string {
        return view('cells/ui/title_header', $data);
    }
    
}
