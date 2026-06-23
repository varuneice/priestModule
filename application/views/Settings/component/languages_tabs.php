<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#tab_1">Titles</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab_2">Languages</a>
        </li>
    </ul>    
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
             <?php require 'local_table.php'; ?>
        </div>
        <div id="tab_2" class="tab-pane">
            <?php require 'languages_table.php'; ?>
        </div>
    </div>
</div>