    
    </body>
    <footer>
    <div id="loading" style="display:none">
      <div class="cv-spinner">
        <div class="spinner">
          <span class="one"></span>
          <span class="two"></span>
          <span class="three"></span>
          <span class="four"></span>
        </div>
        <div id="text-wait"></div>
      </div>
    </div>
  </footer>
    <!-- Chèn JS-->
    <script type="text/javascript" src="<?php echo $_DOMAIN; ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo $_DOMAIN; ?>assets/jquery/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo $_DOMAIN; ?>js/simplebar.min.js"></script>
    
    <!-- Plugins and scripts required by this view-->

    <?php
      $page_js[] = "";
      if ($page_js) {
        foreach ($page_js as $js) {
          if (!empty($js)) {
            echo '<script type="text/javascript" src="'.$_DOMAIN . $js . '"></script>' . "\n\t\t";
          }
       }
      }

      require_once($_SERVER['DOCUMENT_ROOT'] . '/EM/notification.php');
    ?>
</html>