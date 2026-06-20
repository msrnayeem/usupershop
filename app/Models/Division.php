<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    /**
     * Build query with search + filters (DataTables style)
     */
    public static function queryBuild($columns)
    {
        $search = strip_tags(
            htmlspecialchars(request()->input('search.value', ''), ENT_QUOTES, 'UTF-8')
        );

        $accountType = strip_tags(
            request()->input('customFilter.accountType', '')
        );

        $query = self::query();

        // Optional filter
        if (!empty($accountType)) {
            $query->where('division_name', $accountType);
        }

        // Global search across columns
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