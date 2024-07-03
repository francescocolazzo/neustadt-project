<?php

namespace App\Models;

use App\Repositories\CardRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int         $id
 * @property      string      $scryfall_card_id
 * @property      string      $name
 * @property      string      $set_code
 * @property      string      $image_path
 * @property      Carbon      $created_at
 * @property      ?Carbon     $deleted_at
 */

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cards';
    protected $fillable = [
        'scryfall_card_id',
        'name',
        'set_code',
        'image_path'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'content' => 'json'
    ];

    public static function getRepository(): CardRepository
    {
        return new CardRepository();
    }

    ### GETTER - SETTER --- START ###
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Card
    {
        $this->name = $name;

        return $this;
    }

    public function getScryfallCardId(): string
    {
        return $this->scryfall_card_id;
    }

    public function setScryfallCardId(string $scryfall_card_id): Card
    {
        $this->scryfall_card_id = $scryfall_card_id;

        return $this;
    }

    public function getSetCode(): string
    {
        return $this->set_code;
    }

    public function setSetCode(string $set_code): Card
    {
        $this->set_code = $set_code;

        return $this;
    }


    public function getImagePath(): string
    {
        return $this->image_path;
    }

    public function setImagePath(string $image_path): Card
    {
        $this->image_path = $image_path;

        return $this;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getDeletedAt(): Carbon
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(Carbon $deleted_at): Card
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }
    ### GETTER - SETTER ---- END ###
}
