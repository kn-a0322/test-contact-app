<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->all();
        $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];

        $category = Category::find($request->category_id);

        if($category) {
            $contact['category_name'] = $category->content;
        } else {
            $contact['category_name'] = '';
        }
        return view('confirm', compact('contact'));
    }


    public function store(ContactRequest $request)
    {
        if($request->input('action') === 'back') {
            return redirect('/')->withInput();
        }

        $contact = $request->only(['category_id', 'last_name', 'first_name', 'gender', 'email', 'address', 'building', 'detail']);
        $contact['tel'] = $request->tel1 . $request->tel2 . $request->tel3;

        Contact::create($contact);

        return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->Paginate(7);
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $contacts = Contact::with('category')
        ->KeywordSearch($request->keyword)
        ->GenderSearch($request->gender)
        ->CategorySearch($request->category_id)
        ->DateSearch($request->date)
        ->Paginate(7)
        ->appends($request->all());

        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function reset()
    {
        return redirect('/admin');
    }

    public function destroy($id)
    {
        Contact::find($id)->delete();
        return redirect('/admin')->with('message', '削除しました');
    }

    public function export(Request $request)
    {
        $contacts = Contact::with('category')
            ->KeywordSearch($request->keyword)
            ->GenderSearch($request->gender)
            ->CategorySearch($request->category_id)
            ->DateSearch($request->date)
            ->get();

        $headers = [
            'お名前',
            '性別',
            'メールアドレス',
            '電話番号',
            '住所',
            '建物名',
            'お問い合わせの種類',
            'お問い合わせ内容',
        ];

        return response()->streamDownload(function () use ($contacts, $headers) {
            $stream = fopen('php://output', 'w');

            fwrite($stream, "\xEF\xBB\xBF");

            fputcsv($stream, $headers);

            foreach ($contacts as $contact) {
                $row = [
                    $contact->last_name . ' ' . $contact->first_name,
                    $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->category->content,
                    $contact->detail,
                ];
                fputcsv($stream, $row);
            }

            fclose($stream);
        }, 'contacts.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
