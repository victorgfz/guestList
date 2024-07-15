<?php
include('connection.php');
$errorName = false;
$errorRelation = false;
$resultado = false;
if (count($_POST) > 0) {
    if (strlen($_POST['name']) < 3) {
        $errorName = "Name must contain more than 3 letters!";
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['relation'])) {
        $errorRelation = "You must select the relation!";
    } else {
        $relation = $_POST['relation'];
    }

    if (!$errorName && !$errorRelation) {
        $query_code = "INSERT INTO `guest_list` (`id`, `name`, `relation`, `confirmation`, `date`) VALUES (NULL, '$name', '$relation', 'no answer yet', NOW())";
        $query = $mysqli->query($query_code) or die($mysqli->error);
        if ($query) {
            $resultado = "<span class=\"font-bold\">$name</span> was added to the list!";
            unset($_POST);
        } else {
            $resultado = "Something went wrong...";
        }
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
    <title>Guests Organizer | Add a new guest</title>
</head>

<body>

    <main style="background-color: red;" class="w-full flex flex-col justify-center items-center min-h-screen p-2 bg-gradient-to-r from-violet-600 to-indigo-600">
        <div class="container-lg bg-[#eee] rounded-xl mx-auto p-5 shadow-lg max-w-[480px] w-full mb-5">

            <h1 class="text-[2rem] text-center font-bold mb-5">It's party time</h1>

            <form class="flex flex-col justify-center gap-4 items-center mb-5 w-full p-5 bg-[#e0e0e0] rounded-xl" action="" method="post">
                <label class="text-[1.25rem] text-center" for="name">Add a new guest</label>
                <input class="rounded-full py-2 px-5 w-full focus:outline-none" placeholder="Type the name of the guest" type="text" name="name" value="<?php if ($errorRelation && !$errorName) echo $name ?>">
                <?php if ($errorName) ?> <p class="text-red-500 text-[1rem] text-center"> <?php echo $errorName; ?></p>
                <h2 class="text-[1.25rem] text-center">What's the relation?</h2>
                <div class="flex justify-center items-center gap-5 p-2 bg-white w-full rounded-full">
                    <div>
                        <input type="radio" name="relation" id="family" value="family" <?php if ($errorName && !$errorRelation && $relation == 'family') echo 'checked' ?>>
                        <label for="family">Family</label>

                    </div>
                    <div>
                        <input type="radio" name="relation" id="friend" value="friend" <?php if ($errorName && !$errorRelation && $relation == 'friend') echo 'checked' ?>>
                        <label for="friend">Friend</label>

                    </div>
                    <div>
                        <input type="radio" name="relation" id="other" value="other" <?php if ($errorName && !$errorRelation && $relation == 'other') echo 'checked' ?>>
                        <label for="other">Other</label>

                    </div>
                </div>
                <?php if ($errorRelation) ?> <p class="text-red-500 text-[1rem] text-center"> <?php echo $errorRelation; ?></p>

                <button class=" rounded-full py-2 w-full bg-green-500 hover:bg-green-400 transition duration-300 text-white" type="submit">Confirm</button>
            </form>
            <?php if ($resultado) { ?>
                <p class="text-violet-600 p-2 rounded-full text-center"><?php echo $resultado; ?></p>
            <?php } ?>

        </div>
        <a class="underline text-center mx-auto text-black py-2 px-5 rounded-full hover:bg-indigo-500 transition duration-300" href="index.php">Go back to list</a>
    </main>


</body>

</html>