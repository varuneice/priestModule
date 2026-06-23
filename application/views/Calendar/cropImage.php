<section class="content-header">
    <h1>
        <?php echo __('crop_image'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Calendar/index"><?php echo __('calendars'); ?></a></li>
        <li class="active"><?php echo __('crop_image'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <fieldset class="requiresjcrop" style="margin: .5em 0;">
            <legend><?php echo __('change_image'); ?></legend>
            <div class="btn-group">
                <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . "calendars/thumb/" . $tpl['arr']['thumb'])) { ?>
                    <button class="btn" id="img1"><?php echo __('thumb'); ?></button>
                <?php } ?>
                <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . "calendars/medium/" . $tpl['arr']['medium'])) { ?>
                    <button class="btn" id="img2"><?php echo __('medium'); ?></button>
                <?php } ?>
                <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . "calendars/preview/" . $tpl['arr']['preview'])) { ?>
                    <button class="btn active" id="img3"><?php echo __('preview'); ?></button>
                <?php } ?>
            </div>
        </fieldset>

        <fieldset class="form-actions">
            <?php
            if (is_file(INSTALL_PATH . UPLOAD_PATH . "calendars/preview/" . $tpl['arr']['preview'])) {
                $type = 'preview';
                ?>
                <img src='<?php echo INSTALL_URL . UPLOAD_PATH . "calendars/preview/" . $tpl['arr']['preview']; ?>' id="cropbox" >
                <?php
            } elseif (is_file(INSTALL_PATH . UPLOAD_PATH . "calendars/medium/" . $tpl['arr']['medium'])) {
                $type = 'medium';
                ?>
                <img src='<?php echo INSTALL_URL . UPLOAD_PATH . "calendars/medium/" . $tpl['arr']['medium']; ?>' id="cropbox" >
                <?php
            } elseif (is_file(INSTALL_PATH . UPLOAD_PATH . "calendars/thumb/" . $tpl['arr']['thumb'])) {
                $type = 'thumb';
                ?>
                <img src='<?php echo INSTALL_URL . UPLOAD_PATH . "calendars/preview/" . $tpl['arr']['thumb']; ?>' id="cropbox" >
            <?php } ?>
            <div style="margin: .8em 0 .5em;">
                <span class="requiresjcrop">
                    <button id="setSelect" class="btn btn-mini"><?php echo __('setSelect'); ?></button>
                    <button id="animateTo" class="btn btn-mini"><?php echo __('animateTo'); ?></button>
                    <button id="release" class="btn btn-mini"><?php echo __('Release'); ?></button>
                    <button id="disable" class="btn btn-mini"><?php echo __('Disable'); ?></button>
                </span>
                <button id="enable" class="btn btn-mini" style="display:none;"><?php echo __('Re-Enable'); ?></button>
                <button id="unhook" class="btn btn-mini">Destroy!</button>
                <button id="rehook" class="btn btn-mini" style="display:none;"><?php echo __('AttachJcrop'); ?></button>
            </div>
        </fieldset>

        <fieldset>
            <form action="<?php echo INSTALL_URL; ?>?controller=Calendar&action=cropImage&id=<?php echo $tpl['arr']['id'] ?? ''; ?>" method="post" >
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <fieldset class="form-actions">
                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />
                    <input type="hidden" name="type" id="type" value="<?php echo $type; ?>" /> 
                    <input type="hidden" name="action" value="cropImage" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['arr']['id'] ?? ''; ?>" />
                    <input type="hidden" name="crop_img" value="1" /> 
                    <button id="submit" class="btn btn-default" autocomplete="off" value="Save" name="save" tabindex="9"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                </fieldset>
            </form>
        </fieldset>
    </div>
</section>
<script type="text/javascript">
    (function($) {
        $(function() {

            // The variable jcrop_api will hold a reference to the
            // Jcrop API once Jcrop is instantiated.
            var jcrop_api;
            // In this example, since Jcrop may be attached or detached
            // at the whim of the user, I've wrapped the call into a function
            initJcrop();
            // The function is pretty simple
            function initJcrop()//{{{
            {
                // Hide any interface elements that require Jcrop
                // (This is for the local user interface portion.)
                $('.requiresjcrop').hide();
                // Invoke Jcrop in typical fashion
                $('#cropbox').Jcrop({
                    onSelect: updateCoords,
                    onRelease: releaseCheck
                }, function() {

                    jcrop_api = this;
                    jcrop_api.animateTo([100, 100, 400, 300]);
                    // Setup and dipslay the interface for "enabled"
                    $('#can_click,#can_move,#can_size').attr('checked', 'checked');
                    $('#ar_lock,#size_lock,#bg_swap').attr('checked', false);
                    $('.requiresjcrop').show();
                });
            }
            ;
            //}}}

            // Use the API to find cropping dimensions
            // Then generate a random selection
            // This function is used by setSelect and animateTo buttons
            // Mainly for demonstration purposes
            function getRandom() {
                var dim = jcrop_api.getBounds();
                return [
                    Math.round(Math.random() * dim[0]),
                    Math.round(Math.random() * dim[1]),
                    Math.round(Math.random() * dim[0]),
                    Math.round(Math.random() * dim[1])
                ];
            }
            ;
            // This function is bound to the onRelease handler...
            // In certain circumstances (such as if you set minSize
            // and aspectRatio together), you can inadvertently lose
            // the selection. This callback re-enables creating selections
            // in such a case. Although the need to do this is based on a
            // buggy behavior, it's recommended that you in some way trap
            // the onRelease callback if you use allowSelect: false
            function releaseCheck()
            {
                jcrop_api.setOptions({allowSelect: true});
                $('#can_click').attr('checked', false);
            }
            ;
            // Attach interface buttons
            // This may appear to be a lot of code but it's simple stuff
            $('#setSelect').click(function(e) {
                // Sets a random selection
                jcrop_api.setSelect(getRandom());
            });
            $('#animateTo').click(function(e) {
                // Animates to a random selection
                jcrop_api.animateTo(getRandom());
            });
            $('#release').click(function(e) {
                // Release method clears the selection
                jcrop_api.release();
            });
            $('#disable').click(function(e) {
                // Disable Jcrop instance
                jcrop_api.disable();
                // Update the interface to reflect disabled state
                $('#enable').show();
                $('.requiresjcrop').hide();
            });
            $('#enable').click(function(e) {
                // Re-enable Jcrop instance
                jcrop_api.enable();
                // Update the interface to reflect enabled state
                $('#enable').hide();
                $('.requiresjcrop').show();
            });
            $('#rehook').click(function(e) {
                // This button is visible when Jcrop has been destroyed
                // It performs the re-attachment and updates the UI
                $('#rehook,#enable').hide();
                initJcrop();
                $('#unhook,.requiresjcrop').show();
                return false;
            });
            $('#unhook').click(function(e) {
                // Destroy Jcrop widget, restore original state
                jcrop_api.destroy();
                // Update the interface to reflect un-attached state
                $('#unhook,#enable,.requiresjcrop').hide();
                $('#rehook').show();
                return false;
            });
            // Hook up the three image-swapping buttons
            $('#img1').click(function(e) {
                $("#type").val('thumb');
                $(this).addClass('active').closest('.btn-group').find('button.active').not(this).removeClass('active');
                jcrop_api.setImage('<?php echo INSTALL_FOLDER . UPLOAD_PATH . "calendars/thumb/" . $tpl['arr']['thumb']; ?>');
                jcrop_api.setOptions({bgOpacity: .6});
                return false;
            });
            $('#img2').click(function(e) {
                $("#type").val('medium');
                $(this).addClass('active').closest('.btn-group').find('button.active').not(this).removeClass('active');
                jcrop_api.setImage('<?php echo INSTALL_FOLDER . UPLOAD_PATH . "calendars/medium/" . $tpl['arr']['medium']; ?>');
                jcrop_api.setOptions({bgOpacity: .6});
                return false;
            });
            $('#img3').click(function(e) {
                $("#type").val('preview');
                $(this).addClass('active').closest('.btn-group').find('button.active').not(this).removeClass('active');
                jcrop_api.setImage('<?php echo INSTALL_FOLDER . UPLOAD_PATH . "calendars/preview/" . $tpl['arr']['preview']; ?>');
                jcrop_api.setOptions({bgOpacity: .6});
                return false;
            });
            return false;

            // The checkboxes simply set options based on it's checked value
            // Options are changed by passing a new options object

            // Also, to prevent strange behavior, they are initially checked
            // This matches the default initial state of Jcrop

            $('#can_click').change(function(e) {
                jcrop_api.setOptions({allowSelect: !!this.checked});
                jcrop_api.focus();
            });
            $('#can_move').change(function(e) {
                jcrop_api.setOptions({allowMove: !!this.checked});
                jcrop_api.focus();
            });
            $('#can_size').change(function(e) {
                jcrop_api.setOptions({allowResize: !!this.checked});
                jcrop_api.focus();
            });
            $('#ar_lock').change(function(e) {
                jcrop_api.setOptions(this.checked ?
                        {aspectRatio: 4 / 3} : {aspectRatio: 0});
                jcrop_api.focus();
            });
            $('#size_lock').change(function(e) {
                jcrop_api.setOptions(this.checked ? {minSize: [80, 80],
                    maxSize: [350, 350]
                } : {minSize: [0, 0], maxSize: [0, 0]
                });
                jcrop_api.focus();
            });

            function updateCoords(c)
            {
                $('#x').val(c.x);
                $('#y').val(c.y);
                $('#w').val(c.w);
                $('#h').val(c.h);
            }
            ;

        });
    }(jQuery));
</script>