# Hope & Care Orphanage Website

Laravel-based orphanage and children's charity management platform using Blade, Tailwind CSS, MySQL, and Chart.js.

## Main URLs
- Public website: `/`
- Donor/user login: `/login`
- User registration: `/register`
- User/donor dashboard: `/dashboard`
- Administrator login: `/admin/login`
- Administrator dashboard: `/admin/dashboard`

The admin portal and donor portal use separate URLs and authorization checks. Visiting `/admin/login` displays the administrator sign-in form. Only accounts with administrator access can enter the admin area.

## Features in this repository
- Public pages, donation forms, donation checkout/webhook foundations and receipts
- Separate donor and volunteer portals
- Admin dashboard with live database metrics, donation chart, recent activity, campaign progress and quick links
- Children, donations, recurring donations, campaigns, volunteers, expenses and inventory management
- Education and healthcare records
- Events, CMS/news posts, gallery, messages and newsletter
- Reports, PDF/CSV export foundations, notifications, audit logs, roles and permissions
- Account authentication, password reset, email verification and optional two-factor authentication

## Local setup with Laravel Herd (Windows)
1. Install and open Laravel Herd.
2. Clone the repository into Herd's sites folder, for example `C:\\Users\\YOUR_NAME\\Herd\\orphanage-website`.
3. Open PowerShell in the project folder.
4. Copy `.env.example` to `.env` and set the database credentials for a MySQL database you created locally.
5. Run:

   ```powershell
   composer install
   php artisan key:generate
   php artisan migrate --seed
   npm install
   npm run build
   ```

6. In Herd, add/link the project if it is not automatically detected, then open the Herd domain it assigns (usually `http://orphanage-website.test`). You can alternatively run `php artisan serve` and open `http://127.0.0.1:8000`.

## General setup
1. Install PHP 8.2+, Composer, Node.js/npm, and MySQL.
2. Copy `.env.example` to `.env` and set the database credentials.
3. Run:

   ```bash
   composer install
   php artisan key:generate
   php artisan migrate --seed
   npm install
   npm run build
   php artisan serve
   ```

4. Open the app at `http://127.0.0.1:8000`.

## Create an administrator securely
Register a normal account first at `/register`, then run this command from the project directory:

```bash
php artisan app:make-admin your-email@example.com
```

Replace the example email with the account you registered. Then sign in at `/admin/login`. The command grants admin access to an existing user; it does not create a public default administrator or hard-code a password.

## Important
- Configure email and payment gateway credentials in environment variables before enabling live use.
- Set the payment provider's webhook URL to `/payments/webhook` and verify the provider configuration before accepting real donations.
- Do not commit `.env`, API keys, or production credentials.
- Before production, test migrations and all management flows on a staging database and review child privacy/access controls.
