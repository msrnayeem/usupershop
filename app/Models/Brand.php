<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Build base query for search/filter (DataTables style)
     */
    public static function queryBuild($columns)
    {
        $search = strip_tags(
            request()->input('search.value', '')
        );

        $accountType = strip_tags(
            request()->input('customFilter.accountType', '')
        );

        $query = self::query();

        // Filter by account type if provided
        if (!empty($accountType)) {
            $query->where('created_by', $accountType);
        }

        // Global search
        if (!empty($search)) {
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $item) {
                    if (($item['searchable'] ?? 'false') === "true") {
                        $q->orWhere($item['name'], 'LIKE', "%{$search}%");
                    }
                }
            });
        }

        return $query;
    }

    /**
     * Get paginated results
     */
    public static function getResult($start, $length, $columns)
    {
        $query = self::queryBuild($columns)
            ->orderBy('id', 'DESC');

        if ($length != -1) {
            $query->skip($start)->take($length);
        }

        return $query->get();
    }

    /**
     * Count results
     */
    public static function countResult($columns)
    {
        return self::queryBuild($columns)->count();
    }
}