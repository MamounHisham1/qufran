# 🕌 Qufran - Islamic Educational Platform

<p align="center">
  <img src="public/images/logo.png" alt="Qufran Logo" width="200"/>
</p>

<p align="center">
  <strong>A comprehensive Islamic educational platform built with Laravel</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#installation">Installation</a> •
  <a href="#usage">Usage</a> •
  <a href="#contributing">Contributing</a> •
  <a href="#license">License</a>
</p>

## 📖 About Qufran

Qufran is a modern Islamic educational platform that provides Muslims with easy access to Islamic knowledge and resources. The platform combines the Holy Quran, authentic Hadith collections, daily Adhkar (remembrance), Islamic lessons, and fatawa in one comprehensive web application.

### 🎯 Mission
To make Islamic knowledge accessible to Muslims worldwide through modern technology while maintaining authenticity and ease of use.

## ✨ Features

### 📚 Islamic Content
- **Holy Quran**: Complete Quran with Arabic text, tafseer, and audio recitations
- **Hadith Collections**: Authentic hadith from major collections (Bukhari, Muslim, Abu Dawud, etc.)
- **Daily Adhkar**: Morning and evening remembrance with interactive counters
- **Islamic Lessons**: Multi-format educational content (articles, videos, audio) by renowned scholars
- **Fatawa**: Islamic rulings and answers to religious questions
- **Blog**: Multi-section blog posts and articles
- **Scholar Profiles**: Detailed information about Islamic scholars and authors

### 🎓 Educational Tools
- **Interactive Examinations**: Test your Islamic knowledge with time-restricted quizzes and exams
- **Audio Support**: Listen to Quran recitations and audio lessons
- **Video Lessons**: Watch educational videos from renowned scholars
- **Advanced Hadith Search**: Sophisticated search through hadith collections with multiple filters (books, scholars, degrees, narrators, search zones, and methods)
- **Category Organization**: Content organized by topics and categories with hierarchical structure
- **Multiple Content Types**: Support for articles, videos, audio, images, and fatawa
- **Progress Tracking**: Monitor your learning journey and completed activities

### 👨‍💼 Admin Features
- **Content Management**: Full CRUD operations for all content types
- **User Management**: User roles and permissions
- **Suggestions System**: Community suggestions and feedback
- **Examination Management**: Create and manage interactive quizzes with questions and answers
- **Analytics Dashboard**: Track user engagement and content performance
- **Flexible Post Types**: Manage different content types (articles, videos, audio, images, fatawa)
- **Category Management**: Organize content with a hierarchical category system
- **Blog Management**: Create and manage multi-section blog posts
- **Scholar Management**: Manage author profiles and their content
- **Settings Management**: Configure application settings for different pages

### 🌟 User Experience
- **Responsive Design**: Optimized for desktop, tablet, and mobile
- **Arabic Support**: Full RTL (Right-to-Left) text support
- **Prayer Times**: Local prayer time integration
- **Daily Reminders**: Automated adhkar reminders
- **Progress Tracking**: Track your learning progress and completed adhkar
- **Exam Completion Tracking**: Track completed examinations and view results
- **Interactive Adhkar Counters**: Interactive counters for daily remembrance

## 🛠️ Technology Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Alpine.js + Tailwind CSS
- **Admin Panel**: Filament
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **Styling**: Tailwind CSS
- **JavaScript**: Alpine.js for interactive components

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0+ or PostgreSQL 13+
- Web server (Apache/Nginx)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/qufran.git
   cd qufran
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=qufran
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the application**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to access the application.

## 📱 Usage

### For Users
1. **Browse Content**: Explore Quran, Hadith, and Islamic lessons
2. **Daily Adhkar**: Access morning and evening remembrance with interactive counters
3. **Take Exams**: Test your Islamic knowledge with interactive quizzes
4. **Search**: Find specific hadith or topics using the advanced search feature with multiple filters
5. **Track Progress**: Monitor your learning journey and completed activities
6. **Read Blogs**: Read articles and posts on various Islamic topics
7. **Listen to Audio**: Access Quran recitations and audio lessons
8. **Watch Videos**: View educational video content from scholars
9. **View Scholar Profiles**: Learn about different Islamic scholars and their contributions
10. **Submit Suggestions**: Provide feedback and suggestions to improve the platform

### For Administrators
1. **Access Admin Panel**: Visit `/admin` and login with admin credentials
2. **Manage Content**: Add, edit, or remove Islamic content (articles, videos, audio, images, fatawa)
3. **User Management**: Manage user accounts and permissions
4. **Examination Management**: Create and manage interactive quizzes with questions and answers
5. **Category Management**: Organize content with hierarchical categories
6. **Analytics**: View platform usage statistics and user engagement
7. **Suggestions Management**: Review and respond to community feedback
8. **Settings Management**: Configure application settings for different pages

## 🗂️ Project Structure

```
qufran/
├── app/
│   ├── Filament/          # Admin panel resources
│   │   └── Resources/     # CRUD resources for admin panel
│   ├── Http/Controllers/  # Application controllers
│   ├── Models/            # Eloquent models
│   └── ...                # Other application components
├── database/
│   ├── migrations/        # Database migrations
│   ├── seeders/          # Database seeders
│   └── factories/        # Model factories
├── resources/
│   ├── views/            # Blade templates
│   ├── css/             # Stylesheets
│   └── js/              # JavaScript files
├── routes/
│   ├── web.php          # Web routes
│   └── auth.php         # Authentication routes
├── public/
│   ├── images/          # Static images
│   └── ...              # Other public assets
└── tests/               # Application tests
```

## 🎨 Key Components

### Models
- `User` - User management and authentication
- `Post` - Multi-type content (lessons, fatawa, articles, videos, audio)
- `Blog` - Multi-section blog posts and articles
- `Section` - A section within a blog post
- `Author` - Islamic scholars and content creators
- `Category` - Content categorization with hierarchical structure
- `Examination` - Quiz and test system with time restrictions
- `Question` - Questions for examinations
- `Answer` - Answers for examination questions
- `Chapter` & `Verse` - Quran structure
- `Reciter` - Quran reciters with audio URLs
- `Suggestion` - Community feedback
- `Setting` - Application settings for different pages

### Controllers
- `HomeController` - Main dashboard and homepage
- `BlogController` - Handles blog listing and display
- `QuranHadithController` - Quran and Hadith display with Adhkar
- `ExaminationController` - Quiz management and user exam tracking
- `PostController` - Content management for lessons
- `FatwaController` - Fatawa management
- `HadithSearchController` - Advanced search functionality with multiple filters
- `AuthorController` - Scholar profile management
- `CategoryController` - Category-based content display
- `SuggestionController` - Community suggestions handling

## 🤝 Contributing

We welcome contributions from the community! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Ensure all tests pass before submitting PR

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Islamic Content Sources**: Various authentic Islamic sources and APIs
- **Laravel Community**: For the excellent framework and ecosystem
- **Contributors**: All developers who have contributed to this project
- **Islamic Scholars**: For providing authentic content and guidance

## 📞 Support

For support, questions, or suggestions:
- Open an issue on GitHub
- Contact: [your-email@example.com]
- Documentation: [Link to docs if available]

## 🌙 Barakallahu feekum

May Allah bless this project and make it beneficial for the Ummah.

---

<p align="center">Made with ❤️ for the Ummah</p>
