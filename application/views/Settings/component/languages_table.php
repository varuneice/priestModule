<div class="callout callout-info">
    <h4>Languages</h4>
    <p>
        Add as many languages as you need to your script. For each of the languages added you need to translate all the text titles.
    </p>
</div>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="gz-shopping-cart-languages-table-id" class="gzblog-table" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th class="">Language</th>
            <th>Flag</th>
            <th>Is default</th>
            <th>Orders</th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['languages']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                <tr id="<?php echo $tpl['languages'][$i]['id']; ?>" class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td>
                        <input type="hidden" id="<?php echo $tpl['languages'][$i]['id']; ?>" name="order[]" value="<?php echo $tpl['languages'][$i]['id']; ?>" />
                        <?php echo $tpl['languages'][$i]['language']; ?>
                    </td>
                    <td>
                        <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'flag/' . $tpl['languages'][$i]['flag'])) { ?>
                            <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'flag/' . $tpl['languages'][$i]['flag']; ?>" />
                            <?php
                        } else {
                            echo $tpl['languages'][$i]['language'];
                        }
                        ?>
                    </td>
                    <td><?php
                        if ($tpl['languages'][$i]['isdefault'] == 1) {
                            ?>
                            <a class="gz-active" rev="<?php echo $tpl['languages'][$i]['id']; ?>"><i class="fa fa-fw fa-check-square"></i></a>
                            <?php
                        } else {
                            ?>
                            <a class="gz-disabled" data-id="<?php echo $tpl['languages'][$i]['id']; ?>"><i class="fa fa-fw fa-minus-square"></i></a>
                            <?php
                        }
                        ?></td>
                    <td><?php echo $tpl['languages'][$i]['order']; ?></td>
                    <td><a class="btn btn-default btn-sm icon-edit" href="<?php echo INSTALL_URL; ?>?controller=Settings&action=edit_language&id=<?php echo $tpl['languages'][$i]['id']; ?>" rev="<?php echo $tpl['languages'][$i]['id']; ?>" ><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td>
                        <?php if ($tpl['languages'][$i]['isdefault'] != 1) { ?>
                            <a class="btn btn-default btn-sm icon-delete" rev="<?php echo $tpl['languages'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>?controller=Settings&action=delete_language&id=<?php echo $tpl['languages'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="10">
                    No Languages found
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-flat">Action</button>
                    <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a id="add-language-id" href="<?php echo INSTALL_URL; ?>?controller=Settings&action=addLanguage">add language</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>