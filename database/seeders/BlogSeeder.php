<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = BlogCategory::all();
        $tags = Tag::all();

        // Create blogs directory if not exists
        if (!Storage::disk('public')->exists('blogs')) {
            Storage::disk('public')->makeDirectory('blogs');
        }

        // Blog data organized by category theme
        $blogsByCategory = [
            // Technology category blogs
            'technology' => [
                ['az' => 'Süni İntellektin Gələcəyi: 2025-ci ildə Nələr Gözləyir?', 'en' => 'The Future of AI: What to Expect in 2025?', 'ru' => 'Будущее ИИ: Чего ожидать в 2025?'],
                ['az' => 'Kvant Kompüterləri və İnqilabi Dəyişikliklər', 'en' => 'Quantum Computers and Revolutionary Changes', 'ru' => 'Квантовые компьютеры и революционные изменения'],
                ['az' => '5G Texnologiyası: Sürət və İmkanlar', 'en' => '5G Technology: Speed and Possibilities', 'ru' => 'Технология 5G: Скорость и возможности'],
                ['az' => 'IoT: Əşyaların İnterneti və Gündəlik Həyat', 'en' => 'IoT: Internet of Things in Daily Life', 'ru' => 'IoT: Интернет вещей в повседневной жизни'],
                ['az' => 'Virtual Reallıq: Gələcəyin Texnologiyası', 'en' => 'Virtual Reality: Technology of the Future', 'ru' => 'Виртуальная реальность: Технология будущего'],
                ['az' => 'Blockchain və Kriptovalyutaların İnkişafı', 'en' => 'Blockchain and Cryptocurrency Development', 'ru' => 'Развитие блокчейна и криптовалют'],
                ['az' => 'Bulud Texnologiyaları: AWS vs Azure vs GCP', 'en' => 'Cloud Technologies: AWS vs Azure vs GCP', 'ru' => 'Облачные технологии: AWS vs Azure vs GCP'],
                ['az' => 'Edge Computing: Yeni Era', 'en' => 'Edge Computing: A New Era', 'ru' => 'Edge Computing: Новая эра'],
                ['az' => 'Metaverse: Virtual Dünyalara Giriş', 'en' => 'Metaverse: Entering Virtual Worlds', 'ru' => 'Метавселенная: Вход в виртуальные миры'],
                ['az' => 'Kibertəhlükəsizlik Trendləri 2025', 'en' => 'Cybersecurity Trends 2025', 'ru' => 'Тренды кибербезопасности 2025'],
            ],
            // Programming category blogs
            'programming' => [
                ['az' => 'Laravel 11: Yeni Xüsusiyyətlər və Təkmilləşdirmələr', 'en' => 'Laravel 11: New Features and Improvements', 'ru' => 'Laravel 11: Новые функции и улучшения'],
                ['az' => 'React vs Vue vs Angular: Müqayisə', 'en' => 'React vs Vue vs Angular: Comparison', 'ru' => 'React vs Vue vs Angular: Сравнение'],
                ['az' => 'TypeScript ilə Güclü Tip Sistemi', 'en' => 'Strong Type System with TypeScript', 'ru' => 'Строгая типизация с TypeScript'],
                ['az' => 'Node.js ilə Backend Development', 'en' => 'Backend Development with Node.js', 'ru' => 'Backend разработка с Node.js'],
                ['az' => 'Python: Maşın Öyrənməsinin Dili', 'en' => 'Python: The Language of Machine Learning', 'ru' => 'Python: Язык машинного обучения'],
                ['az' => 'Clean Code Prinsipləri və Tətbiqi', 'en' => 'Clean Code Principles and Application', 'ru' => 'Принципы чистого кода и применение'],
                ['az' => 'Git ilə Effektiv Version Kontrolu', 'en' => 'Effective Version Control with Git', 'ru' => 'Эффективный контроль версий с Git'],
                ['az' => 'Docker və Kubernetes: DevOps Əsasları', 'en' => 'Docker and Kubernetes: DevOps Basics', 'ru' => 'Docker и Kubernetes: Основы DevOps'],
                ['az' => 'API Dizayn: REST vs GraphQL', 'en' => 'API Design: REST vs GraphQL', 'ru' => 'Проектирование API: REST vs GraphQL'],
                ['az' => 'Microservices Arxitekturası: Üstünlüklər və Çətinliklər', 'en' => 'Microservices Architecture: Benefits and Challenges', 'ru' => 'Микросервисная архитектура: Преимущества и сложности'],
            ],
            // Design category blogs
            'design' => [
                ['az' => 'UI/UX Dizayn Trendləri 2025', 'en' => 'UI/UX Design Trends 2025', 'ru' => 'Тренды UI/UX дизайна 2025'],
                ['az' => 'Minimalist Web Dizayn Prinsipləri', 'en' => 'Minimalist Web Design Principles', 'ru' => 'Принципы минималистичного веб-дизайна'],
                ['az' => 'Dark Mode: Dizayn və İstifadəçi Təcrübəsi', 'en' => 'Dark Mode: Design and User Experience', 'ru' => 'Темный режим: Дизайн и пользовательский опыт'],
                ['az' => 'Responsive Dizayn: Hər Cihaz Üçün', 'en' => 'Responsive Design: For Every Device', 'ru' => 'Адаптивный дизайн: Для любого устройства'],
                ['az' => 'Figma ilə Prototipləmə və Dizayn', 'en' => 'Prototyping and Design with Figma', 'ru' => 'Прототипирование и дизайн в Figma'],
                ['az' => 'Rəng Psixologiyası Web Dizaynda', 'en' => 'Color Psychology in Web Design', 'ru' => 'Психология цвета в веб-дизайне'],
                ['az' => 'Typography: Şrift Seçimi və Tətbiqi', 'en' => 'Typography: Font Selection and Application', 'ru' => 'Типографика: Выбор и применение шрифтов'],
                ['az' => 'Motion Design və Mikro-animasiyalar', 'en' => 'Motion Design and Micro-animations', 'ru' => 'Motion дизайн и микроанимации'],
                ['az' => 'Design System Yaratmaq', 'en' => 'Creating a Design System', 'ru' => 'Создание дизайн-системы'],
                ['az' => 'Accessibility: Hamı Üçün Dizayn', 'en' => 'Accessibility: Design for Everyone', 'ru' => 'Доступность: Дизайн для всех'],
            ],
            // Startup category blogs
            'startup' => [
                ['az' => 'Startup İdeyasını Necə Doğrulamaq Olar?', 'en' => 'How to Validate Your Startup Idea?', 'ru' => 'Как проверить идею стартапа?'],
                ['az' => 'MVP: Minimum Viable Product Strategiyası', 'en' => 'MVP: Minimum Viable Product Strategy', 'ru' => 'MVP: Стратегия минимально жизнеспособного продукта'],
                ['az' => 'Startup Maliyyələşdirilməsi: Seed-dən Series A-ya', 'en' => 'Startup Funding: From Seed to Series A', 'ru' => 'Финансирование стартапа: От Seed до Series A'],
                ['az' => 'Product-Market Fit: Uğurun Açarı', 'en' => 'Product-Market Fit: The Key to Success', 'ru' => 'Product-Market Fit: Ключ к успеху'],
                ['az' => 'Growth Hacking Texnikaları', 'en' => 'Growth Hacking Techniques', 'ru' => 'Техники Growth Hacking'],
                ['az' => 'Startup Komandası Necə Qurulur?', 'en' => 'How to Build a Startup Team?', 'ru' => 'Как построить команду стартапа?'],
                ['az' => 'Pitch Deck Hazırlamaq: İnvestorları Cəlb Etmək', 'en' => 'Creating a Pitch Deck: Attracting Investors', 'ru' => 'Создание Pitch Deck: Привлечение инвесторов'],
                ['az' => 'SaaS Biznes Modeli', 'en' => 'SaaS Business Model', 'ru' => 'Бизнес-модель SaaS'],
                ['az' => 'Startup Uğursuzluqlarından Dərslər', 'en' => 'Lessons from Startup Failures', 'ru' => 'Уроки из неудач стартапов'],
                ['az' => 'Scaling: Böyümə Strategiyaları', 'en' => 'Scaling: Growth Strategies', 'ru' => 'Масштабирование: Стратегии роста'],
            ],
            // Career category blogs
            'career' => [
                ['az' => 'IT Sahəsində Karyera Qurmaq', 'en' => 'Building a Career in IT', 'ru' => 'Построение карьеры в IT'],
                ['az' => 'Remote İş: Üstünlüklər və Çətinliklər', 'en' => 'Remote Work: Benefits and Challenges', 'ru' => 'Удаленная работа: Преимущества и сложности'],
                ['az' => 'Texniki Müsahibəyə Hazırlıq', 'en' => 'Preparing for Technical Interviews', 'ru' => 'Подготовка к техническому интервью'],
                ['az' => 'Freelance vs Tam Zamanlı İş', 'en' => 'Freelance vs Full-time Employment', 'ru' => 'Фриланс vs Полная занятость'],
                ['az' => 'Soft Skills: Texniki Bacarıqlardan Əlavə', 'en' => 'Soft Skills: Beyond Technical Abilities', 'ru' => 'Soft Skills: Помимо технических навыков'],
                ['az' => 'Portfolio Necə Hazırlanmalı?', 'en' => 'How to Prepare a Portfolio?', 'ru' => 'Как подготовить портфолио?'],
                ['az' => 'Burnout: Peşəkar Tükənmə və Qarşısının Alınması', 'en' => 'Burnout: Professional Exhaustion and Prevention', 'ru' => 'Выгорание: Профессиональное истощение и профилактика'],
                ['az' => 'Networking: Peşəkar Əlaqələr Qurmaq', 'en' => 'Networking: Building Professional Connections', 'ru' => 'Нетворкинг: Построение профессиональных связей'],
                ['az' => 'Junior-dan Senior-a: İnkişaf Yolu', 'en' => 'From Junior to Senior: Development Path', 'ru' => 'От Junior до Senior: Путь развития'],
                ['az' => 'Tech Lead Olmaq: Rəhbərlik Bacarıqları', 'en' => 'Becoming a Tech Lead: Leadership Skills', 'ru' => 'Стать Tech Lead: Навыки лидерства'],
            ],
        ];

        $loremAz = '<p>Bu məqalədə texnologiya dünyasının ən son trendlərini və yeniliklərini kəşf edəcəksiniz. Müasir dövrün sürətli inkişafı fonunda özünüzü yeniliklərlə tanış etmək vacibdir.</p>
<h2>Əsas Məqamlar</h2>
<p>Texnologiya sahəsi daim dəyişir və inkişaf edir. Bu dəyişikliklərə uyğunlaşmaq üçün aşağıdakı məqamlara diqqət yetirmək lazımdır:</p>
<ul>
<li>Yeni texnologiyaları öyrənmək və tətbiq etmək</li>
<li>Sənaye trendlərini izləmək</li>
<li>Praktik təcrübə qazanmaq</li>
<li>Peşəkar cəmiyyətlərlə əlaqədə olmaq</li>
</ul>
<h2>Gələcək Perspektivləri</h2>
<p>Gələcəkdə bu sahədə daha çox yenilik gözlənilir. Süni intellekt, avtomatlaşdırma və rəqəmsal transformasiya prosesləri sürətlənəcək.</p>
<blockquote>Texnologiya gələcəyi formalaşdırır, amma onu formalaşdıranlar insanlardır.</blockquote>
<h2>Nəticə</h2>
<p>Bu məqalədəki məlumatları tətbiq edərək öz bilik və bacarıqlarınızı artıra bilərsiniz. Daimi öyrənmə uğurun əsas şərtidir.</p>';

        $loremEn = '<p>In this article, you will discover the latest trends and innovations in the world of technology. In the context of rapid development of the modern era, it is important to familiarize yourself with innovations.</p>
<h2>Key Points</h2>
<p>The technology field is constantly changing and evolving. To adapt to these changes, you need to pay attention to the following points:</p>
<ul>
<li>Learning and applying new technologies</li>
<li>Following industry trends</li>
<li>Gaining practical experience</li>
<li>Staying connected with professional communities</li>
</ul>
<h2>Future Perspectives</h2>
<p>More innovations are expected in this field in the future. Artificial intelligence, automation, and digital transformation processes will accelerate.</p>
<blockquote>Technology shapes the future, but it is people who shape technology.</blockquote>
<h2>Conclusion</h2>
<p>By applying the information in this article, you can improve your knowledge and skills. Continuous learning is the main condition for success.</p>';

        $loremRu = '<p>В этой статье вы откроете для себя последние тренды и инновации в мире технологий. В контексте быстрого развития современной эпохи важно знакомиться с новинками.</p>
<h2>Ключевые моменты</h2>
<p>Технологическая сфера постоянно меняется и развивается. Чтобы адаптироваться к этим изменениям, необходимо обратить внимание на следующие моменты:</p>
<ul>
<li>Изучение и применение новых технологий</li>
<li>Следование отраслевым тенденциям</li>
<li>Получение практического опыта</li>
<li>Поддержание связи с профессиональными сообществами</li>
</ul>
<h2>Перспективы на будущее</h2>
<p>В будущем в этой области ожидается больше инноваций. Процессы искусственного интеллекта, автоматизации и цифровой трансформации ускорятся.</p>
<blockquote>Технологии формируют будущее, но формируют технологии люди.</blockquote>
<h2>Заключение</h2>
<p>Применяя информацию из этой статьи, вы можете улучшить свои знания и навыки. Непрерывное обучение - главное условие успеха.</p>';

        $categoryKeys = ['technology', 'programming', 'design', 'startup', 'career'];
        $blogIndex = 0;
        $sliderIndex = 0;

        foreach ($categories as $catIndex => $category) {
            $categoryKey = $categoryKeys[$catIndex] ?? 'technology';
            $blogs = $blogsByCategory[$categoryKey] ?? $blogsByCategory['technology'];

            foreach ($blogs as $i => $blogData) {
                $isSlider = $sliderIndex < 5; // First 5 blogs across all categories are sliders
                $isFeatured = $i < 3; // First 3 in each category are featured

                // Download and save image from picsum
                $imagePath = $this->downloadImage($blogIndex);

                $blog = Blog::create([
                    'blog_category_id' => $category->id,
                    'image' => $imagePath,
                    'is_active' => true,
                    'is_featured' => $isFeatured,
                    'is_slider' => $isSlider,
                    'slider_order' => $isSlider ? $sliderIndex + 1 : 0,
                    'view' => rand(50, 2000),
                ]);

                $slugAz = Str::slug($blogData['az']) . '-' . $blog->id;
                $slugEn = Str::slug($blogData['en']) . '-' . $blog->id;
                $slugRu = Str::slug($blogData['ru']) . '-' . $blog->id;

                // Azerbaijani
                $blog->translateOrNew('az')->title = $blogData['az'];
                $blog->translateOrNew('az')->short_description = $this->generateShortDesc($blogData['az'], 'az');
                $blog->translateOrNew('az')->description = $loremAz;
                $blog->translateOrNew('az')->slug = $slugAz;
                $blog->translateOrNew('az')->meta_title = $blogData['az'];
                $blog->translateOrNew('az')->meta_description = $this->generateShortDesc($blogData['az'], 'az');
                $blog->translateOrNew('az')->img_alt = $blogData['az'];
                $blog->translateOrNew('az')->img_title = $blogData['az'];

                // English
                $blog->translateOrNew('en')->title = $blogData['en'];
                $blog->translateOrNew('en')->short_description = $this->generateShortDesc($blogData['en'], 'en');
                $blog->translateOrNew('en')->description = $loremEn;
                $blog->translateOrNew('en')->slug = $slugEn;
                $blog->translateOrNew('en')->meta_title = $blogData['en'];
                $blog->translateOrNew('en')->meta_description = $this->generateShortDesc($blogData['en'], 'en');
                $blog->translateOrNew('en')->img_alt = $blogData['en'];
                $blog->translateOrNew('en')->img_title = $blogData['en'];

                // Russian
                $blog->translateOrNew('ru')->title = $blogData['ru'];
                $blog->translateOrNew('ru')->short_description = $this->generateShortDesc($blogData['ru'], 'ru');
                $blog->translateOrNew('ru')->description = $loremRu;
                $blog->translateOrNew('ru')->slug = $slugRu;
                $blog->translateOrNew('ru')->meta_title = $blogData['ru'];
                $blog->translateOrNew('ru')->meta_description = $this->generateShortDesc($blogData['ru'], 'ru');
                $blog->translateOrNew('ru')->img_alt = $blogData['ru'];
                $blog->translateOrNew('ru')->img_title = $blogData['ru'];

                $blog->save();

                // Attach random tags (2-4 tags per blog)
                if ($tags->count() > 0) {
                    $randomTags = $tags->random(min(rand(2, 4), $tags->count()));
                    $blog->tags()->attach($randomTags->pluck('id'));
                }

                $blogIndex++;
                if ($isSlider) $sliderIndex++;

                $this->command->info("Created blog: {$blogData['en']}");
            }
        }

        $this->command->info("Total blogs created: {$blogIndex}");
    }

    private function downloadImage(int $index): ?string
    {
        try {
            // Use picsum with seed for consistent futuristic-looking images
            $seeds = [
                'tech', 'code', 'future', 'digital', 'cyber', 'neon', 'space', 'data', 'ai', 'robot',
                'circuit', 'network', 'cloud', 'server', 'matrix', 'binary', 'pixel', 'chip', 'cpu', 'gpu',
                'laptop', 'screen', 'monitor', 'keyboard', 'mouse', 'phone', 'tablet', 'vr', 'ar', 'hologram',
                'startup', 'office', 'team', 'meeting', 'coffee', 'desk', 'workspace', 'creative', 'idea', 'innovation',
                'design', 'color', 'palette', 'brush', 'pencil', 'sketch', 'wireframe', 'mockup', 'prototype', 'ui'
            ];

            $seed = $seeds[$index % count($seeds)] . $index;
            $imageUrl = "https://picsum.photos/seed/{$seed}/800/500";

            $imageContent = @file_get_contents($imageUrl);

            if ($imageContent === false) {
                $this->command->warn("Could not download image for blog {$index}");
                return null;
            }

            $filename = 'blogs/blog_' . time() . '_' . $index . '.jpg';
            Storage::disk('public')->put($filename, $imageContent);

            return $filename;
        } catch (\Exception $e) {
            $this->command->warn("Error downloading image: " . $e->getMessage());
            return null;
        }
    }

    private function generateShortDesc(string $title, string $locale): string
    {
        $descriptions = [
            'az' => [
                'Bu məqalədə ' . mb_strtolower($title) . ' mövzusunu ətraflı araşdırırıq.',
                $title . ' - müasir texnologiya dünyasının ən aktual mövzularından biri.',
                'Gəlin birlikdə ' . mb_strtolower($title) . ' haqqında daha çox öyrənək.',
            ],
            'en' => [
                'In this article, we explore the topic of ' . strtolower($title) . ' in detail.',
                $title . ' - one of the most relevant topics in modern technology.',
                'Let\'s learn more about ' . strtolower($title) . ' together.',
            ],
            'ru' => [
                'В этой статье мы подробно рассмотрим тему: ' . mb_strtolower($title) . '.',
                $title . ' - одна из самых актуальных тем в современных технологиях.',
                'Давайте вместе узнаем больше о теме: ' . mb_strtolower($title) . '.',
            ],
        ];

        return $descriptions[$locale][array_rand($descriptions[$locale])];
    }
}
