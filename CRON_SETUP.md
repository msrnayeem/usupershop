# Cron Job Setup — U Super Shop

## Server Cron (Required for subscription expiry system)

Add this cron job to your server's crontab:

```bash
crontab -e
```

Add this line:

```
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

Replace `/path/to/your/project` with your actual project root path (e.g., `/home/usuper/public_html`).

This will run Laravel's scheduler every minute. The scheduler itself will fire the expiry check daily at 8:00 AM Bangladesh time.

## What the scheduler does:
- **Daily at 8:00 AM (BD time):** Checks all seller/vendor/dropshipper accounts
  - If expired → suspends the account + sends SMS
  - If expiring within 30 days → sends renewal reminder SMS (once only)

## Manual run (test):
```bash
php artisan subscription:check-expiry
```
