<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qualesce | Extractor</title>
    <link rel="icon" href="assets/img/qlogo.svg">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
 <section>
    <form action="execute.php" method="POST" enctype="multipart/form-data" class="extractorForm" >
        <!-- <label for="fileUpload" class="text1">Select a CSV file</label> -->
        <div>
            <label for="fileUpload" class="uploadbtn" id="files">Upload CSV</label>
        <input type="file" name="fileUpload" id="fileUpload" required>
        </div>
        
        <input type="submit" value="Download XML" class="downloadbtn">
    </form>
    <div class="poweredBy">
    <a href="https://www.qualesce.com/" id="poweredby_center" target="_blank">
        <img src="assets/img/qualesce footer.svg" alt="powered_by_qualesce">
    </a>
    </div>
    </section>
</body>
</html>