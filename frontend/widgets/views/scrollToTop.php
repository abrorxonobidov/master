<?php
/**
 * Created by PhpStorm.
 * User: m_mirmaksudov
 * Date: 01.09.2015
 * Time: 8:37
 */

/**
 * @var $this View
 */
use yii\web\View;

?>
    <a id="oz-scroll" class="style2" href="#"><i class="fa fa-chevron-up"></i> </a>

<?
$this->registerJs('
$(function () {
    "use strict";
	var $ele = $(\'#oz-scroll\');
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 200) {
            $ele.show().animate({right: \'15px\'}, 10);
        } else {
            $ele.animate({right: \'-80px\'}, 10);
        }
    });
    $ele.click(function (e) {
        e.preventDefault();
        $(\'html,body\').animate({
            scrollTop: 0
        }, 600);
    });
});
');
$this->registerCss("
#oz-scroll {
    z-index:3000;
	position:fixed;
	bottom:40px;
	right:-80px;
	height:48px;
	width:48px;
	overflow:hidden;
	display:none;
	zoom:1;
	filter:alpha(opacity=60);
	opacity:.6;
	-webkit-transition:all .5s ease-in-out;
	-moz-transition:all .5s ease-in-out;
	-ms-transition:all .5s ease-in-out;
	-o-transition:all .5s ease-in-out;
	transition:all .5s ease-in-out;
	border-radius:25px;
	color:#ffffff;
}

#oz-scroll:hover {opacity:1}
#oz-scroll i {
    margin: 11px;
    max-width:100%
}


.style2 {
    background:#77787a;
    font-size:25px;
    
}

");
?>