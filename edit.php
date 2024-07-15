<?php
include('connection.php');

$resultado = false;



//if (isset($_GET['id'])) {
$id = intval($_GET['id']);

$select_code = "SELECT * from `guest_list` WHERE `id` = '$id'";
$select_query = $mysqli->query($select_code) or die($mysqli->error);
$guest = $select_query->fetch_assoc();
if (count($_POST) > 0) {
    $name = $_POST['name'];
    $relation = $_POST['relation'];
    $confirmation = $_POST['confirmation'];
    $update_code = "UPDATE `guest_list` SET `name` = '$name', `relation` = '$relation', `confirmation` = '$confirmation' WHERE `id` = '$id'";
    $update_query = $mysqli->query($update_code) or die($mysqli->error);
    if ($update_query) {
        $resultado = "<span class=\"font-bold\">$name</span> was updated at the list!";
        unset($_POST);
    }
}
//}


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
    <title>Guests Organizer | Edit guest</title>
</head>

<body>

    <main style="background-color: red;" class="w-full flex flex-col justify-center items-center min-h-screen p-2 bg-gradient-to-r from-violet-600 to-indigo-600">
        <div class="container-lg bg-[#eee] rounded-xl mx-auto p-5 shadow-lg max-w-[480px] w-full mb-5">

            <h1 class="text-[2rem] text-center font-bold mb-5">It's party time</h1>

            <form class="flex flex-col justify-center gap-4 items-center mb-5 w-full p-5 bg-[#e0e0e0] rounded-xl" action="" method="post">
                <label class="text-[1.25rem] text-center" for="name">Name of the guest</label>
                <input class="rounded-full py-2 px-5 w-full focus:outline-none" placeholder="Type the name of the guest" type="text" name="name" value="<?php echo $resultado ? $name : $guest['name'] ?>">

                <h2 class="text-[1.25rem] text-center">What's the relation?</h2>
                <div class="flex justify-center items-center gap-5 p-2 bg-white w-full rounded-full">
                    <div>
                        <input type="radio" name="relation" id="family" value="family" <?php if ($resultado) {
                                                                                            if ($relation == 'family') echo 'checked';
                                                                                        } else {
                                                                                            if ($guest['relation'] == 'family') echo 'checked';
                                                                                        } ?>>
                        <label for="family">Family</label>

                    </div>

                    <div>
                        <input type="radio" name="relation" id="friend" value="friend" <?php if ($resultado) {
                                                                                            if ($relation == 'friend') echo 'checked';
                                                                                        } else {
                                                                                            if ($guest['relation'] == 'friend') echo 'checked';
                                                                                        } ?>>
                        <label for="friend">Friend</label>

                    </div>

                    <div>
                        <input type="radio" name="relation" id="other" value="other" <?php if ($resultado) {
                                                                                            if ($relation == 'other') echo 'checked';
                                                                                        } else {
                                                                                            if ($guest['relation'] == 'other') echo 'checked';
                                                                                        } ?>>
                        <label for="other">Other</label>

                    </div>

                </div>

                <h2 class="text-[1.25rem] text-center">Already answered?</h2>
                <div class="flex justify-center items-center gap-5 p-2 bg-white w-full rounded-full mb-5">
                    <div>
                        <input type="radio" name="confirmation" id="confirmed" value="confirmed" <?php if ($resultado) {
                                                                                                        if ($confirmation == 'confirmed') echo 'checked';
                                                                                                    } else {
                                                                                                        if ($guest['confirmation'] == 'confirmed') echo 'checked';
                                                                                                    } ?>>
                        <label for="confirmed">Confirm</label>

                    </div>
                    <div>
                        <input type="radio" name="confirmation" id="unconfirmed" value="unconfirmed" <?php if ($resultado) {
                                                                                                            if ($confirmation == 'unconfirmed') echo 'checked';
                                                                                                        } else {
                                                                                                            if ($guest['confirmation'] == 'unconfirmed') echo 'checked';
                                                                                                        } ?>>
                        <label for="unconfirmed">Unconfirm</label>

                    </div>
                    <div>
                        <input type="radio" name="confirmation" id="no answer yet" value="no answer yet" <?php if ($resultado) {
                                                                                                                if ($confirmation == 'no answer yet') echo 'checked';
                                                                                                            } else {
                                                                                                                if ($guest['confirmation'] == 'no answer yet') echo 'checked';
                                                                                                            } ?>>
                        <label for="no answer yet">No Answer Yet</label>

                    </div>
                </div>
                <button class=" rounded-full py-2 w-full bg-green-500 hover:bg-green-400 transition duration-300 text-white" type="submit">Save</button>
            </form>

            <?php if ($resultado) { ?>
                <p class="text-violet-600 p-2 rounded-full text-center"><?php echo $resultado; ?></p>
            <?php } ?>

        </div>
        <a class="underline text-center mx-auto text-black py-2 px-5 rounded-full hover:bg-indigo-500 transition duration-300" href="http://localhost/vscode/guestlist/index.php">Go back to list</a>
    </main>


</body>

</html>