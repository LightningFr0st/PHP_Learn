<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form method=post>
    <label for="delivery">Delivery date:</label>
    <input type="text" id="delivery" name="delivery" value="<?php if(isset($_POST['delivery'])) echo htmlspecialchars($_POST['delivery']); ?>">
    <button type="submit">Submit</button>
    <div style="margin-top: 50px">
        <?php include 'delivery.php' ?>
    </div>
</form>

<form style="margin-top: 200px" method=post>
    <label for="set1">Set of numbers:</label>
    <input type="text" id="set1" required = "" name="set1" value="<?php if(isset($_POST['set1'])) echo htmlspecialchars($_POST['set1']); ?>">
    <input type="text" id="set2" required = "" name="set2" value="<?php if(isset($_POST['set2'])) echo htmlspecialchars($_POST['set2']); ?>">
    <button type="submit">Submit</button>
    <div style="margin-top: 50px">
        <?php include 'task_03.php' ?>
    </div>
</form>


</body>
</html>