<?php
$host = 'localhost'; //Database host
$user = ''; //User
$pass = ''; //Password
$dbname = ''; //Database name
$table_name = 'revo_site_tmplvar_contentvalues'; //Table name
$tmplvarid = ''; // Required value for tmplvarid
$folder_name = 'images'; //FoНастрlder with images


$connect = mysqli_connect($host, $user, $pass);

//Get files list
$files_list = scandir($folder_name);
unset($files_list[0]);
unset($files_list[1]);
$files_list_accoc = array_flip($files_list);
mysqli_set_charset($connect, "utf8");
echo "<p>Files list:</p>";
$i = 1;
foreach($files_list as $value)
	{
	echo $i . ". " . $value . "<br>";
//Searching for files in database
	$q = "SELECT * FROM " . $dbname . "." . $table_name . " WHERE tmplvarid=" . $tmplvarid . " AND value like '%" .$value. "%'";
	$result = mysqli_query($connect, $q);
	$rows = mysqli_num_rows($result);
//Remove from list if exist
	if ($rows == 1)
		{
		unset($files_list_accoc[$value]);
		}
	$i++;
	}
mysqli_close($connect);
$files_list_trash = array_flip($files_list_accoc);
echo "<hr><p>Useless files:</p>";
$ii = 1;
//Removing of useless files
foreach($files_list_trash as $value)
	{
	$command = "rm -rf " . $folder_name . "/" . $value;
	echo $ii .". '" .$command. "'<br>"; 
	//Test it, before uncomment next line
	exec($command);
	$ii ++ ;
	}
?>
