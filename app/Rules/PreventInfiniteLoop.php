<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\InvokableRule;

class PreventInfiniteLoop implements InvokableRule
{
    protected Category $currentCategory;

    public function __construct(Category $currentCategory)
    {
        $this->currentCategory = $currentCategory;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $parent = Category::find($value);
        while ($parent) {
            if (!$parent instanceof Category) {
                $fail('エラーが発生しました');
                break;
            }
            if ($parent->id === $this->currentCategory->id) {
                $fail('親カテゴリーに"' . $this->currentCategory->name . '"が含まれています。');
                break;
            }
            $parent = $parent->parent;
        }
    }
}
