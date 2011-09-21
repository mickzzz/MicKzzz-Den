<?php
if($_FILES["image"]["size"] < 20000000)
{

$name = $_FILES["image"]["name"];

	if ($_FILES["images"]["error"]>0)
	{
		echo "Return Code: ".$_FILES["images"]["error"]."<br/>";
	}
	else
	{
	move_uploaded_file($_FILES["image"]["tmp_name"], "images/temp/" . $_FILES["image"]["name"]);
	echo "Stored in: " . "images/temp/" . $_FILES["image"]["name"];
      	}

echo "<script type='text/javascript'>\n";
echo "var parDoc = window.parent.document;";
echo "parDoc.getElementById('picture_preview').src = 'images/temp/$name';";
echo "\n</script>";
}
?>
