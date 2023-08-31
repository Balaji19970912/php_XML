<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qualesce | Extractor</title>
    <link rel="icon" href="assets/img/qlogo.svg">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <section>
            <form action="execute.php" method="POST" enctype="multipart/form-data" class="extractorForm" onsubmit="return validate();">
            <!-- <label for="fileUpload" class="text1">Select a CSV file</label> -->
            <div>
                <label for="fileUpload" class="uploadbtn" id="files">Upload CSV</label>
                <input type="file" name="fileUpload" id="fileUpload"><br />
            </div>
            <div class="changeContentsSpan"><span class="changeContents">File Not Uploaded !</span></div>
            <input type="submit" value="Download XML" class="downloadbtn">
        </form>
        <div class="poweredBy">
            <a href="https://www.qualesce.com/" id="poweredby_center" target="_blank">
                <img src="assets/img/qualesce footer.svg" alt="powered_by_qualesce">
            </a>
        </div>
    </section>
    <?php
        echo $_SESSION['notcsv'];
        if (isset($_SESSION['notcsv'])) {
            echo '<script>toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.error("File format is not in CSV!","CSV Format");</script>';
            unset($_SESSION['notcsv']);
        } else if (isset($_SESSION['warnCSV'])) {
            echo '<script>toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.warning("Uploaded CSV is not a valid format!","CSV Format");</script>';
            unset($_SESSION['warnCSV']);
        }
    ?>
</body>
<script>
    document.getElementById('fileUpload').onchange = function() {
        document.querySelector('.changeContents').innerText = 'File Uploaded !';
        document.querySelector('.changeContents').classList.add('successFile');
    };
    
    function validate() {
        if (document.getElementById('fileUpload').value == "") {
            // Display an info toast with no title
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.info('Not Uploaded!', "CSV File");
            return false;
        }
    }
</script>

</html>