# Tokenized Company Access System

## Overview
This document describes the new **Tokenized Company Access System** that eliminates the need for companies to sign up or login. Companies are automatically registered when they submit the interest form, and they receive a unique secure link to access their assigned CVs.

## Architecture Changes

### 1. **Auto-Registration Flow**
When a company submits the interest form with consent to receive CVs:

1. A `CompanyParticipationResponse` record is created
2. A `Company` record is **automatically created** with:
   - No user account required (`user_id` is nullable)
   - Unique 64-character access token generated
   - Link to the participation response
3. Company receives email with unique access link

### 2. **Secure Access Token System**

#### Token Generation
- **64-character random string** generated using `Str::random(64)`
- Uniqueness verified against existing tokens
- Auto-generated on company creation via model boot method
- Stored in `companies.access_token` column with unique index

#### Token Security Features
- **Rate Limiting**: 10 requests/minute per IP for token access
- **Audit Logging**: All access attempts logged with IP and timestamp
- **Token Expiry**: Optional expiry date field (`token_expires_at`)
- **No Brute Force**: Invalid tokens return 404 (not 403) to prevent enumeration

### 3. **Database Schema**

#### Companies Table (Updated)
```sql
- user_id (nullable) - Optional user account link
- company_name
- access_token (unique, 64 chars, indexed)
- token_expires_at (nullable datetime)
- participation_response_id (foreign key)
- contact_person, email, phone (nullable)
- industry, description, website
```

#### Key Relationships
- `Company hasOne ParticipationResponse`
- `Company belongsToMany CV` (via cv_company pivot)
- `Company belongsTo User` (optional)

### 4. **Public Access Routes**

```php
// No authentication required
GET /company-access/{token}
    - View assigned CVs for company
    - Rate limited: 10 req/min per IP
    - Cached for 1 hour

GET /company-access/{token}/cv/{cv}
    - Download specific CV
    - Rate limited: 20 req/min per IP
    - Marks CV as viewed
    - Authorization: token must match company
```

### 5. **Admin Functionality**

#### CV Assignment
Admin assigns CVs to companies via dashboard:
- Select CV → Select Companies → Assign
- Timestamp recorded in pivot table
- Company cache cleared automatically

#### Access Link Management
Admin can:
1. **Copy Access Link** - One-click copy to clipboard
2. **Regenerate Token** - Creates new token, invalidates old link
3. **View Token** - Display full access URL
4. **Email Link** - Send link to company (future feature)

#### Admin Interface Features
- Visual distinction: "User Login" vs "Token Only" companies
- Stats showing token-only vs user-based companies
- Access link actions directly in companies table

### 6. **Security Measures**

#### Rate Limiting
```php
- Company Access: 10 requests/minute per IP
- CV Downloads: 20 requests/minute per IP
- Form Submissions: 60 requests/minute per IP/user
```

#### Caching Strategy
```php
- Company data cached for 1 hour per token
- Cache invalidated on:
  - Token regeneration
  - CV assignment changes
  - Company data updates
```

#### Logging
All access logged with:
- Company ID and name
- IP address
- Timestamp
- Action (access/download)
- CV count/ID

#### Additional Security
- HTTPS enforced in production
- Token length prevents brute force (64^62 combinations)
- Lazy loading prevention for performance
- SQL injection protection via Eloquent ORM
- CSRF protection on all forms

### 7. **User Flow**

#### Company Perspective
1. Submits interest form on homepage
2. Receives confirmation message
3. Admin sends unique access link via email
4. Company clicks link → Views assigned CVs (no login!)
5. Downloads CVs directly
6. Can bookmark link for future access

#### Admin Perspective
1. Reviews company participation responses
2. Company auto-created on form submission
3. Assigns CVs through admin dashboard
4. Copies access link and emails to company
5. Can regenerate token if link compromised
6. Monitors CV view status

### 8. **Performance Optimizations**

#### Database
- Indexed `access_token` column for fast lookups
- Eager loading relationships to prevent N+1 queries
- Select only necessary columns in queries

#### Caching
- Company data cached by token (1 hour TTL)
- Route caching enabled
- Config caching enabled
- View compilation caching

#### Query Optimization
```php
// Before
Company::with('cvs')->first(); // N+1 problem

// After
Company::with(['cvs.student' => function($query) {
    $query->select('id', 'name_with_initials', 'gpa', 'phone');
}])->first();
```

### 9. **Migration Guide**

#### For Existing Companies with User Accounts
- User login still works via `/company/dashboard`
- Token can be used alternatively
- Both access methods show same CVs

#### For New Companies
- Only token access (no user account created)
- Simpler onboarding
- No password management needed

### 10. **API Endpoints**

#### Public (Token-Based)
```
GET  /company-access/{token}           - View CVs page
GET  /company-access/{token}/cv/{cv}   - Download CV
```

#### Admin (Auth Required)
```
POST /admin/company/{id}/regenerate-token  - New token
GET  /admin/company/{id}/access-link       - Get link JSON
POST /admin/assign-cv                      - Assign CV to companies
```

### 11. **Configuration**

#### Environment Variables (if needed)
```env
# Token expiry in days (optional, null = no expiry)
COMPANY_TOKEN_EXPIRY_DAYS=null

# Rate limiting
COMPANY_ACCESS_RATE_LIMIT=10
CV_DOWNLOAD_RATE_LIMIT=20
```

### 12. **Future Enhancements**

Potential features:
- [ ] Email automation (send link automatically)
- [ ] Analytics dashboard for company access patterns
- [ ] Token expiry notifications
- [ ] Bulk token regeneration
- [ ] Company portal with additional features (via token)
- [ ] Two-factor authentication for sensitive downloads

## Benefits

### For Companies
✅ No signup/login hassle
✅ Instant access via link
✅ Bookmark-able secure link
✅ No password to remember
✅ Works on any device

### For Administrators
✅ Less user management overhead
✅ Easy link sharing
✅ Token regeneration for security
✅ Audit trail of access
✅ Simplified onboarding

### For System
✅ Reduced authentication complexity
✅ Better performance (no session management)
✅ Improved security (unique tokens)
✅ Scalable architecture
✅ Reduced database load

## Testing Checklist

- [ ] Submit company interest form with consent
- [ ] Verify Company record created with access_token
- [ ] Access public URL with token
- [ ] Verify rate limiting works (exceed 10 req/min)
- [ ] Download CV and verify viewed_status updated
- [ ] Admin: Assign CV to company
- [ ] Admin: Copy access link
- [ ] Admin: Regenerate token (old link fails)
- [ ] Verify caching works (check query count)
- [ ] Test expired token (if token_expires_at set)
- [ ] Verify logging in storage/logs

## Troubleshooting

### Token Not Working
- Check if token matches exactly (case-sensitive)
- Verify token not expired (`token_expires_at`)
- Check rate limiting (wait 1 minute)
- Clear Laravel cache: `php artisan cache:clear`

### Company Not Auto-Creating
- Ensure `will_participate = 1` in form
- Ensure `consent_to_receive_cvs = 1` checked
- Check logs: `storage/logs/laravel.log`
- Verify migration ran: `php artisan migrate:status`

### CVs Not Showing
- Verify CVs assigned in admin dashboard
- Check pivot table `cv_company` for records
- Clear cache for that company token
- Check company_id matches

## Support

For issues or questions:
1. Check logs: `storage/logs/laravel.log`
2. Verify database structure matches schema
3. Clear all caches: `php artisan optimize:clear`
4. Check rate limiting hasn't blocked IP

---

**Last Updated**: February 10, 2026
**Version**: 1.0
**Status**: Production Ready ✅
