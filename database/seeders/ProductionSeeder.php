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
            ['az' => 'Texnologiya', 'en' => 'Technology', 'ru' => 'Технологии', 'order' => 1, 'show_on_home' => true],
            ['az' => 'Proqramlaşdırma', 'en' => 'Programming', 'ru' => 'Программирование', 'order' => 2, 'show_on_home' => true],
            ['az' => 'Dizayn', 'en' => 'Design', 'ru' => 'Дизайн', 'order' => 3, 'show_on_home' => true],
            ['az' => 'Startup', 'en' => 'Startup', 'ru' => 'Стартап', 'order' => 4, 'show_on_home' => true],
            ['az' => 'Karyera', 'en' => 'Career', 'ru' => 'Карьера', 'order' => 5, 'show_on_home' => false],
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

            if (!$category->translate('az')) {
                $category->translateOrNew('az')->name = $cat['az'];
                $category->translateOrNew('az')->slug = \Str::slug($cat['az']);
                $category->translateOrNew('en')->name = $cat['en'];
                $category->translateOrNew('en')->slug = \Str::slug($cat['en']);
                $category->translateOrNew('ru')->name = $cat['ru'];
                $category->translateOrNew('ru')->slug = \Str::slug($cat['ru']);
                $category->save();
            }
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
        // Words are created dynamically via word() helper
        // Add any essential translations here if needed
    }
}
