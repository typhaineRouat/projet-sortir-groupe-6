<?php
namespace App\Data;


class SearchData{

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var string
     */
    public $site ;

    /**
     * @var
     */
    public $dateMax;

    /**
     * @var
     */
    public $dateMin;

    /**
     * @var boolean
     */
    public $sortiePassee = false;

    /**
     * @var boolean
     */
    public $sortieOrga = false;

    /**
     * @var boolean
     */
    public $sortieInscrit = false;

    /**
     * @var boolean
     */
    public $sortiePasInscrit = false;


}