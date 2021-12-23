<?php
/**
 * @var string $header
 * @var string $content
 */
?>

<div class="panel-group" id="accordion2">
    <div class="card panel">
        <div class="card-head card-head-xs collapsed style-success" data-toggle="collapse" data-parent="#accordion2"
             data-target="#accordion2-1">
            <header>
                <?= $header ?>
            </header>
            <div class="tools">
                <a class="btn btn-icon-toggle">
                    <i class="fa fa-angle-down"></i>
                </a>
            </div>
        </div>
        <div id="accordion2-1" class="collapse in">
            <div class="card-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>