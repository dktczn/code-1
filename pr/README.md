# PAROKO — Full-Stack PHP + SQLite Commerce CMS

A framework-free, mobile-first PHP + SQLite ecommerce + content-management system rebuilt around the supplied Shopzone/PAROKO reference.

## Stack
- PHP 8.1+
- SQLite via PDO SQLite
- Tailwind CSS CDN
- Alpine.js
- Iconify
- Apache `.htaccess` + PHP built-in `router.php` for pretty URLs

## Storefront
- Gadgets / Jersey / Fashion switcher
- SEO-friendly post type URLs:
  - `/gadgets`
  - `/jersey`
  - `/fashion`
  - `/articles`
  - `/docs`
  - `/pages`
- Individual content URLs: `/articles/football-jersey-size-guide`
- Product URLs: `/product/real-madrid-home-jersey-24-25`
- Category URLs: `/category/jersey/club-jerseys`
- Responsive/mobile-first layout
- Dark + blue/purple/teal gradient-600 visual system
- Shiny/animated CTA and card accents
- Search, wishlist and compare
- Product variants, stock and low-stock handling
- Jersey name + number customization
- AJAX cart
- Guest checkout
- COD / bKash / Nagad / Rocket / SSLCommerz options
- Order success + order tracking
- Product reviews with moderation
- Content comments with moderation
- Contact request inbox

## Admin CMS
The admin sidebar now includes:

**Commerce:** Products, Categories & Tags, Orders, Inventory, Coupons

**Post Types:** Gadgets, Jersey, Fashion, Articles, Docs, Pages

Each post type uses the same full content engine with:
- Create/edit
- SEO slug
- Draft / Published / Private
- Public / Members visibility
- Category
- Tags
- Featured
- Cover image
- SEO title/description/keywords
- Schema type
- Bulk select
- Bulk publish
- Bulk draft
- Bulk private
- Bulk tag assignment
- Bulk category assignment
- Bulk delete

**Content & Site Builder:**
- Media Library / upload browser
- Menus Builder: header / footer / off-canvas
- Widgets Maker: category-wise posts / CTA / banner / announcement / HTML
- Shortcodes Maker: label / text / HTML / button

**Growth & Moderation:**
- Engagement
- Wishlist / Compare analytics
- Reviews moderation
- Comments moderation
- Contact Requests moderation
- SEO / Schema / Speed
- Sitemap importer
- Users & Permissions

**Settings:**
- Site identity
- Logo / favicon
- Currency selector: BDT / INR / USD
- Delivery / printing charges
- bKash / Nagad / SSLCommerz key + secret fields
- Social links
- Meta Pixel / CAPI / Google Analytics fields
- SEO robots/schema
- Speed flags
- Header/footer code

## Database
`storage/sqlite.db` is included with demo data.

## Admin login
URL: `/admin/login.php`

Email: `admin@paroko.test`
Password: `password`

Change the password before using the site publicly.

## Local run
Requires PHP with `pdo_sqlite` enabled.

```bash
./run.sh
```

or:

```bash
php -S localhost:8000 router.php
```

Then open `http://localhost:8000/`.

## Apache/shared hosting
Point the document root to the project folder and ensure `.htaccess` overrides are enabled. PHP must have the SQLite PDO extension enabled.

## Production integrations
The UI and configuration fields for payment, courier, SMS, Meta CAPI and social integrations are included. Live provider requests/webhook verification still need the relevant merchant credentials and provider-specific API calls.

## Latest upgrades
- Product edit screen with real file upload only (no image URL fields).
- Multiple gallery image uploads with remove controls.
- Protected ZIP/digital-product files stored outside public uploads.
- One-time random 15-minute secure download tokens bound to the logged-in purchaser.
- Buyer-only download checks against completed/non-cancelled order history.
- Rich text + HTML-source editor for products, posts and shortcodes without an API key.
- Bulk category assign/remove, bulk tag add/remove/clear, bulk status changes and bulk delete.
- Widget Edit/Delete/Enable/Disable and default homepage widgets.
- Full customer profile editing with avatar upload, address/company/city/country fields, order view and protected downloads.
- Product description content/review/download tabs with 200-word preview + Show more.
- CMS content pages and products now avoid manual image URL entry.
- Typography/UI preset settings for font, base size, heading weight, radius and gradient preset.

### Tiptap note
The supplied Tiptap PHP documentation describes using Tiptap content in PHP/Laravel and persisting editor HTML. This framework-free build uses a lightweight self-contained rich editor because the project is plain PHP + SQLite; no Tiptap API key is required.


## V3 Visual Upgrade

The storefront now uses the supplied mobile references as the visual direction: dark #588580 teal preset, soft-gold light cards, iPhone-style shine borders, AJAX niche tabs, AJAX shop-by-category and admin homepage visibility controls.
