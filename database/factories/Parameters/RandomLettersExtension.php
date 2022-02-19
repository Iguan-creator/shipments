<?php


namespace Database\Factories\Parameters;


use Illuminate\Support\Str;

trait RandomLettersExtension
{
    private function letters(int $number)
    {
        $result = '';
        for ($i = 0; $i < $number; $i++) {
            $result .= $this->faker->randomLetter;
        }
        return Str::upper($result);
    }
}
