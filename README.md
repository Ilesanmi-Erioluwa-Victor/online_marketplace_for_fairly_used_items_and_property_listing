# Fairly Marketplace

Plain PHP 8.2+ web application for an online marketplace for fairly used items and property listings. It uses PostgreSQL on Supabase, Supabase Storage for listing images, Brevo transactional email, and Paystack TEST mode only for paid featured listings.

## Demo Credentials

Run `database/schema.sql`, then `database/seed.sql`.

- Admin: `admin@fairlymarket.ng` / `Admin@1234`
- Regular demo users: `chinedu@example.com`, `aisha@example.com`, `tunde@example.com` / `Demo@1234`
- All seeded regular users are verified so they can post listings immediately.

## Local Setup

1. Copy `.env.example` to `.env` and fill in real values. Do not commit `.env`.
2. Run `composer install`.
3. Create a Supabase project, open the SQL editor, run `database/schema.sql`, then run `database/seed.sql`.
4. Create a public Supabase Storage bucket named in `SUPABASE_STORAGE_BUCKET`, for example `marketplace-images`.
5. Create a Brevo API key and verified sender email, then set `BREVO_API_KEY` and `BREVO_SENDER_EMAIL`.
6. Create Paystack TEST API keys and set only `sk_test_...` and `pk_test_...` values. Live keys must not be used.
7. Start locally with `php -S 0.0.0.0:8000 -t public public/index.php`.

## Render Deployment

This repo includes `render.yaml`.

- Build command: `composer install --no-dev --optimize-autoloader`
- Start command: `php -S 0.0.0.0:$PORT -t public public/index.php`
- Set all variables from `.env.example` in Render dashboard.
- Set `APP_ENV=production` and `APP_URL` to the Render service URL.

## Architecture

- `public/index.php`: front controller with explicit routes.
- `src/Core`: PDO database, router, auth/session, CSRF, validation, Brevo mailer, Supabase upload, Paystack wrapper.
- `src/Models`: prepared-query model helpers.
- `src/Controllers`: MVC-style controllers for auth, listings, search, messaging, profile, admin, payments, homepage.
- `views`: hand-written PHP templates.
- `public/css/style.css` and `public/js/*.js`: no Bootstrap, Tailwind, jQuery, or UI framework.

## Requirement Map

- 0 Tech stack: `composer.json`, `render.yaml`, `public/index.php`, `config/config.php`, `.env.example`.
- 1 Concept: separate item/property flows in `src/Models/ItemListing.php`, `src/Models/PropertyListing.php`, `views/items`, `views/properties`.
- 2.1 Auth/user management: `AuthController.php`, `ProfileController.php`, `User.php`, `views/auth`, `views/profile`.
- 2.2 Item listings: `ItemController.php`, `ItemListing.php`, `views/items`.
- 2.3 Property listings: `PropertyController.php`, `PropertyListing.php`, `views/properties`.
- 2.4 Search/filtering: `SearchController.php`, item/property `all()` filters, browse views.
- 2.5 Image upload: `Upload.php`, listing/profile controllers, Supabase Storage URLs in `listing_images`.
- 2.6 Messaging: `MessageController.php`, `Conversation.php`, `Message.php`, `views/messages`, Brevo notice email.
- 2.7 Admin panel: `AdminController.php`, `views/admin`.
- 2.8 Notifications: `Mailer.php`, `views/emails`, auth/admin/message/payment controllers.
- 2.9 Homepage/UX: `HomeController.php`, `views/home/index.php`, `public/css/style.css`.
- 2.10 Featured payments: `Payment.php`, `PaymentController.php`, `featured_listings`, Paystack TEST key guard.
- 3 Database schema: `database/schema.sql`.
- 4 Project structure: folders and files match the requested tree; extra partials keep templates readable.
- 5 Color scheme: CSS variables in `public/css/style.css`.
- 5a PSR-4 autoloading: `composer.json` maps `App\\` to `src/`.
- 6 Seed data: `database/seed.sql` includes Nigerian users, listings, images, messages, reports, and featured rows.
- 7 Render requirements: `.env.example`, `render.yaml`, Composer start script.
- 8 Quality: prepared statements, CSRF on mutations, `htmlspecialchars` output escaping, server/client validation, PHP lint verified.

## Notes

- Buyer-to-seller and tenant-to-landlord payments are intentionally not processed. The platform supports discovery and in-app communication only.
- Paystack is only used for sellers/landlords paying the platform to feature active listings.
- Seeded image URLs use placeholders. Real uploads go to Supabase Storage and store public URLs in PostgreSQL.
- Server-side thumbnail generation is skipped to keep dependencies light; CSS constrains image display. A future improvement would add image resizing and thumbnail generation.
