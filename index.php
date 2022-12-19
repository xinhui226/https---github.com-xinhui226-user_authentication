<?php
session_start();

$database = new PDO(
  'mysql:host=devkinsta_db;
  dbname=User_Auth',
  'root',
  'cD4FYhCb9HPk9bc0'
);

$query = $database->prepare('SELECT * FROM students');
$query->execute();

$students = $query->fetchAll();

if($_SERVER['REQUEST_METHOD']=='POST'){

  if($_POST['action']=='logout'){
    unset($_SESSION['user']);
    
    header('Location: /');
    exit;
  }

  if($_POST['action']==='add'){
    $statement=$database->prepare("INSERT INTO students (`name`) VALUES (:name) ");
    $statement->execute([
        'name'=> $_POST['student']
    ]);

    header('Location:/');
    exit;
}

elseif($_POST['action']==='delete'){
    $statement=$database->prepare("DELETE FROM students where id=:id");
    $statement->execute([
       'id'=>$_POST['student_id']
    ]);

    header('Location:/');
    exit;
}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Classroom Management</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    />
    <style type="text/css">
      body {
        background: #f1f1f1;
      }
      .logout{
        text-decoration: underline !important;
    border: 0 !important;
    color: #0D6EFD;
    
    background: transparent
      }
    </style>
  </head>
  <body>

  <?php if(isset($_SESSION['user'])):?>
   

   <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <div class="justify-content-between d-flex align-items-center">
          <h3 class="card-title d-inline-block">My Classroom</h3>
          <div class="d-inline-block"> 
            <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
    <input type="hidden" name="action" value="logout">
    <input type="submit" value="Log Out" class="logout">
   </form>
          </div>
        </div>

        <div class="mt-4">
            <form action="  <?php echo $_SERVER['REQUEST_URI'];?>" method="POST" class="d-flex justify-content-between align-items-center">
                <input
                type="text"
                class="form-control"
                placeholder="Add new student..."
                name="student"
                required
                />
                <input 
                type="hidden" 
                name="action" 
                value="add"
                />
                <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
            </form>
        </div><!--mt-4 d-flex-->
      </div><!--card-body-->
    </div><!--card-->

    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <h3 class="card-title mb-3">Students</h3>
        <div class="mt-4">
<ol>

 <?php foreach($students as $student):?>
  <li class="fw-bold">

    <div class="d-flex justify-content-between">
      <?php echo $student['name'];?>
      <form method="POST" action="  <?php echo $_SERVER['REQUEST_URI'];?>">
        <input type="hidden" name="student_id" value="  <?php echo $student['id'];?>"/>
        <input type="hidden" name="action" value="delete"/>
        <button class="btn btn-danger mb-1 rounded-1">Remove</button>
      </form>
    </div>
  </li>
                  <?php endforeach; ?>
 
  </ol>
             

        </div><!--mt-4 d-flex-->
      </div><!--card-body-->
    </div><!--card-->


<?php else :?>

  <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <div class="justify-content-between d-flex align-items-center">
          <h3 class="card-title d-inline-block">My Classroom</h3>
          <div class="d-inline-block"> 
            <a href="login.php">Login</a>
              <a href="signup.php">Sign Up</a>
          </div>
        </div>

        <div class="mt-4">
        </div><!--mt-4 d-flex-->
      </div><!--card-body-->
    </div><!--card-->

    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <h3 class="card-title mb-3">Students</h3>
        <div class="mt-4">
<ol>

  <?php foreach($students as $student):?>
    <li class="fw-bold">
      <?php echo $student['name'];?>
      </form>
    </li>
    <?php endforeach; ?>
  </ol>
           
        </div><!--mt-4 d-flex-->
      </div><!--card-body-->
    </div><!--card-->

<?php endif;?>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
