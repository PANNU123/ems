<?php


use Illuminate\Support\Facades\DB;

if (!function_exists('selectJobType')) {
    function selectJobType($user_id, $category_id)
    {
        if (DB::table('categories_wise_user')->where('user_id', $user_id)->where('category_id', $category_id)->exists()) {
            return 'selected';
        }
        return null;
    }
}
if (!function_exists('academyType')) {
    function academyType()
    {
        return \App\Models\Admin\AcademicType::all();
    }
}
if (!function_exists('showAllChapter')) {
    function showAllChapter()
    {
        return \App\Models\Admin\Chapter::all();
    }
}
if (!function_exists('difficultyLevel')) {
    function difficultyLevel()
    {
        return [
            '10','20','30','40','50','60','70','80','90','100',
        ];
    }
}

if (!function_exists('slug')) {
     function slug($text){
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate divider
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}
