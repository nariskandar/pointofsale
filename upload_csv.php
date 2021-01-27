<table width="600">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
<td width="20%">Select file</td>
<td width="80%"><input type="file" name="file" id="file" /></td>
</tr>

<tr>
<td>Submit</td>
<td><input type="submit" name="submit" /></td>
</tr>

</form>
</table>



<?php
require "base_path.php";

if ( isset($_POST["submit"]) ) {

if ( isset($_FILES["file"])) {

         //if there was an error uploading the file
     if ($_FILES["file"]["error"] > 0) {
         echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

     }
     else 
          echo "Upload: " . $_FILES["file"]["name"] . "<br />";
          echo "Type: " . $_FILES["file"]["type"] . "<br />";
          echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
          echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

        //   if file already exists
        //   if (file_exists("report_daily/" . $_FILES["file"]["name"])) {
        //     echo $_FILES["file"]["name"] . " already exists. ";
        //   }
        //   else {
            
        
        //  $storagename = "uploaded_file.csv";
         move_uploaded_file($_FILES["file"]["tmp_name"], $pathUploadData . $_FILES["file"]["name"]);

         echo "Stored in: " . $pathUploadData . $_FILES["file"]["name"] . "<br />";
        //  }
    //  }
  } else {
          echo "No file selected <br />";
  }
}