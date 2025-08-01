<?php
include_once '../inc/globalHead.php';

$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

$basePath = dirname($scriptName);
$uri = str_replace($basePath, '', $requestUri);

$parts = explode('/', trim($uri, '/'));

// Se tiver algo após /profile/, assumimos como username
if (isset($parts[1]) && !isset($_GET['username'])) {
    $_GET['username'] = $parts[1];
}
?>

<main>
  <!-- CONTENT -->
  <?php include_once '../components/global/menuTop.php'?>
  <?php include_once '../components/profile.php'?>
  <?php include_once '../components/global/menuBottom.php'?>
  <!-- END -->

  <!-- MODALS -->
  <?php include_once '../components/modals/edit.php'?>
</main>

<?php include_once '../inc/globalFooter.php'?>
