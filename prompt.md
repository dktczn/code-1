Same to same aisa bnao ye design ai se bnaya hu card ko dekho uska iphone style  wala shine border color preset dark me assets #588580 aur card bg #588580 light mode me vo soft gold colour and black white ka combination same to same tab switching ajax shop by category and banners widget home ka off krne ka option dena @Thinking PAROBEST SELLERS
Best Selling Gadgets ye 2 2 title kyu de rhe ho 1 hi do pure script ko dark and light mode ka class lga ke same bnao abhi bhi kuch kuch jagah White section dikh rha dak mode ligh mode switcher lga do and admin me mai dekh rha hu ki edit page new page me nhi khul rha new me kholo aur vo text + html content editor dikh hi nhi rha use add kro and input me thoda bhi style bhi nhi hai sabhi sruken hai 0px padding ke sath usme classes padding add kro thik kro ye jo gradient animation hai use htao aur banner only img wale rakho contain size ke sath mostly 16:5 ka banner bnaunga card me jitna option hai utna hi dalo compare cart button category name and wishlist ka bg and border htao and off section ko bg add kro light dark mode swich button on header before cart 🛒 @Thinking  3 grid responsive load more ajax button no sticky section and gallery no download option needed add releted product review section with star

KO — React + SQLite Full-Stack E-commerce & CMS
Build a complete production-style full-stack ecommerce + CMS application named PAROKO, using the uploaded screenshot 10385.jpg as the primary visual/UI reference.
The application must be React-based, mobile-first, modern, premium and highly responsive, with the storefront closely matching the screenshot's visual hierarchy, spacing, cards, typography, dark/light themes, navigation, category switcher, product grids, banners and bottom mobile navigation.
Mandatory technology stack
Use only:
React + Vite
Node.js + Express
SQLite using better-sqlite3
Tailwind CSS
Iconify icons
Local filesystem storage for uploads
React Router
Fetch API
Local session/JWT authentication
Zod or equivalent validation
No external database
No Firebase
No Supabase
No MongoDB
No PostgreSQL
No MySQL
No external CMS
No mandatory third-party backend
No image URL input where an upload UI makes sense
The application must run completely locally with:
npm install
npm run dev

Use SQLite at:
/server/data/paroko.db

All database tables must be created automatically on first start and seed realistic demo content.

1. PRIMARY DESIGN REFERENCE
Use the uploaded screenshot as the main design direction.
The mobile storefront should look extremely close to the screenshot:
premium ecommerce UI
compact spacing
rounded cards
large promotional hero
bold typography
dark and light theme presets
category switcher
icon-driven navigation
floating wishlist/cart counters
horizontally scrollable product sections
category icon circles
discount badges
ratings
bottom mobile navigation
modern CTA cards
high-quality product imagery
smooth transitions
subtle shadows
soft gradients
glass/shine effects where appropriate
Do not make the UI look like a generic Bootstrap dashboard.
Do not use rainbow gradients everywhere.
Use a controlled design-token system.

2. COLOR PRESET SYSTEM
Create an admin-controlled design system.
Default preset:
Preset: Gradient 600

Primary colors:
primary-600
secondary-600
accent-600

Create presets such as:
Midnight
Ocean
Emerald
Royal
Amber
Slate

Each preset controls:
primary color
secondary color
accent color
gradient
buttons
badges
active tabs
links
cards
focus states
The UI should use CSS variables/Tailwind tokens instead of hardcoded colors everywhere.

3. TYPOGRAPHY SYSTEM
Create an admin setting for:
Font family
Body font size
Heading font size
Heading font weight
Button font weight
Letter spacing
Line height
Border radius
Card radius
Button radius
Store all typography settings in SQLite.
The frontend should automatically use these values.

4. STOREFRONT NICHES
Main categories:
Gadgets
Jersey
Fashion

Additional content types:
Articles
Docs
Pages

The main category switcher should behave like the screenshot.
Desktop:
GADGETS | JERSEY | FASHION

Mobile:
GADGETS
JERSEY
FASHION

Switching category should dynamically update:
Hero
Banner
Featured products
Best sellers
Category icons
CTA cards
Offers
Theme accent
Product sections
Category title
SEO data
Do not create separate hardcoded websites.
Use one dynamic content system.

5. MOBILE-FIRST STOREFRONT
Mobile is the primary design target.
Create:
Header
☰
PAROKO
♡
🛒

Then:
Search products...

Then:
Gadgets | Jersey | Fashion

Then hero.
Desktop should progressively enhance the same layout.

6. MOBILE BOTTOM NAVIGATION
Create fixed bottom navigation:
Home
Categories
Search
Wishlist
Account

Show live counters.
Example:
Wishlist 3
Cart 2

Icons must come from Iconify.

7. HOMEPAGE STRUCTURE
Homepage must include:
Announcement Bar
Header
Search
Niche Switcher
Hero Banner
Trust/Feature Strip
Best Selling Products
Shop By Category
Exclusive Offers
Bulk Order CTA
New Arrivals
Featured Products
Combo Offers
Articles
Why Choose PAROKO
Reviews
Newsletter
Footer
Mobile Bottom Navigation

All major homepage blocks must be controlled from admin Widgets.

8. GADGET HOMEPAGE
Create screenshot-style content:
NEW ARRIVAL

SMART TECH
FOR SMART LIFE

Latest Gadgets at
Best Prices

[ EXPLORE GADGETS ]

Featured products:
X9 Pro Smartwatch
AirBuds X Pro
SoundBox Mini
PowerBank

Categories:
Smartwatch
Earphones
Speakers
Chargers
Power Banks
Accessories


9. FASHION HOMEPAGE
Create screenshot-style content:
NEW COLLECTION

STAY STYLISH
EVERYDAY

Premium Quality Fashion
For You

[ SHOP FASHION ]

Products:
Premium Hoodie
Oversized T-Shirt
Cargo Pants
Sneakers

Categories:
T-Shirts
Shirts
Pants
Jackets
Shoes
Hoodies


10. JERSEY HOMEPAGE
Create:
NEW SEASON
WEAR YOUR TEAM

Club
National
Custom
Football
Cricket
Retro
Kids

Support:
Name
Number
Size
Color
Printing


11. PRODUCT SYSTEM
Products must support:
title
slug
SKU
description
short description
price
sale price
compare price
cost price
stock
low-stock threshold
category
multiple categories
tags
brand
status
visibility
featured
best seller
new arrival
rating
reviews
SEO title
SEO description
keywords
canonical URL
schema type
warranty
shipping information
return information
specifications

12. PRODUCT VARIATIONS
Variation-level inventory.
Support:
Color
Size
Material
Style

Each variation may contain:
SKU
Price
Sale Price
Stock
Low Stock Threshold
Image
Barcode
Status

Example:
Brazil Jersey
M / Black / 12
L / Black / 8
XL / Black / 3
XXL / Black / 0


13. PRODUCT GALLERY
Never ask the admin to manually enter image URLs for normal product images.
Create:
Upload Cover Image
Upload Gallery Images

Support:
drag and drop
multiple upload
preview
reorder
delete
set featured image
alt text
caption
image title
image compression metadata
Store files locally.
Example:
/server/storage/media/


14. PRODUCT EDITOR
Product admin must have a clearly visible:
Edit

button in the products table.
Editor tabs:
General
Pricing
Inventory
Variations
Gallery
Content
SEO
Shipping
Downloads
Reviews
Advanced

Every field must be editable.

15. PROFESSIONAL CONTENT EDITOR
Do not use a plain textarea for long-form content.
Build a professional editor inspired by modern editors such as Tiptap.
Support:
Paragraph
H1
H2
H3
Bold
Italic
Underline
Strike
Inline code
Code block
Blockquote
Ordered list
Unordered list
Alignment
Link
Image
Horizontal rule
Table
Undo
Redo
Text color
Highlight
HTML/source mode

Important:
The editor must support both:
Visual mode
HTML mode

Store the resulting HTML safely in SQLite.
Sanitize HTML before rendering.
Use a locally bundled editor or an npm package.
Do not require an external API key.

16. PRODUCT FRONTEND LAYOUT
Product page should follow this structure:
Breadcrumb
Gallery
Product Meta
Title
Rating
Price
Discount
Stock
Variants
Customization
Quantity
Add to Cart
Buy Now
Wishlist
Compare
Trust Features

Then:
Description
Specifications
Shipping
Reviews

Use tabs.

17. PRODUCT DESCRIPTION PREVIEW
On product/post cards/detail pages:
Show approximately the first 200 words.
Display:
... Show More →

When clicked:
expand content

Optionally provide:
Show Less


18. JERSEY CUSTOMIZATION
For jersey products support:
Size
Color
Custom Name
Custom Number
Printing

Example:
Brazil Jersey
XL
Name: MAYNUL
Number: 10
Printing: Name + Number

These values must be stored on the order item, not only the product.

19. DIGITAL PRODUCT DOWNLOADS
Products may contain downloadable ZIP/files.
Admin product editor:
Downloads
--------------------------------
Upload protected file
File name
File size
Version
Description
Access enabled
Expiry

Never store downloadable files in a public folder.
Use:
/server/storage/private/downloads/

Direct browser access must be impossible.
Download flow:
Customer Login
     ↓
Open My Downloads
     ↓
Generate secure token
     ↓
Verify order
     ↓
Verify purchased product
     ↓
Verify token
     ↓
Stream file

Generate cryptographically secure random tokens.
Example:
/download/7e8a...random-token

Before every download verify:
authenticated user
order exists
order belongs to user
order is paid or valid COD policy is fulfilled
product exists in order
download is enabled
token is valid
token is not expired

Prevent:
direct ZIP access
guessing filenames
path traversal
unauthorized download
hotlinking
public directory listing

20. CART
AJAX cart.
Support:
add
remove
quantity update
variation update
custom name
custom number
cart count
subtotal
shipping
discount
total
Use optimistic UI updates where safe.

21. CHECKOUT
Guest checkout must work.
Fields:
Full Name
Email
Phone
Country
City
Area
Postal Code
Full Address
Notes
Payment Method

Payment methods:
COD
bKash
Nagad
Rocket
SSLCommerz

Keep payment providers behind interfaces/services.
The application must work in demo/local mode without real API credentials.

22. CUSTOMER ACCOUNT
Create a complete account system.
Pages:
Dashboard
My Profile
Edit Profile
My Orders
Order Details
Track Order
Wishlist
Compare
Downloads
Reviews
Addresses
My Information
Logout

User profile must support:
Name
Profile photo
Email
Phone
Alternate phone
Company
Country
Division
City
Area
Postal Code
Address
Bio

Profile image must use upload.
No image URL input.

23. REVIEWS + COMMENTS + CONTACT MODERATION
Create moderation system for:
Reviews
Statuses:
Pending
Approved
Rejected
Spam

Comments
Same moderation.
Contact Requests
Statuses:
New
Read
Replied
Closed
Spam

Admin must be able to:
view
edit
approve
reject
delete
bulk update
bulk delete
search
filter

24. ADMIN CONTENT TYPES
Admin sidebar must contain:
Dashboard

Store
├── Products
├── Categories
├── Tags
├── Brands
├── Attributes
├── Inventory
├── Orders
├── Coupons
└── Reviews

Content
├── Gadgets
├── Jersey
├── Fashion
├── Articles
├── Docs
└── Pages

Appearance
├── Widgets
├── Menus
├── Header
├── Footer
├── Off Canvas
├── Shortcodes
├── Theme Presets
└── Typography

Media
└── Media Library

Engagement
├── Wishlist
├── Compare
├── Comments
└── Contact Requests

SEO
├── Meta
├── Sitemap
├── Schema
├── Robots
└── Redirects

Marketing
├── Banners
├── CTAs
├── Flash Sales
└── Offers

Settings
├── General
├── Currency
├── Payments
├── Shipping
├── Social
├── Logo & Favicon
├── Users
├── Roles
├── Permissions
└── Performance


25. BULK SELECT SYSTEM
Every listing page must support:
[ Select All ]
[ Bulk Delete ]
[ Bulk Publish ]
[ Bulk Draft ]
[ Bulk Private ]
[ Bulk Category ]
[ Bulk Remove Category ]
[ Bulk Add Tags ]
[ Bulk Remove Tags ]
[ Bulk Clear Tags ]

Example flow:
☑ Product A
☑ Product B
☑ Product C

Bulk Action:
[ Assign Category ▼ ]
[ Add Tag ▼ ]
[ Remove Tag ▼ ]
[ Delete ]

This must work for:
Products
Gadgets
Jersey
Fashion
Articles
Docs
Pages
Reviews
Comments
Contacts
Media


26. TAG MANAGEMENT
Support hierarchical category management and flat tags.
Tags must support:
name
slug
description
color
status

Bulk tag assignment must work without reloading the entire page.

27. CATEGORIES
Categories support:
name
slug
parent
type
description
icon
image
banner
SEO title
SEO description
status
sort order

Types:
Gadgets
Jersey
Fashion
Articles
Docs
Pages


28. SEO-FRIENDLY URL STRUCTURE
Create clean frontend URLs.
Examples:
/gadgets
/jersey
/fashion

/gadgets/smartwatch
/jersey/club-jerseys
/fashion/t-shirts

/product/real-madrid-home-jersey
/article/how-to-choose-a-jersey
/docs/shipping-information
/page/about-us

No URLs like:
?id=123
?page=4

Admin may internally use IDs but frontend URLs must be slug-based.

29. SEO SYSTEM
Each content object supports:
SEO title
SEO description
SEO keywords
canonical
robots
OG title
OG description
OG image
Twitter title
Twitter description
Schema type

Automatically generate:
sitemap.xml
robots.txt
JSON-LD
Open Graph
Twitter metadata


30. SITEMAP IMPORTER
Admin page:
SEO → Sitemap Importer

Input:
Sitemap URL

Import:
Products
Articles
Pages
Categories

Show:
URL
Detected title
Type
Import status

Allow:
Import selected
Import all
Skip duplicates

Do not require external database services.

31. MEDIA LIBRARY
Create WordPress-style media library.
Features:
Upload
Drag & Drop
Grid
List
Search
Filter
Delete
Rename
Alt Text
Caption
Copy internal media path

Support:
jpg
jpeg
png
webp
gif
svg
pdf
zip
doc
docx

Protect dangerous extensions.
Create thumbnails for images.

32. WIDGET BUILDER
Widgets must be fully editable.
Fields:
Widget Name
Title
Subtitle
Content
HTML Content
CTA Text
CTA URL
Icon
Image
Background
Preset
Category
Niche
Position
Sort Order
Enabled

Actions:
Edit
Duplicate
Delete
Enable
Disable

Important:
Every widget row must show:
Edit | Disable | Delete


33. DEFAULT HOMEPAGE WIDGETS
Seed these widgets:
Hero Banner
Trust Features
Best Selling Products
Shop By Category
Exclusive Offer
Bulk Order CTA
New Arrivals
Combo Offer
Newsletter
Why Choose Us
Reviews

All must be editable from admin.

34. WIDGET TARGETING
Widgets should be assignable to:
Homepage
Gadgets
Jersey
Fashion
Articles
Docs
Pages

Also support:
Desktop
Tablet
Mobile


35. MENU BUILDER
Create:
Header Menu
Footer Menu
Mobile Menu
Off Canvas Menu

Each menu item:
Label
URL
Icon
Parent
Open New Tab
Enabled
Sort Order

Support drag/drop nesting.

36. SHORTCODE BUILDER
Admin must allow:
Shortcode Name
Shortcode Key
Type
HTML Content
Text Content
Button Label
Button URL
Icon
Status

Example:
Name:
Contact CTA

Shortcode:
[contact-cta]

HTML:
<div class="rounded-2xl ...">
   ...
</div>

Rendering:
{{contact-cta}}

or:
[contact-cta]

Use a safe shortcode parser.
Never execute arbitrary PHP from the database.
Only render sanitized HTML.

37. ARTICLE / DOC / PAGE EDITOR
All use the same professional editor system.
Types:
Article
Documentation
Page

Fields:
Title
Slug
Excerpt
Content
Featured Image
Category
Tags
Author
Status
Visibility
Publish Date
SEO
Schema


38. ADMIN PRODUCT TABLE
Table layout:
☑
Image
Product
SKU
Category
Price
Stock
Status
Updated
Actions

Actions:
Edit
Duplicate
View
Delete

On mobile convert table into cards.

39. ADMIN DESIGN
Admin itself must be modern.
Use:
sidebar
collapsible sidebar
mobile off-canvas navigation
top bar
breadcrumbs
command/search
dashboard cards
charts
tables
filters
modals
drawers
toasts
skeleton loaders
empty states
Use Iconify icons everywhere.
Avoid emoji as UI icons.

40. ADMIN DASHBOARD
Dashboard cards:
Revenue
Orders
Customers
Products
Pending Orders
Low Stock
Reviews Pending
Contacts

Charts:
Sales
Orders
Visitors
Top Products

Recent activity:
Recent Orders
Recent Reviews
Low Stock
Recent Contact Requests


41. AUTHENTICATION
Create:
Admin Login
Customer Login
Customer Registration
Logout
Forgot Password

Roles:
Super Admin
Admin
Manager
Editor
Support
Customer

Create granular permissions:
products.view
products.create
products.edit
products.delete
orders.view
orders.edit
orders.delete
media.manage
widgets.manage
settings.manage
seo.manage
users.manage


42. SECURITY
Implement:
password hashing
CSRF
rate limiting
input validation
XSS sanitization
SQL prepared statements
secure sessions
secure cookies
authorization checks
upload MIME validation
file extension validation
filename randomization
path traversal prevention
secure download authorization
admin permission checks

43. SQLITE DATABASE
Create database tables for at minimum:
users
roles
permissions
role_permissions

products
product_variants
product_images
product_specs

categories
tags
product_tags
category_tags

orders
order_items
payments
shipments

downloads
download_tokens

reviews
comments
contact_requests

media
widgets
menus
menu_items

shortcodes

articles
docs
pages

coupons
wishlists
comparisons

settings
seo_meta
redirects

banners
ctas

activity_logs

Use foreign keys and indexes.

44. LOCAL STORAGE ARCHITECTURE
Use:
/server/storage/
    media/
    private/
       downloads/
    avatars/
    logos/
    favicons/

Only public-safe assets should be exposed through a static route.
Protected downloads must be streamed through Express.

45. API ARCHITECTURE
Create REST APIs.
Examples:
GET    /api/products
GET    /api/products/:slug
POST   /api/products
PUT    /api/products/:id
DELETE /api/products/:id

GET    /api/categories
POST   /api/categories

GET    /api/cart
POST   /api/cart
PUT    /api/cart/:id
DELETE /api/cart/:id

POST   /api/checkout

GET    /api/orders
GET    /api/orders/:id

POST   /api/wishlist
DELETE /api/wishlist/:id

GET    /api/search

GET    /api/widgets
GET    /api/menus

GET    /api/articles/:slug
GET    /api/docs/:slug
GET    /api/pages/:slug

Admin APIs must require admin authorization.

46. NO EXTERNAL DATABASE
Everything must work with:
SQLite

No cloud DB.
No Supabase.
No Firebase.
No external storage requirement.
No external CMS.

47. IMAGE / FILE UPLOAD API
Use multipart upload.
Examples:
POST /api/media/upload
POST /api/products/:id/gallery
POST /api/products/:id/download
POST /api/profile/avatar
POST /api/settings/logo
POST /api/settings/favicon

Return internal file IDs/paths rather than asking admins to paste external URLs.

48. SEARCH
Search fields:
Product title
SKU
Description
Short description
Category
Tag
Brand
Article title
Page title
Docs title

Live suggestions.
Show:
Products
Categories
Articles
Pages
Docs


49. WISHLIST + COMPARE
Wishlist:
Add
Remove
Count
View list
Move to Cart

Compare:
Add
Remove
Compare up to 4
Specifications side-by-side


50. ORDERS
Order statuses:
Pending
Confirmed
Processing
Ready to Ship
Shipped
Delivered
Cancelled
Returned
Refunded
Failed

Admin can change status.
Store:
customer
items
variants
price
discount
shipping
payment
courier
tracking
notes


51. COUPONS
Support:
Fixed discount
Percentage discount
Minimum order
Maximum discount
Usage limit
Start date
End date
Status


52. SETTINGS
Create a comprehensive settings panel.
General
Site Name
Tagline
Email
Phone
Address
Timezone

Currency
Support:
BDT
INR
USD

Store currency symbol and formatting.
Payment
Fields:
bKash API Key
bKash Secret
Nagad API Key
Nagad Secret
SSLCommerz Store ID
SSLCommerz Store Password

Do not expose secrets in frontend responses.
Social
Facebook
Instagram
YouTube
TikTok
WhatsApp
Telegram

Branding
Logo upload
Favicon upload
Default OG image upload

Performance
Lazy Images
Cache
Minify
Prefetch
Compression


53. ADMIN LIVE CUSTOMIZATION
Whenever the admin changes:
Color
Typography
Widgets
Menus
Logo
Favicon
Homepage blocks
SEO

the frontend should automatically use the saved SQLite configuration.

54. RESPONSIVE REQUIREMENT
Test at:
360px
390px
430px
768px
1024px
1280px
1440px

No horizontal overflow.
Product cards should be:
2 columns mobile
3 columns tablet
4 columns desktop


55. ANIMATIONS
Use subtle animations:
fade
slide
scale
hover lift
shine
skeleton
drawer
modal
toast

Do not over-animate.
Use GPU-friendly CSS transitions.

56. IMAGE DESIGN
Use large, clean ecommerce imagery.
The uploaded screenshot is the design reference, not a source of copyrighted product assets.
Use local demo images or generated placeholders for seeded data.
All production images must be replaceable through admin upload.

57. PERFORMANCE
Optimize for:
lazy loading
pagination
SQLite indexes
debounced search
image dimensions
compressed uploads
caching
code splitting
route-level loading
skeleton UI


58. PROJECT STRUCTURE
Use a clean structure like:
paroko/
├── client/
│   ├── src/
│   │   ├── components/
│   │   ├── pages/
│   │   ├── layouts/
│   │   ├── hooks/
│   │   ├── lib/
│   │   ├── store/
│   │   └── styles/
│   └── ...
│
├── server/
│   ├── routes/
│   ├── controllers/
│   ├── services/
│   ├── middleware/
│   ├── db/
│   ├── uploads/
│   ├── storage/
│   └── index.js
│
├── package.json
└── README.md


59. SEED DATA
Seed:
3 main niches
20+ categories
30+ products
product variants
tags
articles
docs
pages
reviews
comments
contacts
widgets
menus
shortcodes
coupons
admin users
customer users

Use realistic Bangladesh-style demo data and BDT prices.

60. DEMO ADMIN
Create:
Email:
admin@paroko.test

Password:
password

Create a customer demo account as well.
Force/change password functionality should exist.

61. FINAL QUALITY REQUIREMENTS
Do not deliver a static mockup.
Do not create fake buttons that do nothing.
Every important action must work:
Add Product
Edit Product
Delete Product
Bulk Delete
Bulk Category
Bulk Tags
Upload Image
Upload ZIP
Secure Download
