<?php
if (!defined('prevent_direct_access'))
{
    // prevent direct access to this file
    die();
}
class Caching
{
    private static $cache_file = 'cache.json';
    private static $cache;
    function __construct()
    {
        self::SetCache();
    }

    private static function SetCache() : void
    {
        if (file_exists(self::$cache_file))
        {
            self::$cache = json_decode(file_get_contents(self::$cache_file), true);
        }else{
            // this class is always included after $engine
            self::$cache = $engine->database->ReadAll('cache');
            file_put_contents(self::$cache_file, json_encode(self::$cache));
        }

    }

    /*
     * return the cache key
     * */
    public static function AddItemToCache(int $authorId, string $value, bool $isEncrypted = false) : string
    {
        $key = Engine::Random_str(128);
        $entry = [   'key' => $key,
            'authenticationId' => $authorId,
            'value' => $value,
            'isEncrypted' => $isEncrypted
        ];
        // this class is always included after $engine
        $engine->database->Create('cache', $entry);
        array_push(self::$cache, $entry);

        return $key;
    }

    /*
     * Attempts to get a cache item.
     * Can return null if the cache item is not found.
     * */
    public static function TryGetCacheItem(string $key) : mixed
    {
        // this class is always included after $engine
        $entry = $engine->database->Read('cache', ['key' => $key]);
        return $entry;
    }

    public static function ClearCache() : void
    {
        self::$cache = [];
        unlink(self::$cache_file);
    }

    public static function RefreshCache() : void
    {
        self::ClearCache();
        self::SetCache();
    }
}