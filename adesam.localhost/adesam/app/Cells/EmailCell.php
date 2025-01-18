<?php

namespace App\Cells;



class EmailCell {

    
    public function contactForm ($data) : string {
        return view('cells/email/contact_form', $data);
    }

    public function passwordReset ($data) : string {
        return view('cells/email/password_reset', $data);
    }

    public function productInquiry ($data) : string {
        return view('cells/email/product_inquiry', $data);
    }
    
}
