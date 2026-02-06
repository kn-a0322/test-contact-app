<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 日本語のお問い合わせ内容のサンプル
        $details = [
            '商品が届いていません。配送状況を確認していただけますでしょうか。',
            '注文した商品のサイズが合わなかったため、交換をお願いしたいです。',
            '商品に傷がついていました。返品または交換を希望します。',
            'ウェブサイトの使い方がわかりません。操作方法を教えてください。',
            '商品の在庫状況について教えてください。',
            '配送先の住所を変更したいのですが、可能でしょうか。',
            '領収書の発行をお願いしたいです。',
            '商品の色違いはありますか。カタログを送っていただけますか。',
            'キャンペーンの詳細について教えてください。',
            '会員登録の方法がわかりません。手順を教えてください。',
        ];

        return [
            'category_id' => $this->faker->numberBetween(1, 5),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->numberBetween(1, 3),
            'email' => $this->faker->safeEmail(),
            'tel' => $this->faker->numerify('##########'), 
            'address' => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
            'detail' => $this->faker->randomElement($details), // 日本語のサンプルからランダムに選択
        ];
    }
}
