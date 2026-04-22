<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\ContactItem;
use App\Models\Image;
use App\Models\Setting;
use App\Models\Single;
use App\Models\Social;
use App\Models\Tag;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        $this->createRolesAndPermissions();
        $this->createAdminUser();
        $this->createBlogCategories();
        $this->createTags();
        $this->createSocials();
        $this->createContactItems();
        $this->createSingles();
        $this->createSettings();
        $this->createWords();
    }

    private function createRolesAndPermissions(): void
    {
        // All permission modules
        $modules = [
            'blogs', 'categories', 'tags', 'users', 'roles', 'permissions',
            'translates', 'singles', 'images', 'socials', 'contacts', 'contact_lists',
            'sliders', 'sections', 'faqs', 'features', 'partners', 'projects',
            'services', 'service_categories', 'products', 'product_categories', 'product_features',
            'abouts', 'advantages', 'benefits', 'integrations', 'steps', 'support_items',
            'target-audiences', 'footer_pages', 'order_service',
        ];

        $permissions = [];
        foreach ($modules as $module) {
            $permissions[] = "list-{$module}";
            $permissions[] = "create-{$module}";
            $permissions[] = "edit-{$module}";
            $permissions[] = "delete-{$module}";
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create admin role with all permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        // Create editor role with limited permissions
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorRole->syncPermissions([
            'list-blogs', 'create-blogs', 'edit-blogs',
            'list-categories', 'list-tags', 'list-translates',
        ]);
    }

    private function createAdminUser(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');
    }

    private function createBlogCategories(): void
    {
        $categories = [
            [
                'az' => ['name' => 'Texnologiya', 'slug' => 'texnologiya'],
                'en' => ['name' => 'Technology', 'slug' => 'technology'],
                'ru' => ['name' => 'Технологии', 'slug' => 'tekhnologii'],
                'order' => 1, 'show_on_home' => true
            ],
            [
                'az' => ['name' => 'Proqramlaşdırma', 'slug' => 'proqramlasdirma'],
                'en' => ['name' => 'Programming', 'slug' => 'programming'],
                'ru' => ['name' => 'Программирование', 'slug' => 'programmirovanie'],
                'order' => 2, 'show_on_home' => true
            ],
            [
                'az' => ['name' => 'Dizayn', 'slug' => 'dizayn'],
                'en' => ['name' => 'Design', 'slug' => 'design'],
                'ru' => ['name' => 'Дизайн', 'slug' => 'dizain'],
                'order' => 3, 'show_on_home' => true
            ],
            [
                'az' => ['name' => 'Startup', 'slug' => 'startup'],
                'en' => ['name' => 'Startup', 'slug' => 'startup'],
                'ru' => ['name' => 'Стартап', 'slug' => 'startap'],
                'order' => 4, 'show_on_home' => true
            ],
            [
                'az' => ['name' => 'Karyera', 'slug' => 'karyera'],
                'en' => ['name' => 'Career', 'slug' => 'career'],
                'ru' => ['name' => 'Карьера', 'slug' => 'karera'],
                'order' => 5, 'show_on_home' => false
            ],
        ];

        foreach ($categories as $cat) {
            $category = BlogCategory::firstOrCreate(
                ['order' => $cat['order']],
                [
                    'status' => true,
                    'show_on_home' => $cat['show_on_home'],
                    'home_order' => $cat['order'],
                ]
            );

            // Always update translations to ensure they're correct
            foreach (['az', 'en', 'ru'] as $locale) {
                $category->translateOrNew($locale)->name = $cat[$locale]['name'];
                $category->translateOrNew($locale)->slug = $cat[$locale]['slug'];
            }
            $category->save();
        }
    }

    private function createTags(): void
    {
        $tags = [
            'Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 'CSS', 'UI/UX', 'AI',
        ];

        foreach ($tags as $tagName) {
            $slug = \Str::slug($tagName);

            // Check if tag with this slug already exists
            $existingTag = Tag::whereHas('translations', function($q) use ($slug) {
                $q->where('slug', $slug);
            })->first();

            if (!$existingTag) {
                $tag = Tag::create([]);
                $tag->translateOrNew('az')->title = $tagName;
                $tag->translateOrNew('az')->slug = $slug;
                $tag->translateOrNew('en')->title = $tagName;
                $tag->translateOrNew('en')->slug = $slug;
                $tag->translateOrNew('ru')->title = $tagName;
                $tag->translateOrNew('ru')->slug = $slug;
                $tag->save();
            }
        }
    }

    private function createSocials(): void
    {
        // Socials should be added via admin panel with proper icons
        // This seeder skips social creation to avoid icon column size issues
    }

    private function createContactItems(): void
    {
        // Contact items should be added via admin panel
        // Skipping due to icon column size limitation
    }

    private function createSingles(): void
    {
        $singles = [
            [
                'type' => 'home',
                'az' => ['title' => 'Ana Səhifə', 'seo_title' => 'Ana Səhifə', 'seo_description' => 'Texnologiya, proqramlaşdırma və dizayn haqqında ən son məqalələr'],
                'en' => ['title' => 'Home', 'seo_title' => 'Home', 'seo_description' => 'Latest articles about technology, programming and design'],
                'ru' => ['title' => 'Главная', 'seo_title' => 'Главная', 'seo_description' => 'Последние статьи о технологиях, программировании и дизайне'],
            ],
            [
                'type' => 'blogs',
                'az' => ['title' => 'Bloq', 'seo_title' => 'Bloq', 'seo_description' => 'Bütün blog yazıları'],
                'en' => ['title' => 'Blog', 'seo_title' => 'Blog', 'seo_description' => 'All blog posts'],
                'ru' => ['title' => 'Блог', 'seo_title' => 'Блог', 'seo_description' => 'Все статьи блога'],
            ],
            [
                'type' => 'contact',
                'az' => ['title' => 'Əlaqə', 'seo_title' => 'Əlaqə', 'seo_description' => 'Bizimlə əlaqə saxlayın'],
                'en' => ['title' => 'Contact', 'seo_title' => 'Contact', 'seo_description' => 'Get in touch with us'],
                'ru' => ['title' => 'Контакты', 'seo_title' => 'Контакты', 'seo_description' => 'Свяжитесь с нами'],
            ],
        ];

        foreach ($singles as $singleData) {
            $single = Single::firstOrCreate(['type' => $singleData['type']]);

            if (!$single->translate('az')) {
                $single->translateOrNew('az')->title = $singleData['az']['title'];
                $single->translateOrNew('az')->slug = $singleData['type'];
                $single->translateOrNew('az')->seo_title = $singleData['az']['seo_title'];
                $single->translateOrNew('az')->seo_description = $singleData['az']['seo_description'];
                $single->translateOrNew('en')->title = $singleData['en']['title'];
                $single->translateOrNew('en')->slug = $singleData['type'];
                $single->translateOrNew('en')->seo_title = $singleData['en']['seo_title'];
                $single->translateOrNew('en')->seo_description = $singleData['en']['seo_description'];
                $single->translateOrNew('ru')->title = $singleData['ru']['title'];
                $single->translateOrNew('ru')->slug = $singleData['type'];
                $single->translateOrNew('ru')->seo_title = $singleData['ru']['seo_title'];
                $single->translateOrNew('ru')->seo_description = $singleData['ru']['seo_description'];
                $single->save();
            }
        }
    }

    private function createSettings(): void
    {
        $settings = [
            'site_name' => 'TechBlog',
            'site_description' => 'Texnologiya və Proqramlaşdırma Bloqu',
            'contact_email' => 'info@example.com',
            'contact_phone' => '+994 XX XXX XX XX',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }

    private function createWords(): void
    {
        $wordsData = [
            // Navigation
            'nav_home' => ['az' => 'Ana Səhifə', 'en' => 'Home', 'ru' => 'Главная'],
            'nav_contact' => ['az' => 'Əlaqə', 'en' => 'Contact', 'ru' => 'Контакты'],
            'nav_blogs' => ['az' => 'Bloq', 'en' => 'Blog', 'ru' => 'Блог'],

            // Common
            'read_more' => ['az' => 'Daha çox oxu', 'en' => 'Read more', 'ru' => 'Читать далее'],
            'more' => ['az' => 'Daha çox', 'en' => 'More', 'ru' => 'Ещё'],
            'all' => ['az' => 'Hamısı', 'en' => 'All', 'ru' => 'Все'],
            'loading' => ['az' => 'Yüklənir...', 'en' => 'Loading...', 'ru' => 'Загрузка...'],
            'back_to_home' => ['az' => 'Ana səhifəyə qayıt', 'en' => 'Back to home', 'ru' => 'Вернуться на главную'],

            // Blog
            'views' => ['az' => 'Baxış', 'en' => 'Views', 'ru' => 'Просмотров'],
            'views_short' => ['az' => 'Baxış', 'en' => 'Views', 'ru' => 'Просм.'],
            'latest_posts' => ['az' => 'Son Yazılar', 'en' => 'Latest Posts', 'ru' => 'Последние статьи'],
            'related_posts' => ['az' => 'Oxşar Yazılar', 'en' => 'Related Posts', 'ru' => 'Похожие статьи'],
            'most_read' => ['az' => 'Ən Çox Oxunanlar', 'en' => 'Most Read', 'ru' => 'Самые читаемые'],
            'no_posts_found' => ['az' => 'Heç bir yazı tapılmadı', 'en' => 'No posts found', 'ru' => 'Статьи не найдены'],
            'no_categories_selected' => ['az' => 'Ana səhifə üçün kateqoriya seçilməyib.', 'en' => 'No categories selected for homepage.', 'ru' => 'Категории для главной страницы не выбраны.'],

            // Search & Filter
            'search_placeholder' => ['az' => 'Axtar...', 'en' => 'Search...', 'ru' => 'Поиск...'],
            'tags' => ['az' => 'Teqlər', 'en' => 'Tags', 'ru' => 'Теги'],
            'categories' => ['az' => 'Kateqoriyalar', 'en' => 'Categories', 'ru' => 'Категории'],

            // Share
            'share' => ['az' => 'Paylaş', 'en' => 'Share', 'ru' => 'Поделиться'],
            'copy_link' => ['az' => 'Linki kopyala', 'en' => 'Copy link', 'ru' => 'Копировать ссылку'],
            'link_copied' => ['az' => 'Link kopyalandı!', 'en' => 'Link copied!', 'ru' => 'Ссылка скопирована!'],

            // Contact Form
            'name' => ['az' => 'Ad', 'en' => 'Name', 'ru' => 'Имя'],
            'surname' => ['az' => 'Soyad', 'en' => 'Surname', 'ru' => 'Фамилия'],
            'email' => ['az' => 'E-poçt', 'en' => 'Email', 'ru' => 'Эл. почта'],
            'phone' => ['az' => 'Telefon', 'en' => 'Phone', 'ru' => 'Телефон'],
            'subject' => ['az' => 'Mövzu', 'en' => 'Subject', 'ru' => 'Тема'],
            'message' => ['az' => 'Mesaj', 'en' => 'Message', 'ru' => 'Сообщение'],
            'send' => ['az' => 'Göndər', 'en' => 'Send', 'ru' => 'Отправить'],
            'contact_success' => ['az' => 'Mesajınız uğurla göndərildi!', 'en' => 'Your message has been sent successfully!', 'ru' => 'Ваше сообщение успешно отправлено!'],

            // Footer
            'copyright' => ['az' => 'Bütün hüquqlar qorunur', 'en' => 'All rights reserved', 'ru' => 'Все права защищены'],
        ];

        foreach ($wordsData as $key => $translations) {
            $word = Word::firstOrCreate(['key' => $key]);
            foreach ($translations as $locale => $title) {
                $word->translateOrNew($locale)->title = $title;
            }
            $word->save();
        }
    }
}
