<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

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

        $category = Category::find($request->category_id);
        
        if($category) {
            $contact['category_name'] = $category->content;
        }else{
            $contact['category_name'] = '';
        }
    return view('confirm', compact('contact'));
    }


    public function store(Request $request)
    {
        if($request->input('action') === 'back') {
            return redirect('/')->withInput();
    }

    $contact = $request->only(['category_id', 'last_name', 'first_name', 'gender', 'email', 'tel', 'address', 'building', 'detail']);
    Contact::create($contact);

    return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->Paginate(7);
        $categories = Category::all();//検索用のカテゴリーを取得

        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $contacts = Contact::with('category')
        ->KeywordSearch($request->keyword)
        ->GenderSearch($request->gender)
        ->CategorySearch($request->category_id)
        ->DateSearch($request->date)
        ->Paginate(7);

        $categories = Category::all();
        
        return view('admin', compact('contacts', 'categories'));
    }
}
