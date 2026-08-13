# PAROKO Full-Stack V3 — Visual / UX Upgrade

## Storefront
- Mobile-first layout inspired by the supplied iPhone references.
- Dark mode: near-black + #588580 teal accent + white typography.
- Light mode: white/black base + soft-gold cards and gold active states.
- iPhone-style product card shine border and animated highlight.
- Compact rounded cards, pill discounts, glass header and bottom mobile nav.
- Responsive Best Sellers grid.
- Shop by Category horizontal scroller with Iconify icons.
- Category selection updates products through `/api/home.php` without a full page reload.
- Gadgets / Jersey / Fashion tabs update hero, categories and products through AJAX.
- Browser history is updated to SEO-friendly `/{niche}` and `/{niche}?cat={slug}` URLs.
- Hero/banner content comes from the admin Widgets system when enabled.

## Admin
### Widgets
- Existing widget Edit/Delete/Enable/Disable retained.
- Added Homepage Visibility controls:
  - Hero / Banner
  - Shop by Category
  - Best Sellers
  - Promo Banners
  - Homepage Widgets

### Settings
- Visual Theme Preset:
  - Teal 600 / #588580
  - Blue 600
  - Violet 600
  - Gold 600
- Dark / Light mode
- Accent hex and light card hex controls
- Existing typography settings remain separate.

## Reference assets
- `reference-mobile-home.png` — supplied mobile homepage reference.
- `reference-product-card.jpg` — supplied product card reference.
