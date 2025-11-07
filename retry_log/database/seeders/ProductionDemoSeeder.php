<?php

namespace Database\Seeders;

use App\Enums\ChallengeFrequency;
use App\Enums\ChallengeState;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Image;
use App\Models\Post;
use App\Models\Challenge;
use App\Models\ChallengeLog;
use App\Models\ChallengeStatus;
use App\Models\Comment;
use App\Models\ContentType;
use App\Models\Reaction;

class ProductionDemoSeeder extends Seeder
{
    public function run(): void
    {
        $iconIds = Image::pluck('id');
        $members = collect([
            ['name' => 'たろう',  'email' => 'taro@example.com', 'bio' => '朝活に取り組み中です！毎日コツコツ頑張ります。'],
            ['name' => 'はなこ',  'email' => 'hanako@example.com', 'bio' => '毎日筋トレを続けています💪 健康第一！'],
            ['name' => 'じゅん',  'email' => 'jun@example.com', 'bio' => '絵についての勉強をしています。デザインは奥深くて楽しいです🎨来月には依頼を受けられたらいいな'],
            ['name' => 'ゆうき',  'email' => 'yuki@example.com', 'bio' => '資格取得に向けて勉強中です📚 公認会計士を目指して日々精進！資格勉強仲間を募集中です'],
            ['name' => 'みさき',  'email' => 'misaki@example.com', 'bio' => '料理の腕を上げるために毎日新しいレシピに挑戦中🍳 美味しい料理で家族を笑顔にしたいです！'],
        ])->map(function ($user) use ($iconIds) {
            return User::updateOrCreate(
                ['email' => $user['email']],
                ['name' => $user['name'], 'password' => bcrypt('test-demo'), 'bio' => $user['bio'], 'icon_id' => $iconIds->random()],
            );
        });

        $taro   = $members->firstWhere('email', 'taro@example.com');
        $hanako = $members->firstWhere('email', 'hanako@example.com');
        $jun    = $members->firstWhere('email', 'jun@example.com');
        $yuki   = $members->firstWhere('email', 'yuki@example.com');
        $misaki = $members->firstWhere('email', 'misaki@example.com');

        $contentTypeIds = ContentType::pluck('id', 'name');
        $randomDate = Carbon::now()->addDays(rand(-365, 365))->setTime(rand(0, 23), rand(0, 59));
        $posts = [
            ['user_id' => $taro->id,   'content' => "朝活達成！継続は力なり💪", 'content_type_id' => $contentTypeIds['success']],
            ['user_id' => $hanako->id, 'content' => "筋トレ15日目！体が軽くなってきた気がする🏋️‍♀️", 'content_type_id' => $contentTypeIds['success']],
            ['user_id' => $jun->id,    'content' => "デザイン勉強しました。新しいテクニックを学んだ🎨", 'content_type_id' => $contentTypeIds['success']],
            ['user_id' => $yuki->id,   'content' => "資格勉強してきます！理解が深まってきた📚", 'content_type_id' => $contentTypeIds['success']],
            ['user_id' => $misaki->id, 'content' => "料理の新レシピ試してみた！家族に好評で嬉しい🍳", 'content_type_id' => $contentTypeIds['success']],
            ['user_id' => $misaki->id, 'content' => "ハンバーグの新しいレシピに挑戦中です🍳明日には実践できたらいいな", 'content_type_id' => $contentTypeIds['success']],
            ['user_id' => $taro->id,   'content' => "今日は寝坊しちゃいました💦気づいたら出かける時間だった…", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $hanako->id, 'content' => "筋トレ休みの日。体を休めるのも大事ですね😊", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $jun->id,    'content' => "デザインのインスピレーションが湧かない時は、自然の中を散歩すると良いかも🌳", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $yuki->id,   'content' => "今日は模擬試験を受けてきました！結果はまあまあかな…もっと頑張らないと💦", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $misaki->id, 'content' => "新しい料理本を買いました📖早速作ってみたけど失敗しちゃった", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $taro->id,   'content' => "ジョギングを初めてみた！朝の空気は澄んでいて気持ちが良い！30分しかできなかったけど、最初はそんなものです😂", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $hanako->id, 'content' => "筋トレ仲間ができた！一緒に頑張るとモチベーションが上がるね🔥今日はすぐ帰ってしまったので反省！", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $jun->id,    'content' => "デザインの勉強会に参加してきた。自分はまだまだなのでこれから頑張る！", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $yuki->id,   'content' => "今日は勉強の合間にリフレッシュでカフェに行ってきた☕️そのまま夜になっちゃった😂今から頑張るぞ〜！", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $misaki->id, 'content' => "家族に新しい料理を振る舞ったら大好評だった！やっぱり料理は愛情だなぁ❤️", 'content_type_id' => $contentTypeIds['success']],
            ['user_id' => $taro->id,   'content' => "朝のジョギングで新しいルートを発見！遠回りになったけど自然がいっぱいでリフレッシュできた🌳", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $hanako->id, 'content' => "新しいプロテインフレーバーに挑戦してみた🍓ちょっと甘すぎるかも…", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $jun->id,    'content' => "デザインのインスピレーションが湧かない時は、自然の中を散歩すると良いかも🌳", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $yuki->id,   'content' => "今日は模擬試験を受けてきました！結果はまあまあかな…もっと頑張らないと💦", 'content_type_id' => $contentTypeIds['fail']],
            ['user_id' => $misaki->id, 'content' => "新しい料理本を買いました📖早速作ってみたけど失敗しちゃった", 'content_type_id' => $contentTypeIds['fail']],

        ];
        $createdPosts = collect($posts)->map(
            fn($post) =>
            Post::firstOrCreate(['user_id' => $post['user_id'], 'content' => $post['content']], ['content_type_id' => $post['content_type_id'], 'created_at' => $randomDate],)
        );


        $challenges = [
            ['user_id' => $taro->id,   'title' => '毎朝10分コーディング', 'description' => 'どんな日でも最低10分は書く'],
            ['user_id' => $taro->id,   'title' => '週末ジョギング', 'description' => '週末に5km走る。新しいルートを試すのもOK'],
            ['user_id' => $taro->id,   'title' => '毎日朝活', 'description' => '毎朝30分早く起きて、読書や散歩など好きなことをする'],
            ['user_id' => $taro->id,   'title' => '筋トレ習慣化', 'description' => '週に3回は筋トレをする。ジムに行くのも自宅でやるのもOK'],
            ['user_id' => $taro->id,   'title' => '新しいレシピ挑戦', 'description' => '毎週新しい料理に挑戦してみる。家族や友人を招いて試食会も開催'],
            ['user_id' => $taro->id,   'title' => 'IT資格勉強習慣化', 'description' => '毎日30分は資格の勉強をする。過去問を解く日を設ける'],
            ['user_id' => $taro->id,   'title' => 'flutter学習', 'description' => '毎日少しずつでもflutterの勉強を進める。週末にまとめて学習するのもOK'],
            ['user_id' => $taro->id,   'title' => 'アルゴリズム問題解決', 'description' => '毎日1問はアルゴリズムの問題を解く。難しい問題にも挑戦してみる'],
            ['user_id' => $taro->id,   'title' => '技術ブログ執筆', 'description' => '毎週1記事は技術ブログを書く。学んだことや挑戦したことを共有する'],
            ['user_id' => $taro->id,   'title' => 'コードレビュー参加', 'description' => '毎週チームのコードレビューに積極的に参加する。フィードバックを活かして成長する'],
            ['user_id' => $hanako->id, 'title' => 'ジムに行く', 'description' => '毎日数分でもいいから体を動かす。ジムの新しいプログラムに挑戦'],
            ['user_id' => $hanako->id, 'title' => '週末ランニング', 'description' => '週末に5kmランニング。新しいコースを開拓するのもOK'],
            ['user_id' => $jun->id,    'title' => '週3でデザイン練習', 'description' => 'デッサンをメインに、色々なスタイルを試す。写真でもOK'],
            ['user_id' => $yuki->id,   'title' => '資格の勉強をする', 'description' => 'できない日があってもいいから、毎日少しずつ進める。過去問を解く日を設ける'],
            ['user_id' => $misaki->id, 'title' => '毎晩一品は手作りをする', 'description' => '夜ご飯に自炊をする習慣づけをする！小鉢でもいいので挑戦'],
            ['user_id' => $misaki->id, 'title' => '週末に新レシピ挑戦', 'description' => '毎週末に新しい料理に挑戦してみる。家族や友人を招いて試食会も開催'],
            ['user_id' => $taro->id,   'title' => '早起きチャレンジ', 'description' => '毎朝6時に起きて、朝の時間を有効活用する。読書や散歩など好きなことをする'],
            ['user_id' => $jun->id,    'title' => '毎日スケッチ', 'description' => '毎日少なくとも15分はスケッチをする。テーマを決めて描くのも良し、自由に描くのも良し'],
            ['user_id' => $yuki->id,   'title' => '毎日30分勉強', 'description' => '毎日少なくとも30分は資格の勉強をする。集中できる環境を整えることも大事'],
            ['user_id' => $hanako->id, 'title' => 'ヨガチャレンジ', 'description' => '毎日10分のヨガを行い、心と体のバランスを整える。新しいポーズにも挑戦してみる'],
        ];
        collect($challenges)->each(function ($c) use ($randomDate, $taro) {
            $randomNum = rand(1, 5);
            $startDate = Carbon::now()->addDays(rand(-365, 365))->setTime(rand(0, 23), rand(0, 59));
            $endDate = $endDate = (clone $startDate)->addDays(rand(1, 90))->setTime(rand(0, 23), rand(0, 59));
            $state = $endDate->isFuture()
                ? [ChallengeState::NOT_STARTED, ChallengeState::IN_PROGRESS][rand(0, 1)]
                : [ChallengeState::FAILED, ChallengeState::INTERRUPTED, ChallengeState::COMPLETED][rand(0, 2)];
            $frequencyTypes = [
                ChallengeFrequency::DAILY,
                ChallengeFrequency::WEEKLY,
                ChallengeFrequency::MONTHLY
            ];
            $challenge = Challenge::firstOrCreate(
                [
                    'user_id' => $c['user_id'],
                    'title' => $c['title'],
                    'description' => $c['description'],
                ],
                [
                    'state' => $state,
                    'frequency_type' => $frequencyTypes[array_rand($frequencyTypes)],
                    'frequency_goal' => $randomNum,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]
            );
            for ($i = 0; $i < rand(0, 20); $i++) {
                ChallengeLog::create([
                    'challenge_id' => $challenge->id,
                    'status_id' => ChallengeStatus::inRandomOrder()->value('id') ?? 1,
                    'logged_at' => (clone $startDate)->addDays(rand(0, 30))->setTime(rand(0, 23), rand(0, 59)),
                    'created_at' => Carbon::now()->subDays(rand(0, 60)),
                ]);
            }
            if ($challenge->user->id === $taro->id) {
                for ($extra = 0; $extra < 200; $extra++) {
                    ChallengeLog::create([
                        'challenge_id' => $challenge->id,
                        'status_id' => ChallengeStatus::inRandomOrder()->value('id') ?? 1,
                        'logged_at' => (clone $startDate)->addDays(rand(0, 30))->setTime(rand(0, 23), rand(0, 59)),
                        'created_at' => Carbon::now()->subDays(rand(0, 60)),
                    ]);
                }
            }
        });
        $comments = [
            ['user_id' => $hanako->id, 'post_id' => $createdPosts[0]->id, 'content' => "応援してるよ📣 一緒にがんばろう！"],
            ['user_id' => $jun->id,    'post_id' => $createdPosts[0]->id, 'content' => "継続こそ最強🔥"],
            ['user_id' => $yuki->id,   'post_id' => $createdPosts[1]->id, 'content' => "素晴らしい！体調管理も大事だね💪"],
            ['user_id' => $misaki->id, 'post_id' => $createdPosts[2]->id, 'content' => "新しいテクニック、ぜひシェアしてね🎨"],
            ['user_id' => $taro->id,   'post_id' => $createdPosts[3]->id, 'content' => "資格取得、応援してるよ📚"],
            ['user_id' => $hanako->id, 'post_id' => $createdPosts[4]->id, 'content' => "美味しそう！レシピ教えてほしいな🍳"],
            ['user_id' => $jun->id,    'post_id' => $createdPosts[5]->id, 'content' => "挑戦する姿勢が素敵です！応援してます😊"],
            ['user_id' => $yuki->id,   'post_id' => $createdPosts[6]->id, 'content' => "誰にでも失敗はあるよ！次はきっとうまくいくさ👍"],
        ];
        $types = [Post::class, Comment::class];
        $targetType = $types[array_rand($types)];
        $targetModel = $targetType::inRandomOrder()->first(); //緩衝材的な
        if (!$targetModel) {
            $targetType = Post::class;
            $targetModel = Post::inRandomOrder()->first();
        }
        $targetId = $targetModel?->id;
        $parentId = null;
        if ($targetType === Comment::class) {
            $parentId = Comment::inRandomOrder()->first()?->id;
        }
        $contentTypeId = ContentType::where('name', 'neutral')->value('id');
        collect($comments)->each(
            fn($c) =>
            Comment::firstOrCreate([
                'user_id' => $c['user_id'],
                'target_type' => $targetType,
                'target_id' => $targetId,
                'parent_id' => $parentId,
                'content' => $c['content'],
                'content_type_id' => $contentTypeId,
            ])
        );
        $this->call([
            ReactionsProductionSeeder::class,
            FollowsProductionSeeder::class,
        ]);
    }
}
