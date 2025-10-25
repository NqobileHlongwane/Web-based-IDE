<?php
$action = $_GET['action'] ?? '';
$filename = $_GET['file'] ?? '';
$dir = __DIR__ . '/files';

if (!is_dir($dir)) mkdir($dir);

switch ($action) {
  case 'list':
    $files = array_diff(scandir($dir), ['.', '..']);
    echo json_encode(array_values($files));
    break;

  case 'create':
    if (!$filename) {
      echo json_encode(['message' => 'Filename required']);
      break;
    }
    file_put_contents("$dir/$filename", json_encode(["html" => "", "css" => "", "js" => ""]));
    echo json_encode(['message' => "File '$filename' created"]);
    break;

  case 'save':
    $content = file_get_contents("php://input");
    file_put_contents("$dir/$filename", $content);
    echo json_encode(['message' => "File '$filename' saved"]);
    break;

  case 'delete':
    if (file_exists("$dir/$filename")) {
      unlink("$dir/$filename");
      echo json_encode(['message' => "File '$filename' deleted"]);
    } else {
      echo json_encode(['message' => "File not found"]);
    }
    break;

  default:
    echo json_encode(['message' => 'Invalid action']);
}
?>
