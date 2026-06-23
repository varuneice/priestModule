<div id="gz-abc-main-container">
    <div class="overlay" style="display: block"></div>
    <div class="loading-img"></div>
    <?php require 'component/lang.php'; ?>
    <?php
    foreach ((array)($_GET['cid'] ?? []) as $cid) {
        ?>
        <div id="gz-abc-main-container-<?php echo $cid; ?>">
            <div id="gz-abc-calendar-container-<?php echo $cid; ?>">
                <?php require 'component/calendars.php'; ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<script type="text/javascript">
    var GzAvailabilityCalendarObj = new Array();

    (function() {
        "use strict";
        var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor), loadCssHack = function(url, callback) {
            var link = document.createElement("link");
            link.type = "text/css";
            link.rel = "stylesheet";
            link.href = url;
            document.getElementsByTagName("head")[0].appendChild(link);
            var img = document.createElement("img");
            img.onerror = function() {
                if (callback && typeof callback === "function") {
                    callback();
                }
            };
            img.src = url;
        }, loadRemote = function(url, type, callback) {
            if (type === "css" && isSafari) {
                loadCssHack(url, callback);
                return;
            }
            var _element, _type, _attr, scr, s, element;
            switch (type) {
                case "css":
                    _element = "link";
                    _type = "text/css";
                    _attr = "href";
                    break;
                case "js":
                    _element = "script";
                    _type = "text/javascript";
                    _attr = "src";
                    break;
            }
            scr = document.getElementsByTagName(_element);
            s = scr[scr.length - 1];
            element = document.createElement(_element);
            element.type = _type;
            if (type == "css") {
                element.rel = "stylesheet";
            }
            if (element.readyState) {
                element.onreadystatechange = function() {
                    if (element.readyState == "loaded" || element.readyState == "complete") {
                        element.onreadystatechange = null;
                        if (callback && typeof callback === "function") {
                            callback();
                        }
                    }
                };
            } else {
                element.onload = function() {
                    if (callback && typeof callback === "function") {
                        callback();
                    }
                };
            }
            element[_attr] = url;
            s.parentNode.insertBefore(element, s.nextSibling);
        }, loadScript = function(url, callback) {
            loadRemote(url, "js", callback);
        }, loadCss = function(url, callback) {
            loadRemote(url, "css", callback);
        };
<?php
foreach ($this->controller->js as $js) {
    ?>
            loadScript("<?php echo (isset($js['remote']) && $js['remote'] ? NULL : INSTALL_URL) . $js['path'] . $js['file']; ?>", function() {
<?php } ?>

            var c = 0;
<?php
foreach ((array)($_GET['cid'] ?? []) as $cid) {
    ?>
                var options = {
                    cal_id: <?php echo $cid; ?>,
                    server: "<?php echo INSTALL_URL; ?>",
                    folder: "<?php echo INSTALL_FOLDER; ?>",
                    month: "<?php echo date('n'); ?>",
                    year: "<?php echo date('Y'); ?>",
                    view_month: "<?php echo $_GET['view_month'] ?? ''; ?>",
                    enable_booking: "<?php echo $tpl['option_arr_values'][$cid]['enable_booking']; ?>",
                    stripe_publish_key: "<?php echo $tpl['option_arr_values'][$cid]['stripe_publish_key']; ?>",
                    stripe_allow: "<?php echo ($tpl['option_arr_values'][$cid]['stripe_allow'] == '1') ? '1' : '0'; ?>",
                    locale: 1,
                    hide: 0
                };
                GzAvailabilityCalendarObj[c] = new GzAvailabilityCalendar(options);
                c++;
    <?php
}
?>
<?php
foreach ($this->controller->js as $js) {
    ?>
            });
<?php } ?>
    })();
</script>