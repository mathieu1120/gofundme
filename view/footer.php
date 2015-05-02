<p class="page-footer">GoFundMe Code-Sample. Mathieu Bertholino</p>
</div>
<?php
foreach ($viewVars['media']['js'] as $js)
{
  if (file_exists(JS_DIR.$js.'.js'))
  echo '<script type="text/javascript" src="'.JS_URI.dp($js).'.js?'.time().'"></script>';
}
?>
</body>
</html>