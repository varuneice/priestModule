<?php

require_once CONTROLLERS_PATH . 'App.php';

class MemberCategory extends App {

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter() {
        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        if (!empty($this->tpl['option_arr_values']['date_format'])) {
            $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
            $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);
        }

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }

        if (!$this->isLoged() || !$this->isAdmin()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzAdmin.js', 'path' => JS_PATH);
    }

    function index() {
        GzObject::loadFiles('Model', array('MemberCategoryThreshold', 'ltdytdmember'));
        $MemberCategoryThresholdModel = new MemberCategoryThresholdModel();
        $ltdytdmemberModel = new ltdytdmemberModel();

        if (!empty($_POST['save_thresholds'])) {
            $saved = true;
            foreach (($_POST['threshold_amount'] ?? array()) as $id => $amount) {
                if (!$MemberCategoryThresholdModel->updateThresholdAmount($id, $amount)) {
                    $saved = false;
                }
            }
            $_SESSION['status'] = $saved ? 20 : 21;
            Util::redirect(INSTALL_URL . "MemberCategory/index");
        }

        $thresholds = $MemberCategoryThresholdModel->getActiveThresholds();
        $members = $ltdytdmemberModel->All(array());

        foreach ($members as $i => $member) {
            $eligible = $this->getEligibleCategories($member['LTC'] ?? 0, $thresholds, $member['Category'] ?? '');
            $members[$i]['eligible_categories'] = $eligible;
            $members[$i]['eligible_category_display'] = $this->getEligibleCategoryDisplay($eligible);
        }

        $this->tpl['thresholds'] = $thresholds;
        $this->tpl['members'] = $members;
    }

    function edit($id = null) {
        GzObject::loadFiles('Model', array('MemberCategoryThreshold', 'ltdytdmember', 'Member'));
        $MemberCategoryThresholdModel = new MemberCategoryThresholdModel();
        $ltdytdmemberModel = new ltdytdmemberModel();
        $MemberModel = new MemberModel();

        $id = (int) ($id ?? ($_GET['id'] ?? 0));
        if ($id <= 0) {
            Util::redirect(INSTALL_URL . "MemberCategory/index");
        }

        $memberRows = $ltdytdmemberModel->execute('SELECT * FROM ' . $ltdytdmemberModel->getTable() . ' WHERE ID = ' . $id . ' LIMIT 1');
        if (empty($memberRows)) {
            $_SESSION['status'] = 21;
            Util::redirect(INSTALL_URL . "MemberCategory/index");
        }

        $thresholds = $MemberCategoryThresholdModel->getActiveThresholds();
        $this->tpl['arr'] = $memberRows[0];
        $this->tpl['thresholds'] = $thresholds;
        $this->tpl['eligible_categories'] = $this->getEligibleCategories($this->tpl['arr']['LTC'] ?? 0, $thresholds, $this->tpl['arr']['Category'] ?? '');

        if (!empty($_POST['save_member_category'])) {
            $newCategory = strtoupper(trim((string) ($_POST['Category'] ?? '')));
            if ($this->isCategoryAllowed($newCategory, $this->tpl['eligible_categories']) && $this->isEditableMember($this->tpl['arr'])) {
                $saved = $this->updateMemberCategory($MemberModel, $id, $newCategory);
                $_SESSION['status'] = $saved ? 20 : 21;
            } else {
                $_SESSION['status'] = 21;
            }
            Util::redirect(INSTALL_URL . "MemberCategory/index");
        }
    }


    private function isCategoryAllowed($category, $eligibleCategories) {
        foreach ($eligibleCategories as $eligibleCategory) {
            if (strtoupper((string) $eligibleCategory['category_code']) === $category) {
                return true;
            }
        }

        return false;
    }

    private function isEditableMember($member) {
        $memberId = (int) ($member['Member_id'] ?? 0);
        $category = strtoupper(trim((string) ($member['Category'] ?? '')));
        $active = trim((string) ($member['Active'] ?? ''));
        $status = strtoupper(trim((string) ($member['status'] ?? '')));
        $firstSal = strtoupper(trim((string) ($member['FirstSal'] ?? '')));

        return $memberId > 0
            && $memberId < 10000
            && $category !== 'GC'
            && $active === ''
            && in_array($status, array('', 'T'))
            && $firstSal !== 'LATE';
    }

    private function updateMemberCategory($MemberModel, $id, $category) {
        $stmt = $MemberModel->getPdo()->prepare('UPDATE ' . $MemberModel->getTable() . ' SET Category = :category WHERE ID = :id');
        $stmt->execute(array(':category' => $category, ':id' => (int) $id));

        return true;
    }
    private function getEligibleCategories($ltc, $thresholds, $currentCategory = '') {
        $eligible = array();
        $ltc = (float) $ltc;
        $currentRank = $this->getCategoryRank($currentCategory);

        if ($currentRank === null) {
            return $eligible;
        }

        foreach ($thresholds as $threshold) {
            $categoryRank = $this->getCategoryRank($threshold['category_code'] ?? '');
            if ($categoryRank !== null && $categoryRank > $currentRank && $ltc >= (float) $threshold['threshold_amount']) {
                $eligible[] = $threshold;
            }
        }

        return $eligible;
    }

    private function getEligibleCategoryDisplay($eligible) {
        if (empty($eligible)) {
            return 'Not eligible';
        }

        $codes = array();
        foreach ($eligible as $category) {
            $codes[] = $category['category_code'];
        }

        return implode(', ', $codes);
    }

    private function getCategoryRank($category) {
        $ranks = array(
            'GM' => 0,
            'LM' => 1,
            'BF' => 2,
            'PM' => 3
        );

        $category = strtoupper(trim((string) $category));
        return array_key_exists($category, $ranks) ? $ranks[$category] : null;
    }
}
