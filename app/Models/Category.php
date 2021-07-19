<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Models
 *
 * @property int $id
 * @property int $type
 * @property string|null $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Category extends Model
{
    protected $table = 'categories';

    public function getItems()
    {
        return self::query()
            ->get();
    }

    public function getCategories($type)
    {
        return self::query()
            ->where('type', '=', $type)
            ->get();
    }
    //Getters

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     *
     * 1 = Доход
     * 2 = Расход
     */
    public function getType(): int
    {
        return $this->type;
    }


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }


}
