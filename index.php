<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }
?>
<?php 
    // initialize errors variable
  $errors = "";

  // connect to database
  $db = mysqli_connect("localhost", "root", "", "todo");

  // insert a quote if submit button is clicked
  if (isset($_POST['submit'])) {
    if (empty($_POST['task'])) {
      $errors = "You must fill in the task";
    }else{
      $task = $_POST['task'];
      $sql = "INSERT INTO tasks (task) VALUES ('$task')";
      mysqli_query($db, $sql);
      header('location: index.php');
    }
  } 
  if (isset($_GET['del_task'])) {
  $id = $_GET['del_task'];

  mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
  header('location: index.php');
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>ToDo List Application PHP and MySQL</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css'>
<link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" type="text/css" href="styling.css">
</head>

<body>
<div class="heading">
  <div class="header">
  <h2>Home Page</h2>
</div>
    <h2 style="font-style: 'Hervetica';">ToDo List Application PHP and MySQL database</h2>
  </div>


<div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
        <h3>
          <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
          ?>
        </h3>
      </div>
    <?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
      <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
      <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>

  <form method="post" action="index.php" class="input_form">
  
  <?php if (isset($errors)) { ?>
    <p><?php echo $errors; ?></p>
  <?php } ?>
    
    <input type="text" name="task" class="task_input">
    <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
  </form>
<table>
  <thead>
    <tr>
      <th>N</th>
      <th>Tasks</th>
      <th style="width: 60px;">Action</th>
    </tr>
    <!-- ======================= -->
  <!-- <div id="app"></div>             -->
  <!-- =========================== -->
  </thead>

  <tbody>
    <?php 
    // select all tasks if page is visited or refreshed
    $tasks = mysqli_query($db, "SELECT * FROM tasks");

    $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
      <tr>
        <td> <?php echo $i; ?> </td>
        <td class="task"> <input type="checkbox" class="form-check-input" value="on"> <?php echo $row['task']; ?> </td>
        <td class="delete"> 
          <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
        </td>
        
      </tr>
    <?php $i++; } ?>  
  </tbody>
</table>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/react/15.3.1/react.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/react/15.3.1/react-dom.min.js'></script>
<script  src="script.js"></script>
</body>
</html>