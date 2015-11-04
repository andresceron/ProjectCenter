<?php
class VARIABLES {
    private $db;

    function __construct($DB_con) {
        $this->db = $DB_con;
    }

    public $url_page = "/views/pages";
    public $url_partial = "/views/partials";
  
    public function getUrl() {
        $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        $url .= $_SERVER["REQUEST_URI"];
        return $url;
    }
    public function getAssetsImg() {
        $url_assets_img  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $url_assets_img .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        $url_assets_img .= '/ProjectCenter';
        $url_assets_img .= '/assets/img';
        return $url_assets_img;
    }
    public function getAssetsCSS() {
        $url_assets_css  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $url_assets_css .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        $url_assets_css .= '/ProjectCenter';
        $url_assets_css .= '/assets/css';
        return $url_assets_css;
    }

    public function getAssetsJS() {
        $url_assets_js  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $url_assets_js .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        $url_assets_js .= '/ProjectCenter';
        $url_assets_js .= '/assets/js';
        return $url_assets_js;
    }
    
    public  function curPageName() {
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }

}
?>