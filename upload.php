
<?php
error_reporting(0);
require_once './parser/excel_reader.php';
$tar_dir="uploads/";
$err=$_FILES['xls']['error'];
if($err==UPLOAD_ERR_OK)
{	
$tar_name=$tar_dir.basename($_FILES['xls']['name']);
$tmp_name=$_FILES['xls']['tmp_name'];
    if(move_uploaded_file($tmp_name,$tar_name))
    {
     $data = new Spreadsheet_Excel_Reader($tar_name);
	 $row=$data->rowcount();
	 $col=$data->colcount();

	 $error=0;
	 $errstr="";
	 $check=array();
	for($x=0;$x<=$col;$x++)
	{
		$check[$x]=0;
	}
$c=1;
$x=1;
$k=0;
	while($c<=$col)
	{
		$r=2;
		while($r<=$row)
		{
			if($data->val($r,$c)!=NULL)
			{
				//print $data->val($r,$c)."<br/>";
			}
			else
			{
				if($k>0)
				{
					$errstr.=chr($k+64).chr($x+64).$r.",";
				}
				else
				{
					$errstr.=chr($c+64).$r.",";
				}
						
			$error++;
			if($check[$c]!=1)
			{
				$check[$c]=1;
				
			}
			
			}
			$r++;
		}
		$c++;
		$x++;
		if($x>26)
		{
		  $x=1;
		   $k++;

		}
	}
$msg="";
	for($x=0;$x<=$col;$x++)
	{	
		if($check[$x]==1)
		{
			$msg.=$data->val(1,$x)." can’t be blank,";
		}
	}
	if($error==0)
	{
		$msg="ALL OK, ";
		$msg.=--$row." record analyzed";
		echo $msg."<br/>";
		echo "Errors:-None";
	}
	else
	{
		$msg1.=$error." ERROR found. ";
		$msg=$msg1.$msg;
		$msg.=--$row." records analyzed";
		echo $msg."<br/>";
		echo "Errors:-".$errstr;
	} 
			
    }
    else {
      $mesg="Your file is not uploaded";
      echo $msg;
    }
  }
  else {
    switch ($err) {
            case UPLOAD_ERR_INI_SIZE:
                $msg = "The uploaded file exceeds the upload_max_filesize directive in php.ini"."<br/>";
				echo $message;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $msg = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"."<br/>";
                echo $message;
				break;
            case UPLOAD_ERR_PARTIAL:
                $msg = "The uploaded file was only partially uploaded"."<br/>";
				echo $message;
                break;
            case UPLOAD_ERR_NO_FILE:
                $msg = "No file was uploaded"."<br/>";
				echo $message;
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $msg = "Missing a temporary folder"."<br/>";
				echo $message;
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $msg = "Failed to write file to disk"."<br/>";
				echo $message;
                break;
            case UPLOAD_ERR_EXTENSION:
                $msg = "File upload stopped by extension"."<br/>";
				echo $message;
                break;

            default:
                $msg = "Unknown upload error"."<br/>";
				echo $message;
                break;
  }
}
?>