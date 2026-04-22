<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = BlogCategory::pluck('id')->toArray();

        $blogs = [
            [
                'az' => ['title' => 'Süni İntellektin Gələcəyi: 2025-ci ildə Nələr Gözləyir?', 'short' => 'Süni intellekt texnologiyaları sürətlə inkişaf edir. 2025-ci ildə bizi hansı yeniliklər gözləyir?'],
                'en' => ['title' => 'The Future of AI: What to Expect in 2025?', 'short' => 'AI technologies are rapidly evolving. What innovations await us in 2025?'],
            ],
            [
                'az' => ['title' => 'Web Dizaynda Minimalizm Trendi', 'short' => 'Sadəlik gözəllikdir. Minimalist web dizaynın üstünlükləri və tətbiqi haqqında.'],
                'en' => ['title' => 'Minimalism Trend in Web Design', 'short' => 'Simplicity is beauty. About the advantages and application of minimalist web design.'],
            ],
            [
                'az' => ['title' => 'Laravel 11: Yeni Xüsusiyyətlər', 'short' => 'Laravel 11 ilə gələn yeniliklər və təkmilləşdirmələr haqqında ətraflı məlumat.'],
                'en' => ['title' => 'Laravel 11: New Features', 'short' => 'Detailed information about innovations and improvements coming with Laravel 11.'],
            ],
            [
                'az' => ['title' => 'React vs Vue: Hansını Seçməli?', 'short' => 'Frontend framework seçimi çətindir. React və Vue müqayisəsi.'],
                'en' => ['title' => 'React vs Vue: Which One to Choose?', 'short' => 'Choosing a frontend framework is difficult. Comparison of React and Vue.'],
            ],
            [
                'az' => ['title' => 'Uzaqdan İş: Effektiv Strategiyalar', 'short' => 'Evdən işləyərkən məhsuldar olmaq üçün praktik məsləhətlər.'],
                'en' => ['title' => 'Remote Work: Effective Strategies', 'short' => 'Practical tips for staying productive while working from home.'],
            ],
            [
                'az' => ['title' => 'TypeScript ilə Daha Təhlükəsiz Kod', 'short' => 'TypeScript JavaScript-ə tip təhlükəsizliyi əlavə edir. Niyə keçməlisiniz?'],
                'en' => ['title' => 'Safer Code with TypeScript', 'short' => 'TypeScript adds type safety to JavaScript. Why should you switch?'],
            ],
            [
                'az' => ['title' => 'UI/UX Dizayn Prinsipləri', 'short' => 'İstifadəçi təcrübəsini yaxşılaşdırmaq üçün əsas dizayn prinsipləri.'],
                'en' => ['title' => 'UI/UX Design Principles', 'short' => 'Key design principles to improve user experience.'],
            ],
            [
                'az' => ['title' => 'Docker ilə Development Mühiti', 'short' => 'Docker konteynerləri ilə stabil development mühiti yaratmaq.'],
                'en' => ['title' => 'Development Environment with Docker', 'short' => 'Creating a stable development environment with Docker containers.'],
            ],
            [
                'az' => ['title' => 'API Dizayn Best Practices', 'short' => 'RESTful API dizaynında ən yaxşı təcrübələr və standartlar.'],
                'en' => ['title' => 'API Design Best Practices', 'short' => 'Best practices and standards in RESTful API design.'],
            ],
            [
                'az' => ['title' => 'Kibertəhlükəsizlik Əsasları', 'short' => 'Onlayn təhlükəsizliyinizi qorumaq üçün bilməli olduğunuz əsaslar.'],
                'en' => ['title' => 'Cybersecurity Basics', 'short' => 'Basics you need to know to protect your online security.'],
            ],
            [
                'az' => ['title' => 'Machine Learning Başlanğıc', 'short' => 'Maşın öyrənməsinə başlamaq istəyənlər üçün bələdçi.'],
                'en' => ['title' => 'Getting Started with Machine Learning', 'short' => 'A guide for those who want to get started with machine learning.'],
            ],
            [
                'az' => ['title' => 'Git ilə Version Kontrolu', 'short' => 'Git əsasları və effektiv branching strategiyaları.'],
                'en' => ['title' => 'Version Control with Git', 'short' => 'Git basics and effective branching strategies.'],
            ],
            [
                'az' => ['title' => 'Responsive Dizayn Texnikaları', 'short' => 'Bütün cihazlarda mükəmməl görünən saytlar yaratmaq.'],
                'en' => ['title' => 'Responsive Design Techniques', 'short' => 'Creating websites that look perfect on all devices.'],
            ],
            [
                'az' => ['title' => 'Cloud Computing Əsasları', 'short' => 'Bulud hesablama nədir və niyə vacibdir?'],
                'en' => ['title' => 'Cloud Computing Basics', 'short' => 'What is cloud computing and why is it important?'],
            ],
            [
                'az' => ['title' => 'Agile Metodologiya', 'short' => 'Çevik layihə idarəetməsi prinsipləri və Scrum.'],
                'en' => ['title' => 'Agile Methodology', 'short' => 'Agile project management principles and Scrum.'],
            ],
            [
                'az' => ['title' => 'Database Optimallaşdırma', 'short' => 'SQL sorğularını sürətləndirmək üçün praktik üsullar.'],
                'en' => ['title' => 'Database Optimization', 'short' => 'Practical methods to speed up SQL queries.'],
            ],
            [
                'az' => ['title' => 'Mobil App Development Trendləri', 'short' => '2025-ci ildə mobil tətbiq inkişafında əsas trendlər.'],
                'en' => ['title' => 'Mobile App Development Trends', 'short' => 'Key trends in mobile app development in 2025.'],
            ],
            [
                'az' => ['title' => 'JavaScript ES2024 Yenilikləri', 'short' => 'JavaScript-in ən son versiyasında gələn yeniliklər.'],
                'en' => ['title' => 'JavaScript ES2024 Updates', 'short' => 'Updates coming in the latest version of JavaScript.'],
            ],
            [
                'az' => ['title' => 'Clean Code Prinsipləri', 'short' => 'Oxunaqlı və saxlanıla bilən kod yazmaq üçün prinsiplər.'],
                'en' => ['title' => 'Clean Code Principles', 'short' => 'Principles for writing readable and maintainable code.'],
            ],
            [
                'az' => ['title' => 'DevOps Mədəniyyəti', 'short' => 'Development və Operations komandalarının birləşməsi.'],
                'en' => ['title' => 'DevOps Culture', 'short' => 'The merger of Development and Operations teams.'],
            ],
            [
                'az' => ['title' => 'Blockchain Texnologiyası', 'short' => 'Blockchain necə işləyir və harada istifadə olunur?'],
                'en' => ['title' => 'Blockchain Technology', 'short' => 'How does blockchain work and where is it used?'],
            ],
            [
                'az' => ['title' => 'PWA: Progressive Web Apps', 'short' => 'Web tətbiqlərini mobil tətbiq kimi işlətmək.'],
                'en' => ['title' => 'PWA: Progressive Web Apps', 'short' => 'Running web applications like mobile apps.'],
            ],
            [
                'az' => ['title' => 'Figma ilə Prototipləmə', 'short' => 'Figma istifadə edərək interaktiv prototiplər yaratmaq.'],
                'en' => ['title' => 'Prototyping with Figma', 'short' => 'Creating interactive prototypes using Figma.'],
            ],
            [
                'az' => ['title' => 'SEO Əsasları Developerlar Üçün', 'short' => 'Developerların bilməli olduğu SEO texnikaları.'],
                'en' => ['title' => 'SEO Basics for Developers', 'short' => 'SEO techniques that developers should know.'],
            ],
            [
                'az' => ['title' => 'Microservices Arxitekturası', 'short' => 'Monolit arxitekturadan microservices-ə keçid.'],
                'en' => ['title' => 'Microservices Architecture', 'short' => 'Transitioning from monolithic architecture to microservices.'],
            ],
        ];

        $loremAz = '<p>Bu məqalədə ətraflı məlumat əldə edəcəksiniz. Texnologiya dünyası sürətlə dəyişir və bu dəyişikliklərə uyğunlaşmaq vacibdir.</p>
<h2>Əsas Məqamlar</h2>
<p>Müasir dünyada texnologiya bilikləri hər kəs üçün vacibdir. Bu sahədə özünüzü inkişaf etdirmək karyeranız üçün böyük üstünlük təmin edəcək.</p>
<p>Aşağıdakı məqamları nəzərə almaq lazımdır:</p>
<ul>
<li>Daimi öyrənmə və inkişaf</li>
<li>Praktik təcrübə qazanmaq</li>
<li>Cəmiyyətlə əlaqədə olmaq</li>
</ul>
<h2>Nəticə</h2>
<p>Texnologiya sahəsində uğur qazanmaq üçün davamlı öyrənmə şərtdir. Bu məqalədəki məsləhətləri tətbiq edərək öz bacarıqlarınızı artıra bilərsiniz.</p>';

        $loremEn = '<p>In this article, you will gain detailed information. The world of technology is changing rapidly and it is important to adapt to these changes.</p>
<h2>Key Points</h2>
<p>Technology skills are important for everyone in the modern world. Developing yourself in this field will provide a great advantage for your career.</p>
<p>The following points should be considered:</p>
<ul>
<li>Continuous learning and development</li>
<li>Gaining practical experience</li>
<li>Staying connected with the community</li>
</ul>
<h2>Conclusion</h2>
<p>Continuous learning is essential for success in technology. You can improve your skills by applying the tips in this article.</p>';

        foreach ($blogs as $i => $blogData) {
            $blog = Blog::create([
                'blog_category_id' => $categoryIds[array_rand($categoryIds)],
                'is_active' => true,
                'is_featured' => $i < 3, // First 3 are featured
                'view' => rand(10, 500),
            ]);

            $slugAz = Str::slug($blogData['az']['title']);
            $slugEn = Str::slug($blogData['en']['title']);

            $blog->translateOrNew('az')->title = $blogData['az']['title'];
            $blog->translateOrNew('az')->short_description = $blogData['az']['short'];
            $blog->translateOrNew('az')->description = $loremAz;
            $blog->translateOrNew('az')->slug = $slugAz;
            $blog->translateOrNew('az')->meta_title = $blogData['az']['title'];
            $blog->translateOrNew('az')->meta_description = $blogData['az']['short'];

            $blog->translateOrNew('en')->title = $blogData['en']['title'];
            $blog->translateOrNew('en')->short_description = $blogData['en']['short'];
            $blog->translateOrNew('en')->description = $loremEn;
            $blog->translateOrNew('en')->slug = $slugEn;
            $blog->translateOrNew('en')->meta_title = $blogData['en']['title'];
            $blog->translateOrNew('en')->meta_description = $blogData['en']['short'];

            $blog->save();
        }
    }
}
