<?php

namespace App\Models;

use App\Traits\HandleUploadImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HandleUploadImageTrait;
    protected $fillable = [
        'name',
        'description',
        'sale',
        'price',
    ];
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function assignCategory($categoryIds)
    {
        // Kiểm tra xem $categoryIds có phần tử nào không
        if (count($categoryIds) > 0) {
            // Đồng bộ hóa danh mục
            return $this->categories()->sync($categoryIds);
        }

        // Nếu $categoryIds không có phần tử, không cần thực hiện đồng bộ hóa
        return null;
    }

    // public function assignDetail($details){
    //     return $this->details()->sysc($categoryIds);
    // }
    public function getBy($request, $category_id)
    {
        return $this->whereHas('categories', fn ($q) => $q->where('category_id', $category_id))->paginate(10);
    }
    public function getImagePathAttribute()
    {
        return asset($this->images ? 'uploads/' . $this->images->url : 'upload/default.jpg');
    }
    public function getSalePriceAttribute()
    {
        return $this->attributes['sale'] ? $this->attributes['price'] - $this->attributes['sale'] : 0;
    }
}
