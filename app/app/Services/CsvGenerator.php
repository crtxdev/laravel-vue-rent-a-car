<?php

namespace App\Services;

class CsvGenerator
{

  protected $headings;
  protected $data;
  protected $path;

  public function __construct($headings = [], $data = [], $path = null)
  {
    $this->headings = $headings;
    $this->data = $data;
    $this->path = $path;
    $this->fullPath = public_path($this->path);
    if(!file_exists(dirname($this->fullPath))){
      mkdir(dirname($this->fullPath), 0777, true);
    }
  }

  public function generate()
  {
    $fp = fopen($this->fullPath, 'w+');
    fputcsv($fp, $this->headings);
    foreach($this->data as $row){
      fputcsv($fp, $row);
    }
    fclose($fp);
    return $this->path;
  }

}