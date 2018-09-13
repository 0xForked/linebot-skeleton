<?php

namespace App\Base;

class MainCore {

    public function snakeCase($string)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $result = $matches[0];
        foreach ($result as &$match)
        {
          $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $result);
    }

    public function dashCase($string)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $result = $matches[0];
        foreach ($result as &$match)
        {
          $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('-', $result);
    }

    public function dashToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace('-', '', ucwords($string, '-'));
        if (!$capitalizeFirstCharacter)
        {
            $str = lcfirst($str);
        }
        return $str;
    }

    public function camelCaseToWords($str)
    {
        $words="";
        $result=preg_match_all('/((?:^|[A-Z])[a-z]+)/',$str,$matches);
        if ($result>0) {
            foreach($matches[0] as $value)
            {
                $words.=$value." ";
            }
        }
        return $words;
    }

    public function textCount($string)
    {
        $message = explode(" ", $string);
        return count($message);
    }

    public function textByIndex($string, $index)
    {
        $origin = explode(" ", $string);
        return $origin[$index];
    }

}