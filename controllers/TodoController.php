<?php
require_once(__DIR__ . '/../models/Todo.php');

class TodoController
{
  public function index()
  {
    $todoModel = new Todo();
    $todos = $todoModel->getAllTodos();
    include(__DIR__ . '/../views/index.php');
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $activity = $_POST['activity'];
  
      $todoModel = new Todo();
  
      // Cek apakah aktivitas sudah ada sebelumnya
      $existingTodos = $todoModel->getAllTodos();
      $inputActivity = strtolower($activity);
      
      foreach ($existingTodos as $existingTodo) {
        $existingActivity = strtolower($existingTodo['activity']);
        if ($existingActivity === $inputActivity) {
          // Tampilkan pesan kesalahan sebagai alert
          echo '<script>alert("Aktivitas tidak boleh sama!");</script>';
          // Tetap berada di "index.php"
          echo '<script>window.location = "index.php";</script>';
          exit;
        }
      }
  
      $todoModel->createTodo($activity);
    }
  
    header('Location: index.php');
  }
  
  public function update()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $activity = $_POST['activity'];
    $status = $_POST['status'];

    $todoModel = new Todo();

    // Cek apakah aktivitas sudah ada sebelumnya (kecuali yang sedang diperbarui)
    $existingTodos = $todoModel->getAllTodos();
    $inputActivity = strtolower($activity);
    
    foreach ($existingTodos as $existingTodo) {
      $existingActivity = strtolower($existingTodo['activity']);
      if ($existingActivity === $inputActivity && $existingTodo['id'] != $id) {
        // Tampilkan pesan kesalahan sebagai alert
        echo '<script>alert("Aktivitas tidak boleh sama!");</script>';
        // Tetap berada di "index.php"
        echo '<script>window.location = "index.php";</script>';
        exit;
      }
    }

    $todoModel->updateTodo($id, $activity, $status);
  }

  header('Location: index.php');
}


  public function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
      $id = $_GET['id'];

      $todoModel = new Todo();
      $todoModel->deleteTodo($id);
    }

    header('Location: index.php');
  }
}