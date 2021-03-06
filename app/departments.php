<?php
include_once 'includes/functions.php';
include_once 'includes/db_connection.php';
protect_page();

if(isset($_REQUEST['dpt_name'])){
    $dpt_name = $_REQUEST['dpt_name'];

    $sql_add_department = mysqli_prepare($db_conn, "INSERT INTO departments (`dpt_name`) VALUES (?)");
    mysqli_stmt_bind_param($sql_add_department, "s", $dpt_name);
    mysqli_stmt_execute($sql_add_department);
    mysqli_close($db_conn);
    setcookie('success', "department $dpt_name added", time()+2);
    header('location: departments.php');
}
$sql_fetch_departments = "SELECT * FROM departments";
$execute_sql_fetch_departments = mysqli_query($db_conn, $sql_fetch_departments) or die(mysqli_error($db_conn));
$fetched_departments = mysqli_fetch_all($execute_sql_fetch_departments, 1);
mysqli_close($db_conn);
?>
<!doctype html>
<html lang="en">
<head>
    <?php include_once 'includes/head_section_links.php'?>
    <title>View Departments</title>
</head>
<body>
<?php
    include_once 'includes/top_navbar.php';
    include_once 'includes/side_navbar.php';
?>
<div class="main_content">
    <div class="container pt-3">
        <div class="row">
            <div class="col-lg-8">
                <table id="example" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($fetched_departments as $department): ?>
                        <tr>
                            <td> <?= $department["dpt_name"] ?></td>
                            <td>
                                <div class="row d-flex">
                                    <a href="update_department_form.php?id=<?=$department['id']?>" class="btn btn-sm mr-2"><span class="icon-pencil text-info"></span></a>|
                                    <form action="includes/functions.php" method="post" class="form-inline ml-2">
                                        <input type="hidden" name="id" id="id" value="<?= $department['id'] ?>">
                                        <button class="btn btn-sm" type="submit" name="delete_department"><span class="icon-trash text-danger"></span></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Department</h4>
                    </div>
                    <div class="card-body">
                        <?= alerts() ?>
                        <form action="departments.php" method="post" autocomplete="off">
                            <div class="form-group">
                                <input type="text" name="dpt_name" id="dpt_name" class="form-control" placeholder="Department Name" autofocus required>
                            </div>
                            <button class="btn btn-success btn-block mt-1">Add Department</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
