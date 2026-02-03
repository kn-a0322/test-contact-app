<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(Request $request)
    {
        $contact = $request->all();
        $contact['tel'] = $contact['tel1']  . $contact['tel2'] .  $contact['tel3'];

        $categories = [
            '1' => '商品のお届けについて',
            '2' => '商品の交換について',
            '3' => '商品トラブル',
            '4' => 'ショップへのお問い合わせ',
            '5' => 'その他',
        ];
        $contact['category_name'] = $categories[$contact['category_id']];

        return view('confirm', compact('contact'));
    }
}
