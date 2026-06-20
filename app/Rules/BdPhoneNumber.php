<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BdPhoneNumber implements Rule
{
    /**
     * Run the validation rule.
     *
     * Supports all types of Bangladesh mobile numbers:
     * - Voice/Data operators: Grameen Phone (017, 018, 019), Banglalink (015), 
     *   Vodafone (013, 016), Robi (014), Teletalk (011, 012)
     * - Landline operators: BTCL (02X)
     * - Various formats: +8801XXXXXXXXX, 8801XXXXXXXXX, 01XXXXXXXXX
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Remove common formatting characters
        $number = preg_replace('/[\s\-\(\)\.]+/', '', $value);

        // Check if it starts with country code or 0
        $normalizedNumber = $number;
        
        // Handle +88 prefix
        if (strpos($number, '+88') === 0) {
            $normalizedNumber = substr($number, 3); // Remove +88
        } 
        // Handle 0088 prefix
        elseif (strpos($number, '0088') === 0) {
            $normalizedNumber = substr($number, 4); // Remove 0088
        } 
        // Handle 88 prefix
        elseif (strpos($number, '88') === 0) {
            $normalizedNumber = substr($number, 2); // Remove 88
        }
        
        // Now we should have a number starting with 0 or 1
        // If it doesn't start with 0 or 1, prepend 0
        if (!in_array(substr($normalizedNumber, 0, 1), ['0', '1'])) {
            $normalizedNumber = '0' . $normalizedNumber;
        }

        // Valid prefixes for Bangladesh operators
        $validPrefixes = [
            '011', '012', '013', '014', '015', '016', '017', '018', '019', // Mobile operators
            '020', '021', '022', '023', '024', '025', '026', '027', '028', '029', // BTCL Landlines
        ];

        // Check if number matches any valid prefix
        foreach ($validPrefixes as $prefix) {
            if (strpos($normalizedNumber, $prefix) === 0) {
                // Mobile numbers should be 11 digits (01XXXXXXXXX)
                if (in_array($prefix, ['011', '012', '013', '014', '015', '016', '017', '018', '019'])) {
                    if (strlen($normalizedNumber) === 11 && preg_match('/^01[0-9]{9}$/', $normalizedNumber)) {
                        return true;
                    }
                }
                // BTCL Landlines can be 10-11 digits (02XXXXXXXXX)
                elseif (in_array(substr($prefix, 0, 2), ['02'])) {
                    if ((strlen($normalizedNumber) === 10 || strlen($normalizedNumber) === 11) && 
                        preg_match('/^02[0-9]{8,9}$/', $normalizedNumber)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please enter a valid Bangladesh mobile number (e.g., 01XXXXXXXXX or +8801XXXXXXXXX).';
    }
}
