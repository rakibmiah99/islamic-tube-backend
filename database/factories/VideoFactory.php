<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{

    protected $model = Video::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $thumnail = [
        'https://img.freepik.com/free-vector/gradient-islamic-new-year-youtube-thumbnail_23-2149429102.jpg',
        "https://d1csarkz8obe9u.cloudfront.net/posterpreviews/islam-youtube-thumbnail-design-template-4ea851fba91e7f283b3578424b1b9a22_screen.jpg?ts=1686473333",
        "https://img.freepik.com/free-vector/youtube-thumbnail-islamic-new-year-celebration_23-2150504824.jpg",
        "https://static.vecteezy.com/system/resources/previews/035/380/973/non_2x/ai-generated-an-extravagant-brown-and-gold-background-with-intricate-geometric-designs-free-photo.jpg",
        "https://img.freepik.com/premium-photo/youtube-thumbnail-islamic-new-year-celebration_960396-246822.jpg",
        "https://thumbs.dreamstime.com/b/beautiful-high-quality-youtube-thumbnail-islamic-themed-background-featuring-serene-mosque-design-ideal-islamic-340010501.jpg",
        "https://thumbs.dreamstime.com/b/beautiful-high-quality-youtube-thumbnail-islamic-themed-background-featuring-serene-mosque-design-ideal-islamic-340010294.jpg",
        "https://thumbs.dreamstime.com/b/islamic-themed-youtube-thumbnail-modern-traditional-elements-engaging-backgrounds-beautiful-high-quality-youtube-340010798.jpg",
        "https://thumbs.dreamstime.com/b/islamic-themed-youtube-thumbnail-modern-traditional-elements-engaging-backgrounds-beautiful-high-quality-youtube-340009891.jpg",
        "https://thumbs.dreamstime.com/b/islamic-themed-youtube-thumbnail-modern-traditional-elements-engaging-backgrounds-beautiful-high-quality-youtube-340012412.jpg",
        "https://thumbs.dreamstime.com/b/islamic-themed-youtube-thumbnail-modern-traditional-elements-engaging-backgrounds-beautiful-high-quality-youtube-340012414.jpg",
        "https://thumbs.dreamstime.com/b/islamic-themed-youtube-thumbnail-modern-traditional-elements-engaging-backgrounds-beautiful-high-quality-youtube-340012415.jpg",
        "https://static.vecteezy.com/system/resources/previews/054/182/615/non_2x/eid-al-fitr-sale-banner-islamic-ornamental-background-ramadan-sale-social-media-post-with-empty-space-for-photo-vector.jpg",
        "https://i.pinimg.com/736x/a6/4e/02/a64e02fb3af96d623dc62f55c384c604.jpg",
        "https://i.pinimg.com/736x/ea/8e/ef/ea8eefcc6a49e0552b2aafab9091cde7.jpg",
        "https://img.freepik.com/premium-vector/youtube-thumbnail-islamic-new-year-celebration_23-2150428737.jpg"
    ];


    protected $title_and_url = [
        [
            "title" =>   "আবেগময় কণ্ঠে সূরা আল মুজাম্মিল - রাতের ইবাদত ( তাহাজ্জুদ ) ",
            "url" => 'https://www.youtube.com/watch?v=HRgCUHLyzRA'
        ],
        [
            "title" => "সূরা আল ফুরকান (سورة الفرقان) - সত্য মিথ্যার পার্থক্য নির্ধারণকারী",
            "url" => 'https://www.youtube.com/watch?v=fRaURh6Fjq4'
        ],
        [
            "title" =>   "যে ৩ টি আমল আপনার আত্মাকে পরিশুদ্ধ করে দিবে।",
            "url" => 'https://www.youtube.com/watch?v=RKCRtX8ECdg'
        ],
        [
            "title" =>    "এ আলোচনাটি আপনার নামাজ সম্পর্কে ধারণা বদলে দিতে পারে!",
            "url" => 'https://www.youtube.com/watch?v=xCkTu7LVCEE'
        ],
        [
            "title" =>   "যে আমল করলে আল্লাহ হেসে দেন, ১০টি গুরুত্বপূর্ণ",
            "url" => 'https://www.youtube.com/watch?v=KvtR_kokW04'
        ],
        [
            "title" =>   "পৃথিবীর শ্রেষ্ঠ ৬টা দেয়া ও জিকির। কখনো মিস করবেন না",
            "url" => 'https://www.youtube.com/watch?v=zoOpDdCeDZ8'
        ],
        [
            "title" =>   "বিপদের পরিক্ষিত ৪টি দোয়া,পড়লে আল্লাহর গায়েবী সাহায্য পাবেন",
            "url" => 'https://www.youtube.com/watch?v=z-Wr8wVgCsA'
        ],
        [
            "title" =>   "প্রতিদিন সকালে ওজু থাকুক আর না থাকুক এ ৩টি আমল করুন, হাতেনাতে ফল পাবেন",
            "url" => 'https://www.youtube.com/watch?v=ROeP4Ys8zyA'
        ],
        [
            "title" =>   " সূরা মারইয়াম (سورة مريم) - হৃদয় স্পর্শী কুরআন তেলাওয়াত ",
            "url" => 'https://www.youtube.com/watch?v=zKzYdpbVtCI'
        ],
        [
            "title" =>   "সূরা মুলকের স্বর্গীয় কোরআন তেলাওয়াত",
            "url" => 'https://www.youtube.com/watch?v=KGUUWufvu6E'
        ],
        [
            "title" =>   "সূরা আল কাহফ ( الكهف) আবেগময় তেলাওয়াত ",
            "url" => 'https://www.youtube.com/watch?v=Rjo1MueB6-I'
        ],
        [
            "title" =>   "সূরা আল মুমিনূন - হৃদয়গ্রাহী তেলাওয়াত",
            "url" => 'https://www.youtube.com/watch?v=n3-Ri8SKre4'
        ],
    ];



    public function definition(): array
    {
        $get_title_and_url = fake()->randomElement($this->title_and_url);
        return [
            'title' => $get_title_and_url['title'],
            'video_url' => $get_title_and_url['url'],
            'thumbnail' => fake()->randomElement($this->thumnail),
            'long_description' => fake()->sentence(300),
            'provider' => 'youtube',
            'slug' => fake()->slug,
            'published_at' => fake()->dateTime,
        ];
    }
}
