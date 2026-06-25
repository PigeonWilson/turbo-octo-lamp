<?php
// folders
$css = 'template' . DIRECTORY_SEPARATOR . 'css';
$html = 'template' .  DIRECTORY_SEPARATOR . 'html';
$partial = 'template' .  DIRECTORY_SEPARATOR  . 'html' .  DIRECTORY_SEPARATOR . 'partial';
$javascript = 'template' .  DIRECTORY_SEPARATOR  . 'javascript';

class Publication
{
    private Db $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function PathCombine($baseDirectory, $file) : string
    {
        return $baseDirectory . DIRECTORY_SEPARATOR . $file;
    }

    public function GetContent(string $path) : string
    {
        return file_get_contents($path);
    }

    public function MergeFile(array $files) : string
    {
        $result = '';
        foreach ($files as $file) {
            $result .= $this->GetContent($file) .PHP_EOL;
        }
        return $result;
    }

    /*
     * string $html : html file content
     * string $css : css file file content
     * string $javascript : javascript file content
     * array $data : data to be passed to the page
     * */
    public function NewPage(string $html, string $css, string $javascript, array $data) : string
    {

    }
}