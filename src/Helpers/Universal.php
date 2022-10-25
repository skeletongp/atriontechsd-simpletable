<?php

use Carbon\Carbon;
use Cloudinary\Cloudinary;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

function formatNumber($number, $lenght = 2)
{
    $number = floatval(str_replace(',', '', $number));
    $formatted = rtrim(rtrim(number_format($number, 4, ".", ""), '0'), '.');
    if (!strpos('.', $formatted)) {
        $formatted = number_format($formatted, $lenght);
    }
    return $formatted;
}
function removeComma($number)
{
    $withoutComma = preg_replace("/[^0-9.-]/", "", $number);
    if (is_numeric($withoutComma)) {
        return $withoutComma;
    }
    return 0;
}
function linkPhoto($link)
{

    if (str_starts_with($link, 'http')) {
        $photo = str_replace('http:', 'https:', $link);
        return asset($photo);
    }
    return $link;
}


/* @params Invoices $array, Related $key, Field $value */
/* Return Field´s Value from Related */
function arrayFind(array $array, $key, $value)
{
    $result = 0;
    foreach ($array as $ind => $item) {
        if ($array[$ind][$key] == $value) {
            $result = $item;
        }
    }
    return $result;
}
function admins()
{
    $store = auth()->user()->store;
    if (!Cache::get($store->id . 'admins')) {
        Cache::put($store->id . 'admins', $store->users()->role('Administrador')->where('loggeable', 'yes')
            ->orderBy('lastname')->pluck('password', 'fullname'));
    }

    return Cache::get($store->id . 'admins');
}
function formatDate($date, $format)
{
    return Carbon::parse($date)->format($format);
}
function getApi($endPoint)
{
    $url = null;
    if (strpos($endPoint, 'api')) {
        $url = $endPoint;
    } else {
        $url = env('BASE_URL') . $endPoint;;
    }
    $response = Http::withHeaders([
        'Accept' => 'application/json',

    ])->withToken(env('TOKEN'))
        ->get($url);
    return $response->json();
}
function ellipsis($string, $maxLength)
{
    if (mb_strlen($string) > $maxLength) {
        return mb_substr($string, 0, $maxLength) . '...';
    }
    return $string;
}
function getNextDate(string $recurrency, $date)
{
    $fecha = Carbon::createFromDate($date);
    $recurrency = mb_strtolower($recurrency);
    switch ($recurrency) {
        case 'diario':
            $fecha->addDay();
            $fecha_db = $fecha->toDateString();
            break;
        case 'semanal':
            $fecha->addWeek();
            $fecha_db = $fecha->toDateString();
            break;
        case 'quincenal':
            $fecha->addDays(3);
            $day = $fecha->format('d');
            if ($day < 15) {
                $fecha = $fecha->day(15);
            } else {
                $fecha = $fecha->lastOfMonth();
            }
            $fecha_db = $fecha->toDateString();
            break;
        case 'mensual':
            $fecha->addMonth();
            $fecha_db = $fecha;
            break;
    }
    return Carbon::parse($fecha_db);
}
function operate($a, $op, $b)
{
    $a = floatval(str_replace(',', '', $a));
    $b = floatval(str_replace(',', '', $b));
    switch ($op) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            return $a / $b;
        default:
            return null;
    }
}
function removeAccent($cadena)
{

    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    //  $cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena
    );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena
    );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena
    );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena
    );



    return $cadena;
}
function paginate($items, $perPage = 5, $page = null, $options = [])
{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    $lgn = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    $lgn->setCollection($items->forPage($page, $perPage));

    return $lgn;
}
function sortRelation(EloquentCollection $model, $sort = 'id', $asc = false)
{
    $sorteable = collect($model->first()->sorteable);
    if (strtolower($asc) == 'true') {
        $asc = true;
    } else {
        $asc = false;
    };
    $results = [];
    if (preg_match('/[a-zA-Z]([.][a-zA-Z])/', $sort, $matches)) {
        $sorts = explode('.', $sort);
        if ($sorteable->contains($sort)) {
            $results = $model->sortBy(function ($item) use ($sorts) {
                return $item->{$sorts[0]}->{$sorts[1]};
            }, SORT_REGULAR, !$asc)->all();
        } else {
            return [];
        }
    }
    return $results;
}

function nested($model, $field)
{
    if (optional($model->first())->{$field}) {
        return $model->groupBy($field);
    }
    return $model;
}

use Twilio\Rest\Client as TwilioClient;



function nomPropio($cadena)
{
    $cadena = mb_strtolower($cadena);
    $cadena = ucwords($cadena);
    return $cadena;
}
