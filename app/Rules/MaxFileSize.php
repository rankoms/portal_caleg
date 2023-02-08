<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxFileSize implements Rule
{
    private $maxSize;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $totalSize = array_reduce($value, function ($sum, $item) { 
            $sum += $item->getSize();

            return $sum;
        });

        return ($this->maxSize*1024) > ($totalSize/1024);
        // Validator::extend('max_uploaded_file_size', function ($attribute, $value, $parameters, $validator) {
        //     $total_size = array_reduce($value, function ( $sum, $item ) { 
        //         // each item is UploadedFile Object
        //         $sum += filesize($item->path()); 
        //         return $sum;
        //     });
    
        //     // $parameters[0] in kilobytes
        //     return $total_size < $parameters[0] * 1024; 
        // }, $attribute.' file size');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // return 'Jumlah ukuran '.ucfirst(':Attribute').' harus kurang dari '.$this->maxSize.' MB';
        return 'The '.ucfirst(':Attribute').' field must be less than '.$this->maxSize.' MB';
        // return ucfirst(':Attribute').' size tidak boleh lebih dari '.$this->maxSize.' MB';
        // return str_replace(':attribute', ucfirst(':Attribute'), ':attribute size tidak boleh lebih dari '.$this->maxSize.' MB');
    }
}
