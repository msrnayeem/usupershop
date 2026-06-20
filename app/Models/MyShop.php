<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MyShop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Build query with optional search for DataTables
     */
    public static function queryBuild($columns, $request = null)
    {
        $request = $request ?? request();
        $search = $request->input('search.value', null);
        $query = self::where('user_id', Auth::id());
        $i = 0;

        if (!empty($search)) {
            foreach ($columns as $item) {
                if ($item['searchable'] == "true") {
                    if ($i === 0) {
                        $query->where($item['name'], 'LIKE', '%' . $search . '%');
                    } else {
                        $query->orWhere($item['name'], 'LIKE', '%' . $search . '%');
                    }
                    $i++;
                }
            }
        }

        return $query;
    }

    /**
     * Get paginated result for DataTables
     */
    public static function getResult($start, $length, $columns, $request = null)
    {
        $query = self::queryBuild($columns, $request);

        $start = $start ?? 0;      // default 0
        $length = $length ?? 10;   // default 10

        if ($length != -1) {
            $query = $query->skip($start)->take($length); // safe for MySQL
        }

        return $query->get();
    }

    /**
     * Count filtered results
     */
    public static function countResult($columns, $request = null)
    {
        $query = self::queryBuild($columns, $request);
        return $query->count();
    }
}
