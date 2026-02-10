# Security Features and Best Practices

This document outlines the comprehensive security measures implemented in the Career Fair DCS application.

## 1. Authentication & Authorization

### Password Security
- **Hashing Algorithm**: Bcrypt with cost factor 12 (Laravel default)
- **Minimum Length**: 8 characters enforced via validation
- **Password Reset**: Built-in Laravel password reset functionality
- **Storage**: Passwords never stored in plain text

Implementation:
```php
// In RegisterController and LoginController
'password' => 'required|min:8'
\Hash::make($request->password)
```

### Role-Based Access Control (RBAC)
- **Three Roles**: admin, company_user, student
- **Custom Middleware**: `CheckRole` middleware validates user roles
- **Route Protection**: All sensitive routes protected with role middleware

Implementation:
```php
// Middleware: app/Http/Middleware/CheckRole.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin-only routes
});
```

### Active User Status
- **Account Activation**: `is_active` boolean field in users table
- **Login Check**: Inactive users cannot log in
- **Admin Control**: Admin can activate/deactivate user accounts

## 2. SQL Injection Prevention

### Eloquent ORM
All database queries use Eloquent ORM with automatic parameter binding:

```php
// Safe - Uses parameter binding
$user = User::where('email', $request->email)->first();
$cvs = CV::with('student')->get();
```

### Parameterized Queries
No raw SQL queries without parameter binding:
```php
// If raw SQL is needed (not used in current app):
DB::select('SELECT * FROM users WHERE email = ?', [$email]);
```

### Input Validation
All user inputs validated before database operations:
```php
$request->validate([
    'email' => 'required|email|unique:users,email',
    'sc_number' => 'required|string|unique:students,sc_number'
]);
```

## 3. Cross-Site Request Forgery (CSRF) Protection

### Laravel CSRF Tokens
- **Automatic Generation**: All forms include `@csrf` directive
- **Verification**: All POST/PUT/DELETE requests verified
- **Token Rotation**: Tokens regenerated on login/logout

Implementation:
```blade
<form method="POST" action="{{ route('login') }}">
    @csrf
    <!-- form fields -->
</form>
```

### API Token (If needed for future API endpoints)
- Use Laravel Sanctum for API authentication
- Token-based authentication for stateless requests

## 4. File Upload Security

### Validation Rules
```php
'cv_file' => 'required|file|mimes:pdf|max:10240' // 10MB max
```

### Security Measures:
1. **MIME Type Checking**: Only PDF files allowed
2. **File Size Limit**: Maximum 10MB per file
3. **Storage Location**: Files stored in `storage/app/public/cvs` (not directly web-accessible)
4. **Controlled Access**: Files accessed via symlink to `public/storage`
5. **Unique Filenames**: Laravel generates unique filenames automatically

### File Storage Implementation:
```php
$filePath = $request->file('cv_file')->store('cvs', 'public');
```

### Recommendations for Production:
- Implement virus scanning (ClamAV integration)
- Add file content inspection
- Implement rate limiting on file uploads
- Consider cloud storage (AWS S3) with signed URLs

## 5. Cross-Site Scripting (XSS) Prevention

### Blade Template Escaping
- **Automatic Escaping**: `{{ $variable }}` automatically escapes HTML
- **Raw Output**: `{!! $variable !!}` only used for trusted content
- **Input Sanitization**: Laravel validation sanitizes inputs

Implementation:
```blade
<!-- Safe - Automatically escaped -->
<p>{{ $user->name }}</p>

<!-- Unsafe - Only for trusted HTML -->
{!! $trustedHtml !!}
```

## 6. Email Validation

### University Email Requirement
Students must register with university domain:
```php
'uni_email' => 'required|email|ends_with:@student.dcs.edu|unique:students,uni_email'
```

### Email Verification (Recommended for Production)
Implement Laravel's built-in email verification:
```php
// Add to User model
use Illuminate\Contracts\Auth\MustVerifyEmail;
class User extends Authenticatable implements MustVerifyEmail
```

## 7. Session Security

### Session Configuration
- **Driver**: Database or Redis (configure in `.env`)
- **Lifetime**: 120 minutes (configurable)
- **Secure Cookies**: Enable in production with HTTPS
- **HTTP Only**: Cookies not accessible via JavaScript
- **Same Site**: CSRF protection

Configuration in `config/session.php`:
```php
'secure' => env('SESSION_SECURE_COOKIE', true),
'http_only' => true,
'same_site' => 'lax',
```

## 8. Database Security

### Connection Security
- **Environment Variables**: Credentials in `.env` (not in version control)
- **User Permissions**: Database user has minimal required permissions
- **Prepared Statements**: All queries use parameter binding

### Backup Strategy (Recommended)
```bash
# Daily automated backups
./vendor/bin/sail artisan backup:run
```

## 9. Rate Limiting

### Recommendation: Implement Rate Limiting
Protect against brute force attacks:

```php
// In app/Providers/RouteServiceProvider.php
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->email.$request->ip());
});

// Apply to routes
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:login');
```

## 10. Error Handling

### Production Configuration
In `.env` for production:
```env
APP_ENV=production
APP_DEBUG=false
```

### Custom Error Pages
- 404: Not Found
- 403: Forbidden
- 500: Server Error

Create in `resources/views/errors/`:
- `404.blade.php`
- `403.blade.php`
- `500.blade.php`

## 11. HTTPS Enforcement (Production)

### Force HTTPS in Production
In `app/Providers/AppServiceProvider.php`:
```php
public function boot()
{
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
```

## 12. Security Headers

### Recommendation: Add Security Headers
In `app/Http/Middleware/SecurityHeaders.php`:
```php
return $next($request)
    ->header('X-Frame-Options', 'SAMEORIGIN')
    ->header('X-Content-Type-Options', 'nosniff')
    ->header('X-XSS-Protection', '1; mode=block')
    ->header('Referrer-Policy', 'strict-origin-when-cross-origin');
```

## 13. Logging and Monitoring

### Security Event Logging
Monitor and log:
- Failed login attempts
- Unauthorized access attempts
- File upload events
- Database errors

Implementation:
```php
\Log::warning('Failed login attempt', [
    'email' => $request->email,
    'ip' => $request->ip()
]);
```

## 14. Dependency Security

### Keep Dependencies Updated
```bash
# Check for security updates
composer audit

# Update dependencies
composer update

# Update npm packages
npm audit
npm audit fix
```

## 15. Environment Variables

### Secure Configuration
- `.env` file in `.gitignore`
- Never commit sensitive data
- Use different `.env` files for each environment
- Strong `APP_KEY` (32 characters)

## Security Checklist for Production

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate strong `APP_KEY`
- [ ] Enable HTTPS with valid SSL certificate
- [ ] Configure secure session cookies
- [ ] Implement rate limiting on authentication
- [ ] Enable email verification for users
- [ ] Set up automated database backups
- [ ] Configure security headers
- [ ] Implement file virus scanning
- [ ] Set up proper error logging
- [ ] Review and restrict database user permissions
- [ ] Enable Laravel Telescope for monitoring (development only)
- [ ] Configure firewall rules
- [ ] Set up intrusion detection
- [ ] Regular security audits
- [ ] Keep all dependencies updated

## Compliance Considerations

### GDPR (If applicable)
- User consent for data processing
- Right to data deletion
- Data export functionality
- Privacy policy

### Data Protection
- Encrypt sensitive data at rest
- Secure data transmission (HTTPS)
- Access logging
- Data retention policies

## Incident Response Plan

1. **Detection**: Monitor logs for suspicious activity
2. **Containment**: Disable affected accounts/features
3. **Investigation**: Review logs and determine scope
4. **Resolution**: Apply fixes and patches
5. **Recovery**: Restore services
6. **Post-Incident**: Document and improve

## Regular Security Maintenance

### Weekly
- Review authentication logs
- Check for failed login patterns
- Monitor file uploads

### Monthly
- Update dependencies
- Review user accounts
- Security audit of new features

### Quarterly
- Penetration testing
- Security training for developers
- Review and update security policies

## Resources

- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://phptherightway.com/#security)

---

**Last Updated**: February 2026  
**Review Schedule**: Quarterly
