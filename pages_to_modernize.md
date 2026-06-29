# Admin Panel — Pages to Modernize

> **Strategy:** `master.blade.php` (layout) and `sidebar.blade.php` are already modernized (light theme).  
> All pages that `@extend('backend.layouts.master')` automatically inherit the new layout.  
> Each page below still needs its **inner content** (tables, forms, cards) modernized to match the new design system.  
> The `seller/` panel has its own separate master — handle that in Phase 11.

---

## ✅ Phase 0 — Shared Layouts (Done)

| Status | File | Notes |
|--------|------|-------|
| ✅ Done | `layouts/master.blade.php` | Light theme, collapsible sidebar, topbar |
| ✅ Done | `layouts/sidebar.blade.php` | Clean icons, section labels |
| ✅ Done | `layouts/home.blade.php` | KPI cards, Chart.js trend, WhatsApp banner |

---

## ✅ Phase 2 — Orders (Done)

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 2 | `[x]` | `orders.all.list` | `order/all-order-list.blade.php` |
| 3 | `[x]` | `orders.pending.list` | `order/pending-list.blade.php` |
| 4 | `[x]` | `orders.pending.details` | `order/pending-order-details.blade.php` |
| 5 | `[x]` | `orders.delivered.list` | `order/order-list.blade.php` |
| 6 | `[x]` | `orders.return.list` | `order/approved-list.blade.php` |
| 7 | `[x]` | `orders.canceled.list` | `order/order-list.blade.php` |
| 8 | `[x]` | `orders.courier.list` | `order/courier_orders.blade.php` |
| 9 | `[x]` | `orders.seller.list` | `order/seller-order-list.blade.php` |
| 10 | `[x]` | `orders.details` | `order/order-details.blade.php` |
| 11 | `[x]` | `orders.commission` | `order/order_commission_list.blade.php` |
| 12 | `[x]` | `orders.seller.commission` | `order/seller_wise_commission_list.blade.php` |
| 13 | `[x]` | `orders.print` | `order/print-pending-order-details.blade.php` |

---

## ✅ Phase 3 — Products (Done)

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 14 | `[x]` | `products.add` | `product/add-product.blade.php` |
| 15 | `[x]` | `products.edit` | `product/edit-product.blade.php` |
| 16 | `[x]` | `products.view` | `product/view-product.blade.php` |
| 17 | `[x]` | `products.pending.view` | `product/pending-product.blade.php` |
| 18 | `[x]` | `products.inactive.view` | `product/inactive-product.blade.php` |
| 19 | `[x]` | `products.stockout.view` | `product/stockout-product.blade.php` |
| 20 | `[x]` | `products.lowstock.view` | `product/lowstock-product.blade.php` |
| 21 | `[x]` | `products.show` | `product/show-product.blade.php` |

---

## ✅ Phase 4 — Catalog (Done)

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 22 | `[x]` | `categories.add` | `category/add-category.blade.php` |
| 23 | `[x]` | `categories.view` | `category/view-category.blade.php` |
| 24 | `[x]` | `subcategories.add` | `subcategory/add-subcategory.blade.php` |
| 25 | `[x]` | `subcategories.view` | `subcategory/view-subcategory.blade.php` |
| 26 | `[x]` | `brands.add` | `brand/add-brand.blade.php` |
| 27 | `[x]` | `brands.view` | `brand/view-brand.blade.php` |
| 28 | `[x]` | `colors.add` | `color/add-color.blade.php` |
| 29 | `[x]` | `colors.view` | `color/view-color.blade.php` |
| 30 | `[x]` | `sizes.add` | `size/add-size.blade.php` |
| 31 | `[x]` | `sizes.view` | `size/view-size.blade.php` |
| 32 | `[x]` | `coupons.add` | `coupon/add-coupon.blade.php` |
| 33 | `[x]` | `coupons.view` | `coupon/view-coupon.blade.php` |

---

## 🟪 Phase 5 — Users

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 34 | `[ ]` | `users.add` | `user/add-user.blade.php` |
| 35 | `[ ]` | `users.view` | `user/view-user.blade.php` |
| 36 | `[ ]` | `users.edit` | `user/edit-user.blade.php` |
| 37 | `[ ]` | `profiles.view` | `user/view-profile.blade.php` |
| 38 | `[ ]` | `profiles.password.view` | `user/edit-password.blade.php` |
| 39 | `[ ]` | `profiles.edit` | `user/edit-profile.blade.php` |
| 40 | `[ ]` | `customers.view` | `customer/view-customer.blade.php` |
| 41 | `[ ]` | `customers.draft.view` | `customer/draft-customer.blade.php` |
| 42 | `[ ]` | `sellers.view` | `shopseller/view-seller.blade.php` |
| 43 | `[ ]` | `sellers.blocked` | `seller/blocked-accounts.blade.php` |
| 44 | `[ ]` | `sellers.draft.view` | `shopseller/draft-seller.blade.php` |
| 45 | `[ ]` | `sellers.profile` | `shopseller/profile-seller.blade.php` |
| 46 | `[ ]` | `vendors.view` | `vendor/view-vendor.blade.php` |
| 47 | `[ ]` | `vendors.draft.view` | `vendor/draft-vendor.blade.php` |
| 48 | `[ ]` | `vendors.profile.verify` | `vendor/vendor-profile-verify.blade.php` |
| 49 | `[ ]` | `dropshippers.view` | `dropshipper/view-dropshipper.blade.php` |
| 50 | `[ ]` | `dropshippers.draft.view` | `dropshipper/draft-dropshipper.blade.php` |
| 51 | `[ ]` | `staff.index` | `staff/index.blade.php` |
| 52 | `[ ]` | `staff.create` | `staff/create.blade.php` |
| 53 | `[ ]` | `staff.edit` | `staff/edit.blade.php` |

---

## 🔵 Phase 6 — Finance

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 54 | `[ ]` | `wallets.view` | `wallets/view-wallets.blade.php` |
| 55 | `[ ]` | `wallets.history` | `wallets/history-wallets.blade.php` |
| 56 | `[ ]` | `varified.account` | `wallets/varified-account.blade.php` |
| 57 | `[ ]` | `subscriptions.view` | `subscription/view-subscription.blade.php` |
| 58 | `[ ]` | `paymentgatways.view` | `payment-gateway/view-paymentgateway.blade.php` |
| 59 | `[ ]` | `withdrawal.methods.index` | `withdrawal-methods/index.blade.php` |
| 60 | `[ ]` | `withdrawal.methods.create` | `withdrawal-methods/create.blade.php` |
| 61 | `[ ]` | `withdrawal.methods.edit` | `withdrawal-methods/edit.blade.php` |

---

## 🟤 Phase 7 — Reports

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 62 | `[ ]` | `reports.refer_commission` | `reports/refer-commissions.blade.php` |
| 63 | `[ ]` | `reports.reseller_commission` | `reports/reseller-commissions.blade.php` |
| 64 | `[ ]` | `reports.vendor_sales_reports` | `reports/vendor-sales.blade.php` |
| 65 | `[ ]` | `reports.admin_commission_for_vendor_product_sales` | `reports/admin_commission_for_vendor_product_sales.blade.php` |
| 66 | `[ ]` | `reports.dropshipper_history` | `reports/dropshipper-history.blade.php` |

---

## ⚙️ Phase 8 — Settings & Config

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 67 | `[ ]` | `settings.view` | `settings/view-setting.blade.php` |
| 68 | `[ ]` | `settings.commission.index` | `settings/commission-setting.blade.php` |
| 69 | `[ ]` | `settings.notification` | `settings/notification-settings.blade.php` |
| 70 | `[ ]` | `settings.invoice` | `settings/invoice-settings.blade.php` |
| 71 | `[ ]` | `settings.livechat` | `settings/livechat-settings.blade.php` |
| 72 | `[ ]` | `settings.seo` | `settings/seo-settings.blade.php` |
| 73 | `[ ]` | `smsgateways.view` | `sms-gateway/view-smsgateway.blade.php` |
| 74 | `[ ]` | `smsgateways.test.page` | `sms-gateway/add-smsgateway.blade.php` |
| 75 | `[ ]` | `sms.templates.view` | `sms-gateway/sms-templates.blade.php` |
| 76 | `[ ]` | `couriers.settings` | `courier/settings.blade.php` |
| 77 | `[ ]` | `couriers.index` | `courier/index.blade.php` |
| 78 | `[ ]` | `color-settings.index` | `color-settings/index.blade.php` |

---

## 🏪 Phase 9 — Content

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 79 | `[ ]` | `logos.view` | `logo/view-logo.blade.php` |
| 80 | `[ ]` | `banners.view` | `banner/view-banner.blade.php` |
| 81 | `[ ]` | `sliders.add` | `slider/add-slider.blade.php` |
| 82 | `[ ]` | `sliders.view` | `slider/view-slider.blade.php` |
| 83 | `[ ]` | `abouts.view` | `about/view-about.blade.php` |
| 84 | `[ ]` | `pages.index` | `pages/view-page.blade.php` |
| 85 | `[ ]` | `contacts.view` | `contact/view-contact.blade.php` |
| 86 | `[ ]` | `contacts.communicate` | `contact/communicate.blade.php` |

---

## 🚚 Phase 10 — Delivery & Misc

| # | Status | Route Name | View File |
|---|--------|-----------|-----------|
| 87 | `[ ]` | `areas.division` | `location/view-location.blade.php` |
| 88 | `[ ]` | `areas.sub` | `sub_location/view-sub_location.blade.php` |
| 89 | `[ ]` | `recycle.bin` | `recycle-bin/index.blade.php` |

---

## 🟡 Phase 11 — Seller Panel (Separate Layout)

> Modernize `seller/seller-master.blade.php` and `seller/seller-sidebar.blade.php` first, then update all pages below.

| # | Status | File |
|---|--------|------|
| 90 | `[ ]` | `seller/seller-master.blade.php` ← **do first** |
| 91 | `[ ]` | `seller/seller-sidebar.blade.php` |
| 92 | `[ ]` | `seller/seller-home.blade.php` |
| 93 | `[ ]` | `seller/product/seller_product.blade.php` |
| 94 | `[ ]` | `seller/product/add_vendor_product.blade.php` |
| 95 | `[ ]` | `seller/product/vendor_product.blade.php` |
| 96 | `[ ]` | `seller/product/shopkeeper_product.blade.php` |
| 97 | `[ ]` | `seller/order/order-list.blade.php` |
| 98 | `[ ]` | `seller/order/pending-list.blade.php` |
| 99 | `[ ]` | `seller/order/approved-list.blade.php` |
| 100 | `[ ]` | `seller/order/delivered-list.blade.php` |
| 101 | `[ ]` | `seller/order/cancel-list.blade.php` |
| 102 | `[ ]` | `seller/order/return-list.blade.php` |
| 103 | `[ ]` | `seller/order/order-details.blade.php` |
| 104 | `[ ]` | `seller/order/pending-order-details.blade.php` |
| 105 | `[ ]` | `seller/order/delivered-order-details.blade.php` |
| 106 | `[ ]` | `seller/order/print-seller.blade.php` |
| 107 | `[ ]` | `seller/order/track.blade.php` |
| 108 | `[ ]` | `seller/user/view-profile.blade.php` |
| 109 | `[ ]` | `seller/user/edit-profile.blade.php` |
| 110 | `[ ]` | `seller/user/edit-user.blade.php` |
| 111 | `[ ]` | `seller/user/edit-password.blade.php` |
| 112 | `[ ]` | `seller/user/wallets.blade.php` |
| 113 | `[ ]` | `seller/user/wallets_verify.blade.php` |
| 114 | `[ ]` | `seller/user/transaction.blade.php` |
| 115 | `[ ]` | `seller/user/payment_setting.blade.php` |
| 116 | `[ ]` | `seller/reports/refer_commissions.blade.php` |
| 117 | `[ ]` | `seller/reports/refer_list.blade.php` |
| 118 | `[ ]` | `seller/reports/reseller_commission_reports.blade.php` |
| 119 | `[ ]` | `seller/reports/vendor_sales_reports.blade.php` |

---

## Summary

| Phase | Section | Total Pages | Done |
|-------|---------|-------------|------|
| 0 | Shared Layouts | 3 | ✅ 3 |
| 2 | Orders | 12 | ✅ 12 |
| 3 | Products | 8 | ✅ 8 |
| 4 | Catalog | 12 | ✅ 12 |
| 5 | Users | 20 | 0 |
| 6 | Finance | 8 | 0 |
| 7 | Reports | 5 | 0 |
| 8 | Settings | 12 | 0 |
| 9 | Content | 8 | 0 |
| 10 | Delivery & Misc | 3 | 0 |
| 11 | Seller Panel | 30 | 0 |
| **Total** | | **121** | **35** |
