<?php

class Push7_Admin_Notices {
  public function __construct() {
    add_action('admin_notices', array($this, 'check_setting'));
    add_action('admin_notices', array($this, 'message'));
  }

  public function check_setting() {
    if (get_option("push7_appno") && get_option("push7_apikey")) return;
    ?>
      <div class='update-nag is-dismissible'>
        <p>
        <?php
          printf(
            __('Push7のダッシュボードにある自動プッシュ設定から、必要なAPPNOとAPIKEYを取得し%sから記入して下さい。', 'push7'),
            sprintf('<a href="%s">%s</a>', Push7::admin_url(), __('こちら', 'push7'))
          );
        ?>
        </p>
      </div>
    <?php
  }

  public function message() {
    $types = array(
      array(
        'name'  => 'success',
        'class' => 'notice-success'
      ),
      array(
        'name'  => 'error',
        'class' => 'error'
      ),
      array(
        'name'  => 'notice',
        'class' => 'update-nag'
      )
    );

    foreach ($types as $type) {
      if (!isset($_SESSION['p7_'.$type['name']])) continue;
      ?>
        <div class="notice <?= $type['class'] ?> is-dismissible">
          <p>
            Push7: <?= $_SESSION['p7_'.$type['name']]; ?>
          </p>
        </div>
      <?php
      unset($_SESSION['p7_'.$type['name']]);
      return;
    }
  }
}
