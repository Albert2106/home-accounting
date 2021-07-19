<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Accounting
 * @package App\Models
 *
 * @property int $id
 * @property int $type
 * @property int $category_id
 * @property int $amount
 * @property string $comment
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Accounting extends Model
{
    protected $table = 'accounting';
    public function getItems()
    {
        return self::query()->get();
    }
    public function getCount($type)
    {
        return self::query()->where('type','=', $type)->sum('amount');
    }

    public function add(array $data)
    {
        $AddSelf = new self();

        $AddSelf->type = $data['type'];
        $AddSelf->category_id = $data['category_id'];
        $AddSelf->amount = $data['amount'];
        $AddSelf->comment = $data['comment'];

        $AddSelf->save();
    }

    //Getters
    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    /**
     * @return int
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
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

    //Relations

    public function relationCategory()
    {
       return $this->belongsTo(Category::class,'category_id');
    }

}
