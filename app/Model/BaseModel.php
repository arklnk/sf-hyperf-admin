<?php

declare(strict_types=1);

namespace App\Model;

use App\Utils\DataFormat;
use Hyperf\DbConnection\Model\Model;

/**
 * 模型基类
 */
class BaseModel extends Model
{
    /**
     * 添加数据
     *
     * @param array $data
     */
    public function addItem(array $data)
    {
        self::insert($data);
    }

    /**
     * 删除数据
     *
     * @param array $where [['','','']]
     */
    public function deleteItem(array $where)
    {
        self::where($where)->delete();
    }

    /**
     * 获取一条数据（一维数组）
     *
     * @param array $where
     * @param array|string[] $field
     * @return array
     */
    public function getItem(array $where, array $field = ['*']): array
    {
        return self::formatData(self::where($where)->first($field));
    }

    /**
     * 获取一组数据（二维数组）
     *
     * @param array $where [['','','']]
     * @param string[] $field
     * @param array $sort
     * @return array
     */
    public function getItems(array $where, array $field = ['*'], array $sort = []): array
    {
        if (empty($sort)) {
            return self::formatData(self::where($where)->select(...$field)->get());
        } else {
            return self::formatData(self::where($where)->select(...$field)->orderBy(...$sort)->get());
        }
    }

    /**
     * 获取区间内数据
     *
     * @param array $where [['','','']]
     * @param string[] $field
     * @param array $sort
     * @return array
     */
    public function getItemsIn(array $where, array $field = ['*'], array $sort = []): array
    {
        if (empty($sort)) {
            return self::formatData(self::whereIn(...$where)->select(...$field)->get());
        } else {
            return self::formatData(self::whereIn(...$where)->select(...$field)->orderBy(...$sort)->get());
        }
    }

    /**
     * 更新数据
     *
     * @param array $where [['','','']]
     * @param array $data
     */
    public function updateItem(array $where, array $data)
    {
        self::where($where)->update($data);
    }

    /**
     * 获取全部数据
     *
     * @param string[] $field
     * @param array $sort
     * @return array
     */
    public function getAll(array $field = ['*'], array $sort = []): array
    {
        if (empty($sort)) {
            return self::formatData(self::select(...$field)->get());
        } else {
            return self::formatData(self::select(...$field)->orderBy(...$sort)->get());
        }
    }

    /**
     * 分页获取数据
     *
     * @param int $page
     * @param int $limit
     * @param array|array[] $where [['','','']]
     * @param string[] $field
     * @param array $order
     * @return array
     */
    public function page(int $page, int $limit, array $where = [], array $field = ['*'], array $order = []): array
    {
        if (empty($where)) {
            if (empty($order)) {
                return self::formatData(self::forPage($page, $limit)->select(...$field)->get());
            } else {
                return self::formatData(self::forPage($page, $limit)->select(...$field)->orderBy(...$order)->get());
            }
        } else {
            if (empty($order)) {
                return self::formatData(self::where($where)->forPage($page, $limit)->select(...$field)->get());
            } else {
                return self::formatData(self::where($where)->forPage($page, $limit)->select(...$field)->orderBy(...$order)->get());
            }
        }
    }

    /**
     * 将模型查找的数据转化为数组
     *
     * @param $data
     * @return array
     */
    public function formatData($data): array
    {
        if (!empty($data)) {
            return DataFormat::underscoreToHump($data->toArray());
        } else {
            return [];
        }
    }
}