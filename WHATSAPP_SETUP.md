# WhatsApp Cloud API Setup — U Super Shop

## Step 1: Meta Developer Account

1. যান: https://developers.facebook.com
2. **My Apps** → **Create App**
3. App type: **Business** → Next
4. App name: `U Super Shop` → Create

## Step 2: WhatsApp Setup

1. App dashboard এ **Add Product** → **WhatsApp** → **Set Up**
2. বাম মেনু: **WhatsApp** → **API Setup**
3. এখানে পাবেন:
   - **Phone Number ID** → copy করুন
   - **Temporary Access Token** → copy করুন (24 ঘন্টা valid)

## Step 3: Permanent Token (Important!)

Temporary token 24 ঘন্টা পর expire হয়। Permanent token এর জন্য:

1. **System User** তৈরি করুন: Business Settings → System Users → Add
2. System User-কে App-এর **Admin** বানান
3. **Generate Token** → select করুন:
   - `whatsapp_business_messaging`
   - `whatsapp_business_management`
4. এই token টা কখনো expire হয় না

## Step 4: .env ফাইল আপডেট

```env
WHATSAPP_TOKEN=EAAxxxxxxxxxxxxxxxxxx
WHATSAPP_PHONE_NUMBER_ID=1234567890123456
ADMIN_WHATSAPP_NUMBER=8801816622128
```

## Step 5: Test Recipient অনুমতি দিন

Meta Sandbox mode-এ শুধু অনুমোদিত নম্বরে message যায়।

1. **API Setup** → **To** field-এ আপনার নম্বর দিন → **Send Message**
2. WhatsApp-এ message আসলে ✅

## Step 6: Production Mode (সবার কাছে পাঠাতে)

1. **App Review** → **Permissions** → `whatsapp_business_messaging` → **Request**
2. Business Verification করুন
3. Approve হলে যেকোনো নম্বরে message যাবে

## Step 7: Test করুন

Admin Dashboard → WhatsApp card → **"Test করুন"** বাটনে click করুন

---

## খরচ

- প্রথম **1,000 conversation/মাস** বিনামূল্যে
- তারপর প্রতি conversation ~$0.005 (খুবই সস্তা)
