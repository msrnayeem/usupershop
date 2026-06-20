# U Super Shop v2 🛒

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  <strong>A Multi-Vendor E-commerce Platform with Dropshipping Support</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#installation">Installation</a> •
  <a href="#user-roles">User Roles</a> •
  <a href="#documentation">Documentation</a> •
  <a href="#tech-stack">Tech Stack</a>
</p>

---

## 📖 About The Project

**U Super Shop v2** is a comprehensive multi-vendor e-commerce platform built with Laravel 8.x. It supports multiple business models including traditional e-commerce, multi-vendor marketplace, and dropshipping. The platform is specifically designed for the Bangladesh market with integrated local payment gateways (Bkash, EPS) and courier services (Steadfast, Pathao).

### 🎯 Key Highlights

- ✅ **Multi-Vendor Marketplace** - Multiple sellers can manage their own shops
- ✅ **Dropshipping Support** - Built-in dropshipper role with custom pricing
- ✅ **Commission System** - Automated commission distribution
- ✅ **Wallet Management** - Built-in financial management system
- ✅ **Courier Integration** - Direct API integration with local couriers
- ✅ **Multiple Payment Gateways** - Bkash, EPS, Cash on Delivery
- ✅ **Product Variants** - Color and size combinations with stock management
- ✅ **Referral System** - Dropshipper referral code system
- ✅ **Multi-Language** - Supports English and Bangla

---

## 🚀 Features

### For Customers
- 🛍️ Browse products by category, brand, or search
- 🎨 Product variants (colors, sizes) with dynamic pricing
- 🛒 Shopping cart with coupon support
- 💳 Multiple payment methods (Bkash, EPS, COD)
- 📦 Order tracking system
- ❤️ Wishlist management
- 👤 Profile management
- 🔐 Social login (Google, Facebook)
- 📱 OTP verification

### For Sellers/Vendors
- 📊 Sales dashboard with analytics
- 📦 Add products from admin catalog to shop
- ✨ Create custom vendor products
- 📋 Order management
- 💰 Commission tracking
- 💼 Wallet management
- 📈 Sales reports
- 💳 Payment settings
- 📜 Transaction history

### For Dropshippers
- 🎯 Browse product catalog
- 💵 Set custom product prices
- 🔗 Unique referral code system
- 📊 Profit tracking
- 💰 Commission management
- 📦 Order management
- 📈 Performance reports
- 💼 Wallet management

### For Admin
- 👥 User management (all roles)
- 📦 Product management & approval
- 📋 Order management
- ⚙️ Commission settings
- 💳 Payment gateway configuration
- 🚚 Courier management
- 📊 Reports & analytics
- 🎨 Site customization (logo, sliders, banners)
- 🏷️ Category & brand management
- 🎫 Coupon management
- 📍 Delivery zone management

---

## 👥 User Roles

### 1. **Admin** 👑
- Full system control
- Manages all users, products, and orders
- Configures system settings
- **Access:** `/login` → `/home`

### 2. **Seller/Vendor** 🏪
- Manages personal shop
- Adds products and manages orders
- Earns 80% commission (after 20% admin cut)
- **Access:** `/login` → `/seller-dashboard`
- **Registration:** `/seller/signup` (requires admin approval)

### 3. **Dropshipper** 📦
- Resells products with custom pricing
- Has unique referral code
- Earns reseller commission
- **Access:** `/login` → `/dropshipper-dashboard`
- **Registration:** `/seller/signup` (admin assigns role)

### 4. **Customer** 🛍️
- Browses and purchases products
- Tracks orders
- Manages wishlist
- **Access:** `/customer-login` → `/customer/dashboard`
- **Registration:** `/customer-signup`

---

## 💻 Tech Stack

### Backend
- **Framework:** Laravel 8.x
- **PHP Version:** 7.3+ / 8.0+
- **Database:** MySQL 5.7+ / MariaDB
- **Authentication:** Laravel Sanctum, Laravel Socialite
- **PDF Generation:** DomPDF
- **HTTP Client:** Guzzle

### Frontend
- **CSS Framework:** Bootstrap 5
- **JavaScript:** jQuery, Axios
- **DataTables:** Yajra DataTables
- **Icons:** Font Awesome
- **Build Tool:** Laravel Mix

### Third-Party Integrations
- **Payment Gateways:** Bkash, EPS
- **Courier Services:** Steadfast, Pathao
- **Social Login:** Google, Facebook OAuth
- **SMS Gateway:** Configurable

---

## 📁 Project Structure

```
usupershop_v2/
│
├── app/                                    # Application core
│   ├── Console/                           # Artisan commands
│   │   └── Kernel.php
│   │
│   ├── Exceptions/                        # Exception handling
│   │   └── Handler.php
│   │
│   ├── Http/                              # HTTP layer
│   │   ├── Controllers/                   # Controllers
│   │   │   ├── Auth/                      # Authentication controllers
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── ForgotPasswordController.php
│   │   │   │
│   │   │   ├── Backend/                   # Admin panel controllers
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── BrandController.php
│   │   │   │   ├── CustomerController.php
│   │   │   │   ├── SellerDashboardController.php
│   │   │   │   ├── DropshipperController.php
│   │   │   │   ├── DropshipperDashboardController.php
│   │   │   │   ├── CourierController.php
│   │   │   │   ├── PaymentGatewayController.php
│   │   │   │   ├── WalletController.php
│   │   │   │   └── ...
│   │   │   │
│   │   │   ├── Frontend/                  # Customer-facing controllers
│   │   │   │   ├── FrontendController.php
│   │   │   │   ├── CartController.php
│   │   │   │   ├── CheckoutController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── SellerShopController.php
│   │   │   │   ├── TrackingController.php
│   │   │   │   ├── SearchController.php
│   │   │   │   └── BkashPaymentGatewayController.php
│   │   │   │
│   │   │   ├── Api/                       # API controllers
│   │   │   │   ├── BkashPaymentGatewayController.php
│   │   │   │   └── EPSpaymentGatewayController.php
│   │   │   │
│   │   │   ├── Seller/                    # Seller-specific controllers
│   │   │   │   └── ReportController.php
│   │   │   │
│   │   │   ├── Dropshipper/               # Dropshipper-specific controllers
│   │   │   │   └── ReportController.php
│   │   │   │
│   │   │   ├── HomeController.php         # Admin dashboard
│   │   │   ├── AddToCartController.php
│   │   │   ├── CustomerCheckoutController.php
│   │   │   └── OtpVerifyController.php
│   │   │
│   │   ├── Middleware/                    # HTTP middleware
│   │   │   ├── Authenticate.php
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── SellerMiddleware.php
│   │   │   ├── DropshipperMiddleware.php
│   │   │   ├── CustomerMiddleware.php
│   │   │   └── VerifyCsrfToken.php
│   │   │
│   │   ├── Requests/                      # Form requests
│   │   └── Kernel.php                     # HTTP kernel
│   │
│   ├── Models/                            # Eloquent models
│   │   ├── User.php                       # User model (all roles)
│   │   ├── Product.php                    # Product model
│   │   ├── ProductVariant.php             # Product variants
│   │   ├── Category.php                   # Categories
│   │   ├── Subcategory.php                # Subcategories
│   │   ├── Brand.php                      # Brands
│   │   ├── Order.php                      # Orders
│   │   ├── OrderDetail.php                # Order line items
│   │   ├── Payment.php                    # Payments
│   │   ├── Shipping.php                   # Shipping info
│   │   ├── Cart.php                       # Shopping cart
│   │   ├── Wishlist.php                   # Wishlist
│   │   ├── Coupon.php                     # Coupons
│   │   ├── Transaction.php                # Financial transactions
│   │   ├── Wallet.php                     # User wallets
│   │   ├── CommissionLedger.php           # Commission tracking
│   │   ├── DropshipperReferralCode.php    # Referral codes
│   │   ├── DropshipperProfit.php          # Profit tracking
│   │   ├── DropshipperProductPrice.php    # Custom pricing
│   │   ├── Courier.php                    # Courier services
│   │   ├── DeliveryZone.php               # Delivery zones
│   │   └── ...
│   │
│   ├── Providers/                         # Service providers
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── RouteServiceProvider.php
│   │   └── EventServiceProvider.php
│   │
│   ├── Services/                          # Business logic services
│   │   └── CourierService.php             # Courier API integration
│   │
│   ├── Traits/                            # Reusable traits
│   │   ├── OrderAmountDistributionTrait.php  # Commission distribution
│   │   ├── BalanceTrait.php               # Wallet management
│   │   ├── BkashPaymentTrait.php          # Bkash integration
│   │   ├── EPSGatewayTrait.php            # EPS integration
│   │   ├── ReferCommissionTrait.php       # Referral commission
│   │   └── SendSmsTrait.php               # SMS sending
│   │
│   └── utilities/                         # Utility classes
│       ├── Constant.php                   # Application constants
│       └── Helpers.php                    # Helper functions
│
├── backend/                               # Backend assets
│   ├── calendar/                          # Calendar plugin
│   ├── css/                               # Admin CSS
│   ├── js/                                # Admin JavaScript
│   ├── plugins/                           # Admin plugins
│   │   ├── bootstrap/
│   │   └── bootstrap-colorpicker/
│   ├── sweetalert/                        # Sweet Alert
│   └── toastr/                            # Toastr notifications
│
├── bootstrap/                             # Laravel bootstrap
│   └── cache/                             # Bootstrap cache
│
├── config/                                # Configuration files
│   ├── app.php                            # Application config
│   ├── auth.php                           # Authentication config
│   ├── database.php                       # Database config
│   ├── mail.php                           # Email config
│   ├── services.php                       # Third-party services
│   ├── cart.php                           # Shopping cart config
│   ├── courier.php                        # Courier config
│   ├── session.php                        # Session config
│   └── ...
│
├── database/                              # Database files
│   ├── factories/                         # Model factories
│   ├── migrations/                        # Database migrations
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2022_08_09_150553_create_products_table.php
│   │   ├── 2022_08_24_070857_create_orders_table.php
│   │   ├── 2025_09_04_090921_create_product_variants_table.php
│   │   ├── 2025_09_19_052407_create_dropshipper_referral_codes_table.php
│   │   └── ...
│   └── seeders/                           # Database seeders
│
├── frontend/                              # Frontend assets
│   ├── assets/                            # Frontend assets
│   ├── icon/                              # Icons
│   └── images/                            # Frontend images
│       ├── bkash.png
│       ├── cash-on-delivery.png
│       └── no-image-icon.jpg
│
├── public/                                # Public directory (web root)
│   ├── css/                               # Compiled CSS
│   ├── js/                                # Compiled JavaScript
│   ├── upload/                            # Uploaded files
│   │   ├── user_images/                   # User images
│   │   ├── product_images/                # Product images
│   │   ├── category_images/               # Category images
│   │   └── ...
│   ├── .htaccess                          # Apache config
│   ├── index.php                          # Entry point
│   ├── favicon.ico                        # Favicon
│   └── robots.txt                         # Robots file
│
├── resources/                             # Resources
│   ├── css/                               # Source CSS
│   ├── js/                                # Source JavaScript
│   │   ├── app.js                         # Main JS file
│   │   └── bootstrap.js                   # Bootstrap JS
│   │
│   ├── lang/                              # Language files
│   │   ├── en/                            # English
│   │   └── bn/                            # Bangla
│   │
│   ├── sass/                              # SASS files
│   │   └── app.scss
│   │
│   └── views/                             # Blade templates
│       ├��─ admin/                         # Admin views
│       │   ├── dashboard.blade.php
│       │   ├── products/
│       │   ├── orders/
│       │   ├── users/
│       │   └── ...
│       │
│       ├── seller/                        # Seller views
│       │   ├── dashboard.blade.php
│       │   ├── products/
│       │   ├── orders/
│       │   └── ...
│       │
│       ├── dropshipper/                   # Dropshipper views
│       │   ├── dashboard.blade.php
│       │   ├── products/
│       │   ├── profits/
│       │   └── ...
│       │
│       ├── customer/                      # Customer dashboard views
│       │   ├── dashboard.blade.php
│       │   ├── orders.blade.php
│       │   ├── profile.blade.php
│       │   └── ...
│       │
│       ├── frontend/                      # Customer-facing views
│       │   ├── index.blade.php            # Home page
│       │   ├── product_list.blade.php
│       │   ├── product_details.blade.php
│       │   ├── cart.blade.php
│       │   ├���─ checkout.blade.php
│       │   ├── seller_shop.blade.php
│       │   └── ...
│       │
│       ├── auth/                          # Authentication views
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   └── passwords/
│       │
│       └── layouts/                       # Layout templates
│           ├── app.blade.php              # Main layout
│           ├── admin.blade.php            # Admin layout
│           ├── seller.blade.php           # Seller layout
│           └── frontend.blade.php         # Frontend layout
│
├── routes/                                # Route definitions
│   ├── web.php                            # Web routes (frontend)
│   ├── admin.php                          # Admin routes
│   ├── seller.php                         # Seller routes
│   ├── dropshipper.php                    # Dropshipper routes
│   ├── customer.php                       # Customer routes
│   ├── api.php                            # API routes
│   ├── channels.php                       # Broadcast channels
│   └── console.php                        # Console routes
│
├── storage/                               # Storage directory
│   ├── app/                               # Application storage
│   │   ├── public/                        # Public storage (linked)
│   │   ���── ...
│   ├── framework/                         # Framework storage
│   │   ├── cache/                         # Cache files
│   │   ├── sessions/                      # Session files
│   │   └── views/                         # Compiled views
│   ├── logs/                              # Log files
│   │   └── laravel.log                    # Application log
│   └── debugbar/                          # Debug bar storage
│
├── tests/                                 # Test files
│   ├── Feature/                           # Feature tests
│   ├── Unit/                              # Unit tests
│   └── TestCase.php                       # Base test case
│
├── vendor/                                # Composer dependencies
│
├── .env                                   # Environment variables (not in git)
├── .env.example                           # Example environment file
├── .gitignore                             # Git ignore rules
├── .htaccess                              # Apache configuration
├── artisan                                # Artisan CLI
├── composer.json                          # PHP dependencies
├── composer.lock                          # Locked PHP dependencies
├── package.json                           # Node dependencies
├── package-lock.json                      # Locked Node dependencies
├── webpack.mix.js                         # Laravel Mix config
├── phpunit.xml                            # PHPUnit config
├── server.php                             # PHP built-in server
│
├── README.md                              # This file
├── ACCESS_FLOW_DIAGRAM.md                 # User access flow
├── PANEL_ACCESS_GUIDE.md                  # Panel access guide
├── QUICK_ACCESS_REFERENCE.md              # Quick reference
├── PRODUCTION_SECURITY_ANALYSIS.md        # Security analysis
├── ORDER_PLACEMENT_FIX.md                 # Order fix documentation
├── ORDER_TESTING_GUIDE.md                 # Testing guide
└── PERMISSION_SUSPENSION_SYSTEM_ANALYSIS.md  # Permission system
```

### 📂 Key Directories Explained

#### **app/** - Application Core
Contains all the business logic, models, controllers, and services.

#### **app/Http/Controllers/**
- **Auth/** - Login, registration, password reset
- **Backend/** - Admin panel functionality
- **Frontend/** - Customer-facing functionality
- **Api/** - API endpoints for payment gateways
- **Seller/** - Seller-specific features
- **Dropshipper/** - Dropshipper-specific features

#### **app/Models/**
Eloquent models representing database tables. Each model handles its own business logic and relationships.

#### **app/Services/**
Business logic services that can be reused across controllers.

#### **app/Traits/**
Reusable code blocks that can be included in multiple classes.

#### **config/**
All configuration files for the application, including database, mail, services, and custom configs.

#### **database/migrations/**
Database schema definitions. Run `php artisan migrate` to create tables.

#### **resources/views/**
Blade templates organized by user role:
- **admin/** - Admin panel views
- **seller/** - Seller panel views
- **dropshipper/** - Dropshipper panel views
- **customer/** - Customer dashboard views
- **frontend/** - Public-facing views
- **auth/** - Authentication views

#### **routes/**
Route definitions separated by user role for better organization.

#### **public/**
Web root directory. All publicly accessible files (CSS, JS, images, uploads).

#### **storage/**
Application storage for logs, cache, sessions, and uploaded files.

---

## 📦 Installation

### Prerequisites
- PHP >= 7.3 or 8.0
- Composer
- MySQL or MariaDB
- Node.js & NPM
- Git

### Step 1: Clone Repository
```bash
git clone <repository-url>
cd usupershop_v2
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=usupershop_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Run Migrations
```bash
# Run all migrations
php artisan migrate

# (Optional) Seed database with sample data
php artisan db:seed
```

### Step 6: Storage Link
```bash
php artisan storage:link
```

### Step 7: Compile Assets
```bash
# For development
npm run dev

# For production
npm run prod
```

### Step 8: Start Development Server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

---

## ⚙️ Configuration

### Payment Gateways

#### Bkash Configuration
```env
BKASH_API_KEY=your_api_key
BKASH_SECRET_KEY=your_secret_key
BKASH_USERNAME=your_username
BKASH_PASSWORD=your_password
BKASH_BASE_URL=https://tokenized.pay.bka.sh/v1.2.0-beta
BKASH_CALLBACK_URL=https://yourdomain.com/api/callback/bkash
```

#### EPS Configuration
```env
EPS_API_URL=your_eps_url
EPS_MERCHANT_ID=your_merchant_id
EPS_STORE_ID=your_store_id
EPS_SECRET_KEY=your_secret_key
EPS_USERNAME=your_username
EPS_PASSWORD=your_password
```

### Courier Services

#### Steadfast Configuration
```env
STEADFAST_ENABLED=true
STEADFAST_BASE_URL=https://portal.packzy.com/api/v1
STEADFAST_API_KEY=your_api_key
STEADFAST_SECRET_KEY=your_secret_key
```

#### Pathao Configuration
```env
PATHAO_ENABLED=true
PATHAO_BASE_URL=https://courier-api-sandbox.pathao.com
PATHAO_CLIENT_ID=your_client_id
PATHAO_CLIENT_SECRET=your_client_secret
PATHAO_USERNAME=your_username
PATHAO_PASSWORD=your_password
PATHAO_STORE_ID=your_store_id
```

### Email Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=465
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your_email
MAIL_FROM_NAME="${APP_NAME}"
```

### Social Login
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_CALLBACK_URL=https://yourdomain.com/login/google/callback
```

---

## 🗄️ Database Structure

### Key Tables
- `users` - All user types (admin, seller, vendor, dropshipper, customer)
- `products` - Product catalog
- `product_variants` - Color/size combinations with pricing
- `categories` / `subcategories` - Product categorization
- `orders` / `order_details` - Order management
- `payments` / `shippings` - Payment and shipping info
- `transactions` / `wallets` - Financial management
- `commission_ledgers` - Commission tracking
- `dropshipper_referral_codes` - Referral system
- `dropshipper_profits` - Profit tracking
- `coupons` - Discount management
- `delivery_zones` - Delivery areas with charges
- `couriers` - Courier service records

---

## 🔐 Default Access

### Admin Panel
- **URL:** `/login`
- **Dashboard:** `/home`
- **Create admin user manually in database**

### Seller Panel
- **URL:** `/login`
- **Dashboard:** `/seller-dashboard`
- **Registration:** `/seller/signup`

### Dropshipper Panel
- **URL:** `/login`
- **Dashboard:** `/dropshipper-dashboard`
- **Registration:** `/seller/signup` (admin assigns role)

### Customer Panel
- **URL:** `/customer-login` or `/login`
- **Dashboard:** `/customer/dashboard`
- **Registration:** `/customer-signup`

---

## 📚 Documentation

Comprehensive documentation is available in the project:

- **[ACCESS_FLOW_DIAGRAM.md](ACCESS_FLOW_DIAGRAM.md)** - Visual user access flow
- **[PANEL_ACCESS_GUIDE.md](PANEL_ACCESS_GUIDE.md)** - Detailed panel access instructions
- **[QUICK_ACCESS_REFERENCE.md](QUICK_ACCESS_REFERENCE.md)** - Quick reference guide
- **[PRODUCTION_SECURITY_ANALYSIS.md](PRODUCTION_SECURITY_ANALYSIS.md)** - Security audit report
- **[ORDER_PLACEMENT_FIX.md](ORDER_PLACEMENT_FIX.md)** - Order bug fix documentation
- **[ORDER_TESTING_GUIDE.md](ORDER_TESTING_GUIDE.md)** - Testing procedures

---

## 💰 Commission System

### How It Works

1. **Order Placed** - Customer places an order
2. **Order Delivered** - Admin marks order as delivered
3. **Commission Distribution:**
   - **Admin:** 20% of order value
   - **Vendor:** 80% of order value
   - **Reseller/Dropshipper:** Percentage from admin commission
4. **Wallet Credit** - Amounts automatically credited to respective wallets
5. **Transaction Record** - All transactions logged for transparency

### Example Calculation
```
Order Value: 1000 BDT
Admin Commission (20%): 200 BDT
Vendor Amount (80%): 800 BDT

If Dropshipper Commission is 10%:
Dropshipper Commission: 20 BDT (10% of 200 BDT)
Admin Final Amount: 180 BDT (200 - 20)
```

---

## 🚚 Order Flow

1. **Customer adds products to cart**
2. **Proceeds to checkout**
3. **Fills shipping information**
4. **Selects payment method** (COD/Bkash/EPS)
5. **Order created in database**
6. **Payment processed** (if online payment)
7. **Order confirmation sent**
8. **Admin/Seller receives notification**
9. **Order processing begins**
10. **Courier assigned** (optional)
11. **Order shipped**
12. **Order delivered**
13. **Commission distributed**

---

## 🛠️ Useful Commands

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

### Run Migrations
```bash
# Run all migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Rollback specific steps
php artisan migrate:rollback --step=1

# Fresh migration (drops all tables)
php artisan migrate:fresh
```

### Queue Workers
```bash
# Run queue worker
php artisan queue:work

# Run queue worker with specific connection
php artisan queue:work redis

# Process only one job
php artisan queue:work --once
```

### Create Admin User
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Admin User',
    'email' => 'admin@usupershop.com',
    'mobile' => '01700000000',
    'password' => Hash::make('password'),
    'usertype' => 'admin',
    'status' => 1
]);
```

---

## 🔒 Security

### Before Going Live

⚠️ **CRITICAL:** Review and fix security issues before production deployment!

1. **Set Production Environment**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   LOG_LEVEL=error
   ```

2. **Change All Credentials**
   - Database password
   - API keys (Bkash, EPS, Courier)
   - Email passwords
   - Social login credentials

3. **Remove Project Expiry Check**
   - Comment out or remove expiry check in `app/Http/Controllers/Controller.php`
   - Or set far future date: `PROJECT_EXPIRY_DATE=2099-12-31`

4. **Enable HTTPS**
   - Install SSL certificate
   - Force HTTPS in `AppServiceProvider`

5. **Add Rate Limiting**
   - Protect login/registration routes
   - Prevent brute force attacks

See **[PRODUCTION_SECURITY_ANALYSIS.md](PRODUCTION_SECURITY_ANALYSIS.md)** for complete security checklist.

---

## 🧪 Testing

### Manual Testing
```bash
# Test order placement
1. Add products to cart
2. Proceed to checkout
3. Fill shipping details
4. Select payment method
5. Confirm order
6. Verify order in database
```

### Check Logs
```bash
# View latest logs
tail -f storage/logs/laravel.log

# Search for specific errors
grep "ERROR" storage/logs/laravel.log
```

### Database Verification
```sql
-- Check recent orders
SELECT * FROM orders ORDER BY id DESC LIMIT 10;

-- Check order details
SELECT * FROM order_details ORDER BY id DESC LIMIT 10;

-- Check transactions
SELECT * FROM transactions ORDER BY id DESC LIMIT 10;
```

---

## 🐛 Troubleshooting

### Common Issues

#### 1. Orders Not Being Created
- Run migration: `php artisan migrate`
- Check logs: `storage/logs/laravel.log`
- Verify database connection

#### 2. Payment Gateway Not Working
- Verify API credentials in `.env`
- Check callback URLs
- Review payment gateway logs

#### 3. Courier Integration Failing
- Verify API keys
- Check courier service status
- Review courier response logs

#### 4. Email Not Sending
- Verify SMTP settings
- Check email credentials
- Test with `php artisan tinker` and `Mail::raw()`

#### 5. Cannot Login
- Check user status in database
- Verify email is verified (code = NULL)
- For sellers: Check payment_status = 2
- Clear browser cache

---

## 📈 Performance Optimization

### For Production

1. **Enable Caching**
   ```env
   CACHE_DRIVER=redis
   SESSION_DRIVER=redis
   QUEUE_CONNECTION=redis
   ```

2. **Optimize Autoloader**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. **Cache Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

4. **Enable OPcache**
   - Configure PHP OPcache in `php.ini`

5. **Use CDN**
   - Serve static assets from CDN
   - Optimize images

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Support

For support and questions:

- 📧 Email: support@usupershop.com
- 📚 Documentation: See docs folder
- 🐛 Issues: Open an issue on GitHub

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Bootstrap](https://getbootstrap.com) - Frontend Framework
- [jQuery](https://jquery.com) - JavaScript Library
- [Yajra DataTables](https://github.com/yajra/laravel-datatables) - Server-side DataTables
- All contributors and supporters

---

## 📊 Project Status

- ✅ Core Features: Complete
- ✅ Multi-Vendor: Complete
- ✅ Dropshipping: Complete
- ✅ Payment Integration: Complete
- ✅ Courier Integration: Complete
- ⚠️ Security Review: Required before production
- 🔄 Testing: Ongoing

---

## 🗺️ Roadmap

### Planned Features
- [ ] Mobile application (iOS/Android)
- [ ] Advanced analytics dashboard
- [ ] Customer review and rating system
- [ ] Product comparison feature
- [ ] Multi-currency support
- [ ] Advanced inventory management
- [ ] Email marketing automation
- [ ] Real-time notifications
- [ ] Live chat support
- [ ] AI-powered product recommendations

---

## 📸 Screenshots

### Customer Frontend
- Home page with featured products
- Product listing with filters
- Product details with variants
- Shopping cart
- Checkout process

### Admin Panel
- Dashboard with analytics
- Product management
- Order management
- User management

### Seller Panel
- Sales dashboard
- Product management
- Order tracking

### Dropshipper Panel
- Product catalog
- Custom pricing
- Profit tracking

---

<p align="center">
  <strong>Built with ❤️ using Laravel</strong>
</p>

<p align="center">
  <sub>Version 2.0 | Last Updated: January 2026</sub>
</p>
