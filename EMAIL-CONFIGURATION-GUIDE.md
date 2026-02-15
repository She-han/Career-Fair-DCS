# 📧 Email Configuration Guide - Forgot Password Feature

## ✅ Implemented Features

### New Files Created:
1. **Controller**: `app/Http/Controllers/Auth/ForgotPasswordController.php`
2. **Mailable**: `app/Mail/TemporaryPasswordMail.php`
3. **Email Template**: `resources/views/emails/temporary-password.blade.php`
4. **Forgot Password View**: `resources/views/auth/forgot-password.blade.php`

### Modified Files:
1. **Login Page**: `resources/views/auth/login.blade.php` - Added "Forgot Password?" link
2. **Routes**: `routes/web.php` - Added forgot password routes

---

## 🔧 Email Configuration Setup

### Option 1: Gmail SMTP (Recommended for Testing)

#### Step 1: Enable Gmail App Password
1. Go to your Google Account: https://myaccount.google.com/
2. Navigate to **Security** → **2-Step Verification** (Enable if not already)
3. Go to **Security** → **App passwords**
4. Select **Mail** and **Windows Computer**
5. Copy the generated 16-character password

#### Step 2: Update `.env` File

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Replace:**
- `your-email@gmail.com` - Your Gmail address
- `your-16-char-app-password` - The app password from Step 1

---

### Option 2: Mailtrap (Best for Development/Testing)

Mailtrap catches all emails so they won't be sent to real users during testing.

#### Step 1: Create Mailtrap Account
1. Go to: https://mailtrap.io/
2. Sign up for free account
3. Go to **Email Testing** → **Inboxes** → **My Inbox**
4. Click **Show Credentials**

#### Step 2: Update `.env` File

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@careerfair.dcs.ruh.ac.lk
MAIL_FROM_NAME="${APP_NAME}"
```

---

### Option 3: SendGrid (Production Recommended)

SendGrid provides 100 free emails per day.

#### Step 1: Create SendGrid Account
1. Go to: https://sendgrid.com/
2. Sign up for free account
3. Go to **Settings** → **API Keys**
4. Create new API key with "Mail Send" permissions
5. Copy the API key

#### Step 2: Update `.env` File

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@careerfair.dcs.ruh.ac.lk
MAIL_FROM_NAME="${APP_NAME}}"
```

---

### Option 4: University SMTP Server

If University of Ruhuna has an SMTP server:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.ruh.ac.lk
MAIL_PORT=587
MAIL_USERNAME=your-university-email@ruh.ac.lk
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@dcs.ruh.ac.lk
MAIL_FROM_NAME="${APP_NAME}"
```

**Note:** Contact University IT department for SMTP server details.

---

## 🧪 Testing the Email Configuration

### Local Testing (Docker Sail):

```bash
# 1. Update .env file with email credentials
# 2. Restart Docker containers to apply changes
docker exec career-fair-dcs-laravel.test-1 php artisan config:clear

# 3. Test email sending
docker exec career-fair-dcs-laravel.test-1 php artisan tinker
```

In Tinker:
```php
Mail::raw('Test email from Career Fair DCS', function($message) {
    $message->to('test@example.com')->subject('Test Email');
});
exit
```

If no error, email configuration is working! ✅

---

## 🚀 How the Feature Works

### User Flow:

1. **User goes to Login page** → Clicks "Forgot Password?"
2. **Forgot Password page appears** → User enters their admin email
3. **System validates**:
   - ✓ Email exists in database
   - ✓ User is an admin (not student/company)
   - ✓ Account is active
4. **System generates** temporary password (e.g., `aBcD1234`)
5. **System updates** user's password in database (hashed)
6. **System sends** email with temporary password
7. **User receives email** with:
   - Temporary password
   - Instructions to login
   - Warning to change password immediately
8. **User logs in** with temporary password
9. **User goes to** "Change Password" (in sidebar)
10. **User enters**:
    - Current Password: `aBcD1234` (temporary)
    - New Password: `SecurePassword123!`
    - Confirm Password: `SecurePassword123!`
11. **Password updated** ✅

---

## 📝 Admin Testing Accounts

Test with these admin accounts:

| Email | Current Password |
|-------|-----------------|
| admin@careerfair.com | admin123 |
| aruna@dcs.ruh.ac.lk | admin123 |

---

## 🔐 Security Features

✅ **Admin-only access**: Only admin role can use forgot password
✅ **Password hashing**: Uses bcrypt (Laravel default)
✅ **Random generation**: 8-character alphanumeric temporary password
✅ **Account validation**: Checks if account exists and is active
✅ **Immediate expiry**: Temporary password is replaced when user changes it
✅ **Error handling**: If email fails, password change is not saved

---

## 🐛 Troubleshooting

### Issue: "Failed to send email"

**Check:**
1. `.env` file has correct SMTP credentials
2. Run `php artisan config:clear` after changing `.env`
3. Internet connection is working
4. For Gmail: App password is correct (not regular password)
5. Check error message in browser for details

### Issue: "No account found with this email"

**Solution:**
- Verify email is correct
- Check if user exists: `php artisan tinker` → `User::where('email', 'test@example.com')->first();`
- Verify user role is 'admin'

### Issue: Email not received

**Check:**
1. Spam/Junk folder
2. Email logs: `docker exec career-fair-dcs-laravel.test-1 tail -f storage/logs/laravel.log`
3. For Mailtrap: Check Mailtrap inbox (emails don't go to real inbox)

---

## 📦 Production Deployment

### On DigitalOcean Server:

```bash
# 1. SSH to server
ssh root@167.172.84.89

# 2. Navigate to project
cd /var/www/career-fair-dcs

# 3. Pull latest changes
sudo git pull origin main

# 4. Update .env with production email settings
sudo nano .env
# Add mail configuration here

# 5. Clear caches
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan optimize:clear

# 6. Test email
sudo -u www-data php artisan tinker
# Run test email command

# 7. Restart Apache
sudo systemctl restart apache2
```

---

## ✉️ Email Template Preview

The sent email includes:
- 🎨 Professional design with gradient header
- 🔐 Large, clear temporary password display
- ⚠️ Security warnings and instructions
- 📋 Step-by-step guide to reset password
- 🔗 Direct login link
- 🏢 University branding

---

## 🎯 Next Steps

1. ✅ Choose email provider (Gmail/Mailtrap/SendGrid)
2. ✅ Update `.env` file with credentials
3. ✅ Clear config cache
4. ✅ Test forgot password flow
5. ✅ Test email receiving
6. ✅ Test login with temporary password
7. ✅ Test changing password
8. ✅ Deploy to production

---

## 📞 Support

If you need help:
- Check Laravel logs: `storage/logs/laravel.log`
- Test email configuration with Tinker
- Verify admin accounts exist
- Contact university IT for SMTP server details

---

**Feature Status**: ✅ FULLY IMPLEMENTED & READY TO TEST!
