<?php
namespace App\Traits;
use Carbon\Carbon;
use App\Models\Sms;
use Illuminate\Support\Facades\Log;

trait SendSmsTrait{
    protected function normalizeBangladeshMobileNumber($mobile = '')
    {
        $originalInput = $mobile;
        // Remove non-digit characters
        $mobile = preg_replace('/\D+/', '', (string) $mobile);
        
        // Handle different input formats
        if (\Illuminate\Support\Str::startsWith($mobile, '008801')) {
            $mobile = substr($mobile, 4);
        } elseif (\Illuminate\Support\Str::startsWith($mobile, '00881')) {
            // Handle legacy 12 digit 00881...
            $mobile = '0' . substr($mobile, 4);
        } elseif (\Illuminate\Support\Str::startsWith($mobile, '8801')) {
            $mobile = substr($mobile, 2);
        } elseif (\Illuminate\Support\Str::startsWith($mobile, '881')) {
            // Handle legacy 12 digit 881...
            $mobile = '0' . substr($mobile, 2);
        } elseif (\Illuminate\Support\Str::startsWith($mobile, '+8801')) {
            $mobile = substr($mobile, 3);
        } elseif (\Illuminate\Support\Str::startsWith($mobile, '01')) {
            // Keep the 01... format
        } elseif (\Illuminate\Support\Str::startsWith($mobile, '1')) {
            // Prepend 0 if it starts with 1
            $mobile = '0' . $mobile;
        }

        // Final result should be 88 + 11 digits (starting with 01)
        $result = '88' . $mobile;
        
        return $result;
    }
    
    protected function validateMobileForSms($mobile = '')
    {
        $normalized = $this->normalizeBangladeshMobileNumber($mobile);
        $issues = [];
        
        $digitCount = strlen(substr($normalized, 2));
        
        if ($digitCount !== 11) {
            $issues[] = "Mobile number has $digitCount digits after country code, expected exactly 11 digits (e.g., 01XXXXXXXXX)";
        }
        
        if (!preg_match('/^8801[3-9]\d{8}$/', $normalized)) {
            $issues[] = 'Invalid mobile prefix. Expected format: 8801[3-9][0-9]{8}';
        }
        
        $operatorCode = strlen($normalized) >= 4 ? substr($normalized, 2, 2) : null;
        if ($operatorCode && !in_array($operatorCode, ['13', '14', '15', '16', '17', '18', '19'])) {
            $issues[] = 'Unknown operator code: ' . $operatorCode;
        }
        
        return [
            'normalized_mobile' => $normalized,
            'is_valid' => empty($issues),
            'issues' => $issues,
            'operator' => $operatorCode ? $this->getOperatorName($operatorCode) : null,
            'length_after_country_code' => $digitCount,
        ];
    }
    
    protected function getOperatorName($code)
    {
        // Handle both single digit (3,4,5) and two-digit codes (13,14,15)
        $singleDigitOperators = [
            '3' => 'Banglalion (013)',
            '4' => 'Robi (014)',
            '5' => 'Banglalink (015)',
            '6' => 'CityCell (016)',
            '7' => 'Grameenphone (017)',
            '8' => 'Banglalion (018)',
            '9' => 'Teletalk (019)',
        ];
        
        $twoDigitOperators = [
            '01' => 'Standard Prefix',
            '13' => 'Banglalion (013)',
            '14' => 'Robi (014)',
            '15' => 'Banglalink (015)',
            '16' => 'CityCell (016)',
            '17' => 'Grameenphone (017)',
            '18' => 'Banglalion (018)',
            '19' => 'Teletalk (019)',
        ];
        
        if (strlen($code) === 1) {
            return $singleDigitOperators[$code] ?? 'Unknown';
        }
        return $twoDigitOperators[$code] ?? 'Unknown';
    }

    /**
     * Get SMS template from DB, fallback to default string.
     * Replaces placeholders like {name}, {invoice}, etc.
     */
    private function getSmsTemplate(string $column, array $vars = [], string $fallback = ''): string
    {
        try {
            $sms = \App\Models\Sms::first();
            $tpl = ($sms && !empty($sms->$column)) ? $sms->$column : $fallback;
        } catch (\Exception $e) {
            $tpl = $fallback;
        }
        foreach ($vars as $key => $value) {
            $tpl = str_replace('{' . $key . '}', $value, $tpl);
        }
        return $tpl;
    }

    public function send_rapid_message($mobile = '', $message = '')
    {
        $sms = Sms::first();
        $debugInfo = [
            'input_mobile' => $mobile,
            'credentials_configured' => false,
            'credentials_status' => [],
            'normalization_steps' => [],
            'api_request' => null,
            'validation_results' => [],
            'curl_error' => null,
            'http_code' => null,
        ];

        if (!$sms) {
            Log::error('MimSMS credentials not configured');
            return [
                'status' => 'error',
                'message' => 'SMS credentials not configured',
                'debug_info' => $debugInfo
            ];
        }

        $debugInfo['credentials_configured'] = true;
        $debugInfo['credentials_status'] = [
            'apiKey_configured' => !empty($sms->apiKey),
            'userName_configured' => !empty($sms->userName),
            'senderName_configured' => !empty($sms->SenderName),
            'apiKey_length' => $sms->apiKey ? strlen($sms->apiKey) : 0,
            'userName_value' => $sms->userName ? substr($sms->userName, 0, 3) . '***' : 'not set',
            'sender_name' => $sms->SenderName ?? 'not set',
        ];

        $apiUrl = "https://api.mimsms.com/api/SmsSending/SMS";
        $apiKey = $sms->apiKey;
        $userName = $sms->userName;
        $sender = $sms->SenderName;
        
        $debugInfo['normalization_steps']['step1_original'] = $mobile;
        $debugInfo['validation_results']['original_length'] = strlen($mobile);
        
        $mobile = $this->normalizeBangladeshMobileNumber($mobile);
        
        $digitsAfterCountryCode = substr($mobile, 2);
        $actualDigitCount = strlen($digitsAfterCountryCode);
        $expectedDigitCount = 11;
        
        $debugInfo['normalization_steps']['step2_after_normalize'] = $mobile;
        $debugInfo['normalization_steps']['final_mobile_length'] = strlen($mobile);
        $debugInfo['normalization_steps']['digits_after_88'] = $digitsAfterCountryCode;
        $debugInfo['normalization_steps']['digit_count_after_88'] = $actualDigitCount;
        
        $debugInfo['validation_results']['normalized_length'] = strlen($mobile);
        $debugInfo['validation_results']['expected_length'] = 13;
        $debugInfo['validation_results']['length_valid'] = $actualDigitCount === $expectedDigitCount;
        $debugInfo['validation_results']['char_count'] = strlen($mobile);
        $debugInfo['validation_results']['digit_count_after_country_code'] = $actualDigitCount;
        
        if ($actualDigitCount !== $expectedDigitCount) {
            $debugInfo['validation_results']['length_error'] = "Mobile number has $actualDigitCount digits after country code, expected exactly $expectedDigitCount digits (88 + $expectedDigitCount = " . (2 + $expectedDigitCount) . " total)";
        }
        
        $after88 = substr($mobile, 2);
        // Standard format: 88 + 01 + [3-9] + 8 digits
        $firstTwoDigits = substr($after88, 0, 2);
        $operatorCode = substr($after88, 1, 2); // e.g. 13, 17
        
        $isValidPrefix = ($firstTwoDigits === '01');
        $isValidOperator = in_array(substr($after88, 2, 1), ['3', '4', '5', '6', '7', '8', '9']);
        
        if ($isValidPrefix && $isValidOperator && $actualDigitCount === 11) {
            $debugInfo['validation_results']['prefix_valid'] = true;
            $debugInfo['validation_results']['operator_code'] = substr($after88, 1, 2);
            $debugInfo['validation_results']['operator_name'] = $this->getOperatorName(substr($after88, 1, 2));
            $debugInfo['validation_results']['digit_count_after_88'] = $actualDigitCount;
            $debugInfo['validation_results']['expected_format'] = '88 + 11 digits (8801XXXXXXXXX) (valid)';
        } else {
            $debugInfo['validation_results']['prefix_valid'] = false;
            if ($actualDigitCount !== 11) {
                $debugInfo['validation_results']['prefix_error'] = "Invalid digit count: $actualDigitCount (expected 11 digits after 88)";
            } elseif (!$isValidPrefix) {
                $debugInfo['validation_results']['prefix_error'] = "Invalid prefix: $firstTwoDigits (expected 01)";
            } else {
                $debugInfo['validation_results']['prefix_error'] = "Invalid operator digit: " . substr($after88, 2, 1) . " (expected 3-9)";
            }
        }

        $debugInfo['api_request'] = [
            "UserName"       => $userName,
            "Apikey"         => '***' . substr($apiKey, -4),
            "MobileNumber"   => $mobile,
            "CampaignId"     => "null",
            "SenderName"     => $sender,
            "TransactionType" => "T",
            "Message"        => substr($message, 0, 50) . (strlen($message) > 50 ? '...' : ''),
            "full_message_length" => strlen($message)
        ];

        $postData = [
            "UserName"       => $userName,
            "Apikey"         => $apiKey,
            "MobileNumber"   => $mobile,
            "CampaignId"     => "null",
            "SenderName"     => $sender,
            "TransactionType" => "T",
            "Message"        => $message
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $debugInfo['http_code'] = $httpCode;

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            $debugInfo['curl_error'] = $error_msg;
            Log::error('MimSMS cURL error', [
                'mobile' => $mobile,
                'error' => $error_msg,
            ]);
            return ['status' => 'error', 'message' => $error_msg, 'debug_info' => $debugInfo];
        }
        curl_close($ch);
        
        $debugInfo['raw_response'] = $response;
        $decodedResponse = json_decode($response, true);
        $debugInfo['response_parsed'] = $decodedResponse;
        $debugInfo['response_is_json'] = json_last_error() === JSON_ERROR_NONE;

        if ($httpCode !== 200 || !is_array($decodedResponse)) {
            Log::error('MimSMS invalid response', [
                'mobile' => $mobile,
                'http_code' => $httpCode,
                'response' => $response,
            ]);
            return [
                'status' => 'error',
                'message' => 'Invalid SMS gateway response',
                'http_code' => $httpCode,
                'response' => $response,
                'debug_info' => $debugInfo
            ];
        }

        if (!isset($decodedResponse['status']) || strtolower((string) $decodedResponse['status']) !== 'success') {
            Log::error('MimSMS delivery failed', [
                'mobile' => $mobile,
                'response' => $decodedResponse,
            ]);
            $decodedResponse['debug_info'] = $debugInfo;
        } else {
            $decodedResponse['debug_info'] = $debugInfo;
        }

        return $decodedResponse;
    }

    public function sendOrderConfirmedSms($order)
    {
        $mobile = $order->shipping->mobile ?? ($order->users->mobile ?? null);
        if (!$mobile) return;
        
        $customerName = $order->shipping->name ?? ($order->users->name ?? 'Customer');
        $invoiceNo = $order->invoice_no ?? $order->order_no;
        $trackingLink = route('order.track');

        $paymentMethod = strtolower((string) data_get($order, 'payment.payment_method', ''));
        $isCashOnDelivery = in_array($paymentMethod, ['cod', 'cash on delivery', 'cash_on_delivery'], true)
            || (int) ($order->pay_method ?? 0) === 3
            || strtoupper((string) ($order->order_payment ?? '')) === 'UNPAID';

        $trackingWithInvoice = $trackingLink . '?invoice=' . $invoiceNo;

        if ($isCashOnDelivery) {
            $deliveryCharge = (float) ($order->delivery_charge ?? 0);
            $grandTotal = (float) ($order->grand_total ?? $order->order_total ?? 0);
            $remainingAmount = max($grandTotal - $deliveryCharge, 0);
            $deliveryChargeText = number_format($deliveryCharge, 0, '.', '');
            $remainingAmountText = number_format($remainingAmount, 0, '.', '');
            $isFreeDelivery = $deliveryCharge <= 0;

            if ($isFreeDelivery) {
                $message = "🎉 অভিনন্দন {$customerName}!\nআপনার অর্ডার নিশ্চিত হয়েছে ✅\n\n📦 Invoice: {$invoiceNo}\n💳 Payment: Cash on Delivery\n🚚 Delivery: FREE (বিনামূল্যে)\n💰 ডেলিভারিতে পরিশোধ: ৳{$remainingAmountText}\n\n🔎 অর্ডার ট্র্যাক করুন:\n{$trackingWithInvoice}\n\nU Super Shop ❤️\nhttps://usuper.shop";
            } else {
                $message = "🎉 অভিনন্দন {$customerName}!\nআপনার অর্ডার নিশ্চিত হয়েছে ✅\n\n📦 Invoice: {$invoiceNo}\n💳 Payment: Cash on Delivery\n🚚 Delivery Charge Paid: ৳{$deliveryChargeText}\n💰 ডেলিভারিতে পরিশোধ: ৳{$remainingAmountText}\n\n🔎 অর্ডার ট্র্যাক করুন:\n{$trackingWithInvoice}\n\nU Super Shop ❤️\nhttps://usuper.shop";
            }
        } else {
            $amount = number_format((float)($order->grand_total ?? $order->order_total ?? 0), 0, '.', '');
            $message = "🎉 অভিনন্দন {$customerName}!\nপেমেন্ট সম্পন্ন ও অর্ডার নিশ্চিত হয়েছে ✅\n\n📦 Invoice: {$invoiceNo}\n💳 Paid: ৳{$amount}\n✅ Payment Status: Paid\n\n🔎 অর্ডার ট্র্যাক করুন:\n{$trackingWithInvoice}\n\nU Super Shop ❤️\nhttps://usuper.shop";
        }
        
        return $this->send_rapid_message($mobile, $message);
    }
    
    public function sendOrderCancelledSms($order)
    {
        $mobile = $order->shipping->mobile ?? ($order->users->mobile ?? null);
        if (!$mobile) return;
        
        $customerName = $order->shipping->name ?? ($order->users->name ?? 'Customer');
        $invoiceNo = $order->invoice_no ?? $order->order_no;
        
        $message = "⚠️ Dear {$customerName},\nWe’re sorry to inform you that your order has been cancelled.\n📦 Order Details: • Invoice No: #{$invoiceNo}\n• Order Status: Cancelled ❌\nPossible Reasons: • Payment not completed\n• Product out of stock\n• Verification issue\nIf you think this was a mistake, please contact our support team.\n🛒 Shop Again: https://usuper.shop\nThank you for being with U Super Shop ❤️";
        
        return $this->send_rapid_message($mobile, $message);
    }
    
    /**
     * Send SMS when order is returned
     */
    public function sendOrderReturnSms($order): void
    {
        $mobile = $order->shipping->mobile ?? $order->users->mobile ?? null;
        if (!$mobile) return;

        $customerName = $order->shipping->name ?? $order->users->name ?? 'Customer';
        $invoiceNo    = $order->invoice_no ?? ('USP' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
        $trackingLink = url('order/track');
        $trackingWithInvoice = $trackingLink . '?invoice=' . $invoiceNo;

        $deliveryCharge = (float)($order->delivery_charge ?? 0);
        $hasDeliveryCharge = $deliveryCharge > 0;
        $deliveryChargeText = number_format($deliveryCharge, 0, '.', '');

        $vars = [
            'name'            => $customerName,
            'invoice'         => $invoiceNo,
            'delivery_charge' => $deliveryChargeText,
            'track_link'      => $trackingWithInvoice,
        ];
        $fallback = "↩️ {name}, আপনার অর্ডার Return হয়েছে।

📦 Invoice: {invoice}
• Status: Returned ↩️

⚠️ Return-এ ডেলিভারি চার্জ ৳{delivery_charge} ফেরতযোগ্য নয়।
আরও বিস্তারিত জানতে:
wa.me/8801816622128

🔎 ট্র্যাক করুন:
{track_link}

U Super Shop ❤️";
        $message = $this->getSmsTemplate('tpl_order_return', $vars, $fallback);
        $this->send_rapid_message($mobile, $message);
    }

    public function sendOrderProcessingSms($order)
    {
        $mobile = $order->shipping->mobile ?? ($order->users->mobile ?? null);
        if (!$mobile) return;
        
        $customerName = $order->shipping->name ?? ($order->users->name ?? 'Customer');
        $invoiceNo = $order->invoice_no ?? $order->order_no;
        $trackingLink = route('order.track');
        
        $trackingWithInvoice = $trackingLink . '?invoice=' . $invoiceNo;
        $vars = ['name' => $customerName, 'invoice' => $invoiceNo, 'track_link' => $trackingWithInvoice];
        $fallback = "📢 {name}, আপনার অর্ডার প্রক্রিয়াধীন ⏳

📦 Invoice: {invoice}
• Status: Processing

🔎 ট্র্যাক করুন:
{track_link}

U Super Shop ❤️";
        $message = $this->getSmsTemplate('tpl_order_processing', $vars, $fallback);
        
        return $this->send_rapid_message($mobile, $message);
    }

    public function sendOrderShipmentSms($order)
    {
        $mobile = $order->shipping->mobile ?? ($order->users->mobile ?? null);
        if (!$mobile) return;

        $customerName = $order->shipping->name ?? ($order->users->name ?? 'Customer');
        $invoiceNo = $order->invoice_no ?? $order->order_no;
        $trackingLink = route('order.track');

        $trackingWithInvoice = $trackingLink . '?invoice=' . $invoiceNo;
        $vars = ['name' => $customerName, 'invoice' => $invoiceNo, 'track_link' => $trackingWithInvoice];
        $fallback = "🚚 {name}, আপনার পণ্য রওনা হয়েছে! ✅

📦 Invoice: {invoice}
• Status: Shipped 🚚

ডেলিভারি ম্যান সামনে থাকাকালীন পণ্য চেক করুন।

🔎 ট্র্যাক করুন:
{track_link}

U Super Shop ❤️";
        $message = $this->getSmsTemplate('tpl_order_shipped', $vars, $fallback);

        return $this->send_rapid_message($mobile, $message);
    }

    public function sendOrderDeliveredSms($order)
    {
        $mobile = $order->shipping->mobile ?? ($order->users->mobile ?? null);
        if (!$mobile) return;

        $customerName = $order->shipping->name ?? ($order->users->name ?? 'Customer');
        $invoiceNo = $order->invoice_no ?? $order->order_no;

        $vars = ['name' => $customerName, 'invoice' => $invoiceNo, 'track_link' => $trackingLink . '?invoice=' . $invoiceNo];
        $fallback = "🎉 {name}, পণ্য ডেলিভারি সম্পন্ন! ✅

📦 Invoice: {invoice}
• Status: Delivered ✅

পণ্য পেয়ে সন্তুষ্ট হলে আমাদের Review দিন।
যেকোনো সমস্যায়: wa.me/8801816622128

🛒 আবার কেনাকাটা করুন:
https://usuper.shop
U Super Shop ❤️";
        $message = $this->getSmsTemplate('tpl_order_delivered', $vars, $fallback);

        return $this->send_rapid_message($mobile, $message);
    }

    public function sendWithdrawCompletedSms($user, $withdrawAmount, $transactionId, $paymentMethod = 'Bkash', $paymentDate = null)
    {
        $mobile = $user->mobile ?? null;
        if (!$mobile) return;

        $customerName = $user->name ?? 'Customer';
        $withdrawAmountText = number_format((float) $withdrawAmount, 0, '.', '');
        $paymentDateText = $paymentDate
            ? Carbon::parse($paymentDate)->format('Y-m-d h:i A')
            : now()->format('Y-m-d h:i A');

        $message = "🎉 Dear {$customerName},\n\nYour Withdraw Request has been successfully completed ✅\n\n━━━━━━━━━━━━━━━━💳 PAYMENT INFORMATION━━━━━━━━━━━━━━━━━\n\n• Payment Status: Successfully Paid ✅\n• Withdraw Amount: ৳{$withdrawAmountText}\n• Transaction ID: {$transactionId}\n• Payment Method: {$paymentMethod}\n• Payment Date: {$paymentDateText}\n\n━━━━━━━━━━━━━━━━━━📌 IMPORTANT NOTICE━\n\nThe money withdrawn from your wallet has been sent successfully. Please save the Transaction ID for future reference.\n\n━━━━━━━━━━━━━━🌐 U Super Shop━━━━━━━━━━━━━━━\n\n🛒 Website: https://usuper.shop\n\nFor any needs, please contact our support team.\n\nThank you for being with U Super Shop ❤️";

        return $this->send_rapid_message($mobile, $message);
    }

    public function sendSellerRegistrationSms($user, $password, $invoice_no = 'N/A', $package_name = 'Free', $expire_date = 'Lifetime')
    {
        if (!$user->mobile) return;
        
        $sellerId = $user->id;
        $createDate = $user->created_at ? $user->created_at->format('Y-m-d') : date('Y-m-d');
        $loginLink = url('/customer-login');
        
        $message = "🎉 Dear {$user->name},\nWelcome to U Super Shop Seller Panel 🚀\nYour seller account has been created successfully. ✅\n📄 Account Details: • Seller ID: #{$sellerId}\n• Invoice No: #{$invoice_no}\n• Create Date: {$createDate}\n• Panel Expire Date: {$expire_date}\n• Package: {$package_name}\n🔐 Login Information: • Email/Phone: {$user->mobile}\n• Password: {$password}\n🖥 Seller Panel Login: {$loginLink}\n⚠️ Please change your password after first login for security purposes.\nIf you need any support, feel free to contact us anytime.\nThank you for joining U Super Shop ❤️";
        
        return $this->send_rapid_message($user->mobile, $message);
    }

    public function sendDropshipperRegistrationSms($user, $password, $invoice_no = 'N/A', $expire_date = 'Lifetime')
    {
        if (!$user->mobile) return;
        
        $userId = $user->id;
        $createDate = $user->created_at ? $user->created_at->format('Y-m-d') : date('Y-m-d');
        $loginLink = url('/customer-login');
        
        $message = "✅ Dear {$user->name},\nCongratulations! Your Dropshipper account is now active on U Super Shop 🚀\n📄 Account Information: • Dropshipper ID: #{$userId}\n• Invoice No: #{$invoice_no}\n• Account Create Date: {$createDate}\n• Membership Expire Date: {$expire_date}\n💼 Benefits: • Access to reseller products\n• Order management system\n• Profit tracking dashboard\n• Referral & commission system\n🔐 Panel Login: {$loginLink}\n🛒 Shop Website: https://usuper.shop\nThank you for becoming a partner of U Super Shop ❤️";
        
        return $this->send_rapid_message($user->mobile, $message);
    }

    public function sendVendorRegistrationSms($user, $password, $invoice_no = 'N/A', $package_name = 'Free', $expire_date = 'Lifetime')
    {
        if (!$user->mobile) return;
        
        $vendorId = $user->id;
        $createDate = $user->created_at ? $user->created_at->format('Y-m-d') : date('Y-m-d');
        $loginLink = url('/customer-login');
        
        $message = "🎉 Dear {$user->name},\n\nWelcome to U Super Shop Vendor Panel 🚀\n\nYour Vendoer account has been created successfully. ✅\n\n📄 Account Details:\n• Vendor ID: #{$vendorId}\n• Invoice No: #{$invoice_no}\n• Create Date: {$createDate}\n• Panel Expire Date: {$expire_date}\n• Package: {$package_name}\n\n🔐 Login Information:\n• Email/Phone: {$user->mobile}\n• Password: {$password}\n\n🖥 Vendor Panel Login:\n{$loginLink}\n\n⚠️ Please change your password after first login for security purposes.\n\nIf you need any support, feel free to contact us anytime.\n\nThank you for joining U Super Shop ❤️";
        
        return $this->send_rapid_message($user->mobile, $message);
    }

    /**
     * Send welcome invoice-style SMS when a new seller/vendor/dropshipper account is created.
     */
    public function sendWelcomeInvoiceSms(
        \App\Models\User $user,
        string $password,
        string $invoice_no = 'N/A',
        string $package_name = '1 Year',
        string $expire_date = 'N/A'
    ): void {
        if (empty($user->mobile)) return;

        $mobile      = '88' . ltrim($user->mobile, '0');
        $loginLink   = route('customer.login');
        $createDate  = now()->format('d M Y');
        $userId      = str_pad($user->id, 5, '0', STR_PAD_LEFT);

        $accountType = match ($user->usertype) {
            'vendor'      => 'Vendor',
            'dropshipper' => 'Dropshipper',
            default       => 'Seller',
        };

        $message = "🎉 U Super Shop — New {$accountType} Account\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📋 INVOICE / ACCOUNT DETAILS\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "👤 Name       : {$user->name}\n"
            . "🆔 Account ID : #{$userId}\n"
            . "📄 Invoice No : {$invoice_no}\n"
            . "📦 Package    : {$package_name}\n"
            . "📅 Created    : {$createDate}\n"
            . "⏳ Expires    : {$expire_date}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "🔐 LOGIN INFORMATION\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📱 Phone      : {$user->mobile}\n"
            . "🔑 Password   : {$password}\n"
            . "🖥 Login Link : {$loginLink}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "⚠️ Please change your password after first login.\n"
            . "📞 Support: 01816622128\n"
            . "🛒 usuper.shop\n"
            . "Thank you for joining U Super Shop ❤️";

        try {
            $this->send_rapid_message($mobile, $message);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Welcome invoice SMS failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send SMS when subscription is successfully renewed/activated.
     */
    public function sendSubscriptionRenewedSms(\App\Models\User $user): void
    {
        if (empty($user->mobile)) return;

        $mobile     = '88' . ltrim($user->mobile, '0');
        $newExpiry  = $user->subscription_plan
            ? \Carbon\Carbon::createFromTimestamp($user->subscription_plan)->format('d M Y')
            : 'N/A';
        $loginLink  = route('customer.login');
        $accountType = match ($user->usertype) {
            'vendor'      => 'Vendor',
            'dropshipper' => 'Dropshipper',
            default       => 'Seller',
        };

        $message = "✅ Dear {$user->name},\n"
            . "Your U Super Shop {$accountType} subscription has been RENEWED successfully! 🎉\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📦 Package   : 1 Year\n"
            . "⏳ Valid Until: {$newExpiry}\n"
            . "🖥 Login     : {$loginLink}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📞 Support: 01816622128\n"
            . "Thank you — U Super Shop ❤️";

        try {
            $this->send_rapid_message($mobile, $message);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Subscription renewed SMS failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
        }
    }

}