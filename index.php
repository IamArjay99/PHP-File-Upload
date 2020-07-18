<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Upload File</title>
</head>
<body>
    <form action="process.php" method="post" enctype="multipart/form-data">
        <label for="">Single File</label><br>
        <input type="file" name="file1" id="file1"><br>
        <button type="submit" name="file1">Submit</button>
    </form>
    <br>
    <form action="process.php" method="post" enctype="multipart/form-data">
        <label for="">Multiple Files</label><br>
        <input type="file" name="file2[]" id="file2" multiple><br>
        <button type="submit" name="file2">Submit</button>
    </form>
</body>
</html>