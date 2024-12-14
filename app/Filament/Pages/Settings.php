<?php

namespace App\Filament\Pages;

use App\Models\Author;
use App\Models\Category;
use App\Models\Examination;
use App\Models\Post;
use App\Models\Setting;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.settings';

    protected static ?string $navigationLabel = 'الاعدادات';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'home' => Setting::firstWhere(['page' => 'home', 'key' => 'home'])?->value,
            'lessons' => Setting::firstWhere(['page' => 'lessons', 'key' => 'lessons'])?->value,
            'fatawa' => Setting::firstWhere(['page' => 'fatawa', 'key' => 'fatawa'])?->value,
            'exams' => Setting::firstWhere(['page' => 'exams', 'key' => 'exams'])?->value,
        ]);
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->schema([
                    Tab::make('الرئيسية')->schema([
                        Section::make('المقترحات')->schema([
                            Select::make('suggested_categories')
                                ->label(__('Suggested categories'))
                                ->options(Category::pluck('name', 'id'))
                                ->multiple()
                                ->maxItems(8)
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label(__('Name'))
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('parent_category_id')
                                        ->label(__('Parent category'))
                                        ->numeric(),
                                    Toggle::make('is_published')
                                        ->label(__("Is published")),
                                ])->createOptionUsing(fn($data) => Category::create($data)),
                            Select::make('suggested_lessons')
                                ->label(__('Suggested lessons'))
                                ->options(Post::where('type', '!=', 'fatwa')->pluck('title', 'id'))
                                ->multiple()
                                ->maxItems(8),
                            Select::make('latest_lessons')
                                ->label(__('Latest lessons'))
                                ->options(Post::where('type', '!=', 'fatwa')->pluck('title', 'id'))
                                ->multiple()
                                ->maxItems(8),
                            Select::make('famous_teachers')
                                ->label(__('Famous teacher'))
                                ->options(Author::pluck('name', 'id'))
                                ->multiple(),
                        ])
                    ])->statePath('home'),
                    Tab::make('الدروس')->schema([
                        Section::make('المقترحات')->schema([
                            Select::make('suggested_categories')
                                ->label(__('Suggested categories'))
                                ->options(Category::pluck('name', 'id'))
                                ->multiple()
                                ->maxItems(8)
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label(__('Name'))
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('parent_category_id')
                                        ->label(__('Parent category'))
                                        ->numeric(),
                                    Toggle::make('is_published')
                                        ->label(__("Is published")),
                                ])->createOptionUsing(fn($data) => Category::create($data)),
                            Select::make('most_watched')
                                ->label(__('Most watched'))
                                ->options(Post::where('type', '!=', 'fatwa')->pluck('title', 'id'))
                                ->multiple()
                                ->maxItems(10),
                            Select::make('most_liked')
                                ->label(__('Most liked'))
                                ->options(Post::where('type', '!=', 'fatwa')->pluck('title', 'id'))
                                ->multiple()
                                ->maxItems(10),
                            Select::make('suggested')
                                ->label(__('Suggested'))
                                ->options(Post::where('type', '!=', 'fatwa')->pluck('title', 'id'))
                                ->multiple()
                                ->maxItems(10),
                            Select::make('latest')
                                ->label(__('Latest'))
                                ->options(Post::where('type', '!=', 'fatwa')->pluck('title', 'id'))
                                ->multiple()
                                ->maxItems(10),
                        ])
                    ])->statePath('lessons'),
                    Tab::make('الفتاوى')->schema([
                        Select::make('suggested_categories')
                            ->label(__('Suggested categories'))
                            ->options(Category::pluck('name', 'id'))
                            ->multiple()
                            ->maxItems(8)
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label(__('Name'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('parent_category_id')
                                    ->label(__('Parent category'))
                                    ->numeric(),
                                Toggle::make('is_published')
                                    ->label(__("Is published")),
                            ])->createOptionUsing(fn($data) => Category::create($data)),
                        Select::make('most_asked')
                            ->label(__('Most asked'))
                            ->options(Post::where('type', '=', 'fatwa')->pluck('title', 'id'))
                            ->multiple()
                            ->maxItems(10),
                        Select::make('latest')
                            ->label(__('Latest'))
                            ->options(Post::where('type', '=', 'fatwa')->pluck('title', 'id'))
                            ->multiple()
                            ->maxItems(10),
                    ])->statePath('fatawa'),
                    Tab::make('الامتحانات')->schema([
                        Select::make('categories')
                            ->label(__('Categories'))
                            ->options(Category::pluck('name', 'id'))
                            ->multiple()
                            ->maxItems(10),
                        Select::make('lessons')
                            ->label(__('Lessons'))
                            ->options(Post::where('type', '!=', 'fatwa')->pluck('title', 'id'))
                            ->multiple()
                            ->maxItems(10),
                        Select::make('recommended')
                            ->label(__('Recommended'))
                            ->options(Examination::pluck('name', 'id'))
                            ->multiple()
                            ->maxItems(10),
                        Select::make('most_taken')
                            ->label(__('Most taken'))
                            ->options(Examination::pluck('name', 'id'))
                            ->multiple()
                            ->maxItems(10),
                    ])->statePath('exams'),
                    // Tab::make('المشايخ')->schema([
                    //     TextInput::make('fatawa_name'),
                    // ]),
                    // Tab::make('عن المعهد')->schema([
                    //     TextInput::make('about_name'),
                    // ]),
                    // Tab::make('تواصل معنا')->schema([
                    //     TextInput::make('about_name'),
                    // ]),
                ])
            ])->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        Setting::set('home', 'home', $data['home'] ?? []);
        Setting::set('lessons', 'lessons', $data['lessons'] ?? []);
        Setting::set('fatawa', 'fatawa', $data['fatawa'] ?? []);
        Setting::set('exams', 'exams', $data['exams'] ?? []);

        Notification::make()->success()->title('تم الحفظ بنجاح.')->send();
    }

}
