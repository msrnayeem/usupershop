<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    public static function queryBuild($columns)
    {
        $search = strip_tags(
            htmlspecialchars(
                request()->input('search.value', ''),
                ENT_QUOTES,
                'UTF-8'
            )
        );

        $Query = null;
        $i = 0;

        $accountType = strip_tags(
            request()->input('customFilter.accountType', '')
        );

        if (!empty($accountType)) {
            $Query = self::where('created_by', $accountType);
        }

        if (!empty($search)) {
            foreach ($columns as $item) {

                if (
                    isset($item['searchable']) &&
                    $item['searchable'] == "true"
                ) {

                    if ($i === 0) {

                        if ($Query === null) {
                            $Query = self::where(
                                $item['name'],
                                'LIKE',
                                '%' . $search . '%'
                            );
                        } else {
                            $Query->where(
                                $item['name'],
                                'LIKE',
                                '%' . $search . '%'
                            );
                        }

                    } else {

                        $Query->orWhere(
                            $item['name'],
                            'LIKE',
                            '%' . $search . '%'
                        );
                    }

                    $i++;
                }
            }
        }

        return $Query;
    }

    public static function getResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q === null) {
            return self::orderBy('id', 'DESC')
                ->offset($start)
                ->limit($length)
                ->get();
        }

        if ($length != -1) {
            $Q->offset($start)->limit($length);
        }

        return $Q->get();
    }

    public static function countResult($columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q === null) {
            return self::count();
        }

        return $Q->count();
    }
}