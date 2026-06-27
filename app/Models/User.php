<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'password',
        'subscription_plan', 'otp', 'otp_expire',
        'refer_code', 'shop_name', 'shop_address',
        'profile_image', 'address', 'city', 'country',
        'bkash_number', 'fcm_token', 'image', 'logo',
        'gender', 'activated_at', 'account_type',
    ];

    // ── NEVER allow mass-assigning these sensitive fields ────────────
    // These can ONLY be changed with explicit code: $user->balance += ...
    // Prevents privilege escalation via form manipulation
    protected $guarded = [
        'id',
        'remember_token',
        'usertype',       // account type — never via form
        'role',           // admin role
        'status',         // active/inactive — admin only
        'payment_status', // paid/unpaid — payment gateway only
        'balance',        // wallet — transaction system only
        'refer_commission',// refer earnings — system only
        'reseller_id',    // refer parent — registration only
        'is_profile_verify', // verification — admin only
        'is_reseller',    // reseller status — system only
        'is_admin',       // admin flag
        // Login block fields — only system can set these
        // (set via $user->login_blocked_at = now(); $user->save())
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'activated_at' => 'datetime',
    ];
    public function profile_verify(){
        return $this->belongsTo(ProfileVerify::class,'user_id','id');
    }

    static function queryBuild($columns)
    {
        $search = strip_tags(htmlspecialchars(request()->input('search.value', ''), ENT_QUOTES, 'UTF-8'));
        $Query = null;
        $i = 0;

        $accountType = strip_tags(request()->input('customFilter.accountType', ''));
        if (!empty($accountType)) {
            $Query = self::where('usertype', $accountType);
        }

        if (!empty($search)) {
            foreach ($columns as $item) {

                if ($item['searchable'] == "true") {
                    if ($i === 0) // first loop
                    {
                        $Query = self::where($item['name'], 'LIKE', '%' . $search . '%');
                    } else {
                        $Query->orWhere($item['name'], 'LIKE', '%' . $search . '%');
                    }
                    $i++;
                }
            }
        }

        return $Query;
    }

    static function getUsersResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('usertype','admin')->where('status',1)->get();
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getSellerDraftResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('usertype','seller')->where('payment_status',1)->get();
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }
    static function getVendorDraftResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('usertype','vendor')->where('payment_status',1)->get();
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getSellerResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('usertype', 'seller')->where('payment_status', 2)->get();
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }
    static function getVendorResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns)->where('usertype','vendor')->where('payment_status', 0);
        if ($Q == null) {
            return self::limit($length)->offset($start)->get();
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getCustomerResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('usertype', 'customer')->where('status', 1)->get();
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getDraftCustomerResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('usertype', 'customer')->where('status', 0)->get();
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function countResult($columns)
    {
        $Q = self::queryBuild($columns);
        if ($Q == null) {
            return self::count();
        } else {
            return $Q->count();
        }
    }
    
    public function referralCode()
{
    return $this->hasOne(DropshipperReferralCode::class, 'dropshipper_id');
}

public function dropshipperProfits()
{
    return $this->hasMany(DropshipperProfit::class, 'dropshipper_id');
}

public function dropshipperProductPrices()
{
    return $this->hasMany(DropshipperProductPrice::class, 'dropshipper_id');
}

public function dropshipOrders()
{
    return $this->hasMany(Order::class, 'dropshipper_id');
}
}
