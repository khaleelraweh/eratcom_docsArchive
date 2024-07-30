<?php

// app/Services/CustomValidationRules.php

namespace App\Services;

class CustomValidationRules
{
    public static function minWords($attribute, $value, $parameters, $validator)
    {
        $minWords = $parameters[0] ?? 0;
        $validator->setCustomMessages([
            // 'min_words' => __('The :attribute must contain at least :min words.', ['min' => $minWords]),
            'min_words' => __(__('transf.The description field must contain at least') . ' :min ' . __('transf.words!'), ['min' => $minWords]),
        ]);

        // Use a custom word counting function for Arabic text
        if (is_string($value)) {
            $wordCount = preg_match_all('/\b\p{L}+\b/u', $value);
            return $wordCount >= $minWords;
        }

        return false;
    }
}
