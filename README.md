# Career Fair DCS (Department of Computer Science)

A modern, enterprise-level career fair management system built with Laravel 12.x, designed to connect students with companies for recruitment opportunities.

## 🎨 Features

### Multi-Role System
- **Admin Dashboard**: Super user with full system access
- **Company Users**: Register, view assigned CVs, and manage recruitment
- **Students**: Upload CVs with detailed information, track applications

### Modern UI/UX
- **Theme Colors**: Purple (#A855F7), Blue (#4F6CE4), Cyan (#06B6D4)
- **Dark Mode**: Toggle between light and dark themes with localStorage persistence
- **Responsive Design**: Fully responsive layout for all devices
- **Animations**: Smooth fadeIn, slideIn, and pulse-glow animations
- **Gradient Backgrounds**: Professional gradient backgrounds throughout

### Security Features
- **Role-Based Access Control**: Custom middleware for role verification
- **SQL Injection Prevention**: Eloquent ORM with parameterized queries
- **Password Hashing**: Bcrypt encryption for all passwords
- **CSRF Protection**: Built-in Laravel CSRF token verification
- **University Email Validation**: Students must use university email (@student.dcs.edu)
- **File Upload Validation**: PDF only, max 10MB with MIME type checking

## 🚀 Technology Stack

- **Framework**: Laravel 12.50.0
- **PHP**: 8.5
- **Database**: MySQL 8.4
- **Frontend**: Blade Templates + Tailwind CSS 4.0
- **JavaScript**: Alpine.js 3.x with collapse plugin
- **Build Tool**: Vite 7.3.1
- **Container**: Docker with Laravel Sail
- **Additional Services**: phpMyAdmin

## 📋 Prerequisites

- Docker Desktop
- Git
- Composer
- Node.js & npm

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone <your-repo-url>
cd Career-Fair-DCS
```

### 2. Environment Setup
```bash
cp .env.example .env
# Edit .env file and set database credentials:
# DB_HOST=mysql
# DB_PORT=3306
# DB_DATABASE=career_fair_dcs
# DB_USERNAME=sail
# DB_PASSWORD=password
```

### 3. Start Docker Containers
```bash
docker compose up -d
```

### 4. Install Dependencies
```bash
# PHP dependencies
./vendor/bin/sail composer install

# Node dependencies
npm install
```

### 5. Generate Application Key
```bash
./vendor/bin/sail artisan key:generate
```

### 6. Run Migrations & Seeders
```bash
./vendor/bin/sail artisan migrate --seed
```

### 7. Create Storage Link
```bash
./vendor/bin/sail artisan storage:link
```

### 8. Build Frontend Assets
```bash
npm run build
# or for development with hot reload:
npm run dev
```

## 🔑 Default Admin Credentials

- **Email**: admin@careerfair.com
- **Password**: admin123

## 📁 Project Structure

```
Career-Fair-DCS/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── AdminDashboardController.php
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── LogoutController.php
│   │   │   ├── Company/
│   │   │   │   └── CompanyDashboardController.php
│   │   │   ├── Student/
│   │   │   │   └── StudentDashboardController.php
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Company.php
│   │   ├── Student.php
│   │   ├── CV.php
│   │   └── CompanyParticipationResponse.php
│   └── Providers/
├── database/
│   ├── migrations/
│   │   ├── 2026_02_08_185612_add_role_to_users_table.php
│   │   ├── 2026_02_08_185625_create_companies_table.php
│   │   ├── 2026_02_08_185719_create_students_table.php
│   │   ├── 2026_02_08_185723_create_cvs_table.php
│   │   ├── 2026_02_08_185727_create_cv_company_table.php
│   │   └── 2026_02_08_185742_create_company_participation_responses_table.php
│   └── seeders/
│       ├── AdminUserSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css (Tailwind CSS configuration)
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── responses.blade.php
│       │   ├── companies.blade.php
│       │   └── cvs.blade.php
│       ├── company/
│       │   └── dashboard.blade.php
│       ├── student/
│       │   ├── dashboard.blade.php
│       │   └── upload-cv.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── home.blade.php
│       └── welcome.blade.php
├── routes/
│   └── web.php
└── storage/
    └── app/
        └── public/
            └── cvs/ (Uploaded CV files)
```

## 🗄️ Database Schema

### users
- `id`, `name`, `email`, `password`
- `role` (enum: admin, company_user, student)
- `is_active` (boolean)

### companies
- `id`, `user_id` (FK)
- `company_name`, `contact_person`, `email`, `phone`
- `address`, `description`, `website`, `industry`

### students
- `id`, `user_id` (FK)
- `sc_number` (unique), `name_with_initials`
- `uni_email`, `gpa`, `phone`

### cvs
- `id`, `student_id` (FK)
- `applying_job_position`, `tech_skills`
- `cv_file_path`, `status` (enum: pending, approved, rejected)

### cv_company (pivot table)
- `cv_id` (FK), `company_id` (FK)
- `assigned_at`, `viewed_status` (boolean)

### company_participation_responses
- Public form submissions from companies
- `company_name`, `contact_person`, `email`, `phone`
- `message`, `interested_to_participate`, `contacted`

## 🔐 User Roles & Permissions

### Admin
- View all company responses from public form
- Manage registered companies
- View all student CVs
- Assign CVs to companies
- Add new students manually
- Full system oversight

### Company User
- Register with company details
- View assigned CVs from admin
- Mark CVs as viewed
- Download student CVs
- View student contact information

### Student
- Register with university email
- Upload CV (PDF, max 10MB)
- Provide SC number, name, GPA, phone
- Specify job position interest
- List technical skills
- View which companies have access to CV

## 🌐 Routes

### Public Routes
- `GET /` - Homepage with company interest form
- `POST /company-interest` - Submit company interest

### Authentication Routes
- `GET /login` - Login form
- `POST /login` - Process login
- `GET /register` - Registration form
- `POST /register` - Process registration
- `POST /logout` - Logout

### Admin Routes (Middleware: auth, role:admin)
- `GET /admin/dashboard` - Admin overview
- `GET /admin/responses` - View company responses
- `GET /admin/companies` - Manage companies
- `GET /admin/cvs` - Manage CVs and assignments
- `POST /admin/assign-cv` - Assign CV to companies
- `POST /admin/student/add` - Add new student

### Company Routes (Middleware: auth, role:company_user)
- `GET /company/dashboard` - Company overview
- `GET /company/cvs` - View assigned CVs
- `POST /company/cv/{cv}/view` - Mark CV as viewed

### Student Routes (Middleware: auth, role:student)
- `GET /student/dashboard` - Student overview
- `GET /student/upload-cv` - CV upload form
- `POST /student/upload-cv` - Process CV upload
- `GET /student/my-cvs` - View uploaded CVs

## 🎯 Key Functionalities

### For Admin
1. **Dashboard**: Overview stats for students, companies, CVs, and pending responses
2. **Company Responses**: View and manage public form submissions
3. **Company Management**: View registered companies and their activity
4. **CV Assignment**: Assign student CVs to multiple companies via modal interface
5. **Recent Activity**: Track latest CV submissions

### For Companies
1. **Dashboard**: View assigned CVs with student details
2. **CV Viewing**: Download and view student CVs (PDF)
3. **Mark as Viewed**: Track which CVs have been reviewed
4. **Statistics**: Total assigned CVs, viewed CVs, and new CVs

### For Students
1. **Dashboard**: View uploaded CVs and assignment status
2. **CV Upload**: Upload CV with job position and technical skills
3. **Profile Info**: Display SC number, name, email, GPA
4. **Track Assignments**: See which companies have access to CV

## 🎨 Theme Configuration

The application uses a custom color scheme defined in `tailwind.config.js`:

```javascript
colors: {
  primary: '#4F6CE4',   // Blue
  secondary: '#A855F7', // Purple
  accent: '#06B6D4',    // Cyan
}
```

Dark mode colors are automatically adjusted with proper contrast ratios.

## 📦 Docker Services

| Service | Port | Purpose |
|---------|------|---------|
| Laravel | 80 | Main application |
| MySQL | 3307 | Database |
| phpMyAdmin | 8080 | Database management |
| Vite | 3000 | Development server (dev mode) |

## 🔧 Useful Commands

### Container Management
```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# View logs
docker logs career-fair-dcs-laravel.test-1 -f

# Restart containers
docker compose restart
```

### Laravel Artisan
```bash
# Clear caches
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan view:clear
./vendor/bin/sail artisan route:clear

# Run migrations
./vendor/bin/sail artisan migrate

# Seed database
./vendor/bin/sail artisan db:seed

# Create storage link
./vendor/bin/sail artisan storage:link
```

### Frontend
```bash
# Development server with hot reload
npm run dev

# Production build
npm run build

# Watch files
npm run watch
```

## 🐛 Troubleshooting

### Port Conflicts
If you encounter port conflicts, edit `compose.yaml`:
- `FORWARD_DB_PORT: 3307` (MySQL port)
- Change Laravel port in `APP_URL` in `.env`

### Permission Issues
```bash
# Fix storage permissions
./vendor/bin/sail exec laravel.test chown -R sail:sail storage bootstrap/cache
./vendor/bin/sail exec laravel.test chmod -R 775 storage bootstrap/cache
```

### Database Connection Issues
1. Ensure MySQL container is healthy: `docker ps`
2. Check credentials in `.env` file
3. Restart Laravel container: `docker compose restart laravel.test`

### File Upload Issues
1. Create storage directory: `mkdir -p storage/app/public/cvs`
2. Run storage link: `./vendor/bin/sail artisan storage:link`
3. Check file permissions on storage directory

## 🔒 Security Best Practices Implemented

1. **Password Security**
   - Bcrypt hashing with cost factor 12
   - Minimum 8 characters requirement
   - No password stored in plain text

2. **SQL Injection Prevention**
   - Eloquent ORM with parameterized queries
   - No raw SQL queries without parameter binding
   - Input sanitization via Laravel validation

3. **CSRF Protection**
   - All forms include `@csrf` token
   - Automatic verification on POST/PUT/DELETE requests
   - Token rotation on login/logout

4. **File Upload Security**
   - Strict MIME type validation (PDF only)
   - File size limit (10MB)
   - Files stored outside public directory
   - Symlink for controlled access

5. **Authentication**
   - Session-based authentication
   - Password reset functionality
   - Email verification for students (university email)

6. **Authorization**
   - Role-based access control middleware
   - Route protection per user role
   - Active user status checking

## 📝 Testing the Application

### 1. Test Admin Features
1. Login: http://localhost/login
   - Email: admin@careerfair.com
   - Password: admin123
2. Navigate to Admin Dashboard
3. Test viewing responses, companies, and CVs

### 2. Test Company Registration
1. Go to: http://localhost/register
2. Select "Company User" role
3. Fill in company details
4. Login and view dashboard

### 3. Test Student Registration
1. Go to: http://localhost/register
2. Select "Student" role
3. Use university email format: `yourname@student.dcs.edu`
4. Fill in SC number, GPA, phone
5. Login and upload CV

### 4. Test CV Assignment Flow
1. As student: Upload a CV
2. As admin: Go to Manage CVs, assign to companies
3. As company: View assigned CVs on dashboard

## 🎓 University Email Validation

Students must register with email ending in `@student.dcs.edu`. This is enforced in the registration controller.

To modify the email domain, edit [RegisterController.php](app/Http/Controllers/Auth/RegisterController.php#L30-L35):
```php
'uni_email' => 'required|email|ends_with:@student.dcs.edu|unique:students,uni_email',
```

## 📊 Database Access

### phpMyAdmin
- URL: http://localhost:8080
- Server: mysql
- Username: sail
- Password: password

## 🚀 Deployment Considerations

### Production Checklist
- [ ] Change `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY`
- [ ] Configure proper database credentials
- [ ] Set up SSL/HTTPS
- [ ] Configure mail server for notifications
- [ ] Set up proper file storage (S3, etc.)
- [ ] Enable queue workers for background jobs
- [ ] Set up scheduled tasks (cron)
- [ ] Configure backups
- [ ] Set rate limiting on routes

## 📄 License


This project is built with Laravel framework which is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Development Team

Developed for Department of Computer Science Career Fair Management System.

## 🆘 Support

For issues or questions:
1. Check the troubleshooting section above
2. Review Laravel documentation: https://laravel.com/docs
3. Check Docker Sail documentation: https://laravel.com/docs/sail

---

**Built with ❤️ using Laravel 12.x, Tailwind CSS 4.0, and Alpine.js**

