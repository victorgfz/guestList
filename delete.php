<?php
include('connection.php');

$resultado = false;



//if (isset($_GET['id'])) {
$id = intval($_GET['id']);

$select_code = "SELECT * from `guest_list` WHERE `id` = '$id'";
$select_query = $mysqli->query($select_code) or die($mysqli->error);
$guest = $select_query->fetch_assoc();

if (isset($_POST['exclude'])) {
    $delete_code = "DELETE FROM `guest_list` WHERE `id` = '$id'";
    $delete_query = $mysqli->query($delete_code) or die($mysqli->error);
    if ($delete_query) {
        $resultado = true;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                fontFamily: {
                    sans: 'Manrope'
                }
            }
        }
    </script>
    <title>Guests Organizer | Delete guest</title>
</head>

<body>

    <main style="background-color: red;" class="w-full flex flex-col justify-center items-center min-h-screen p-2 bg-gradient-to-r from-violet-600 to-indigo-600">
        <div class="container-lg bg-[#eee] rounded-xl mx-auto p-5 shadow-lg max-w-[480px] w-full mb-5">
            <?php if ($resultado) { ?>
                <h1 class="text-[1.5rem] text-center font-bold"><span class="text-indigo-400"><?php echo $guest['name'] ?></span> was successful exclude!</h1>
                <a class="underline text-center block text-black py-2 px-5 mx-5 rounded-full hover:bg-indigo-500 transition duration-300" href="http://localhost/vscode/guestlist/index.php">Go back to list</a>
            <?php } else { ?>
                <h1 class="text-[1.5rem] text-center font-bold">Are you sure you want to delete <span class="text-indigo-400"><?php echo $guest['name'] ?></span> from the list?</h1>
                <form class="flex justify-center items-center w-full p-5 bg-[#eee] rounded-xl" action="" method="post">
                    <button name="exclude" value="1" class="text-center text-white font-bold bg-red-400 hover:bg-red-300 transition duration-300 flex-1 py-2 rounded-l-full" type="submit">Yes, do it</button>
                    <a class="text-center font-bold bg-white hover:bg-[#e0e0e0] transition duration-300 border-[1px] border-[#e0e0e0] flex-1 py-2 rounded-r-full" href="http://localhost/vscode/guestlist/index.php">No, get back to list</a>
                </form>
            <?php } ?>



        </div>
        <!--  -->
    </main>


</body>

</html>