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
        $contact['tel'] = $contact['tel1']  . $contact['tel2'] .  $contact['tel3'];

        $category = Category::find($request->category_id);
        
        if($category) {
            $contact['category_name'] = $category->content;
        }else{
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
        ->Paginate(7)
        ->appends($request->all()); // 検索パラメータをページネーションリンクに追加

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
        // 検索条件を適用してデータを取得
        $contacts = Contact::with('category')
            ->KeywordSearch($request->keyword)
            ->GenderSearch($request->gender)
            ->CategorySearch($request->category_id)
            ->DateSearch($request->date)
            ->get(); // 全件取得（ページネーションなし）

        // CSVファイルのヘッダー（項目名）
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

        // CSVファイルを生成してダウンロード
        return response()->streamDownload(function () use ($contacts, $headers) {
            // 出力用のファイルハンドルを開く
            $stream = fopen('php://output', 'w');
            
            // BOM（Byte Order Mark）を追加（Excelで文字化けを防ぐ）
            fwrite($stream, "\xEF\xBB\xBF");
            
            // ヘッダー行を出力
            fputcsv($stream, $headers);
            
            // データ行を出力
            foreach ($contacts as $contact) {
                $row = [
                    $contact->last_name . ' ' . $contact->first_name, // お名前
                    $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'), // 性別
                    $contact->email, // メールアドレス
                    $contact->tel, // 電話番号
                    $contact->address, // 住所
                    $contact->building, // 建物名
                    $contact->category->content, // お問い合わせの種類
                    $contact->detail, // お問い合わせ内容
                ];
                fputcsv($stream, $row);
            }
            
            fclose($stream);
        }, 'contacts.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
