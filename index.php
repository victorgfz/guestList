    <?php
    include('connection.php');
    $query_code = "SELECT * from `guest_list`";
    $optionsRelation = ['all', 'family', 'friend', 'other'];
    $optionsConfirmation = ['all', 'confirmed', 'unconfirmed', 'no answer yet'];

    if (isset($_GET['filterRelation'])) {

        $filterRelation = $_GET['filterRelation'];
        $filterConfirmation = $_GET['filterConfirmation'];

        array_unshift($optionsRelation, $filterRelation);
        $optionsRelation = array_unique($optionsRelation);

        array_unshift($optionsConfirmation, $filterConfirmation);
        $optionsConfirmation = array_unique($optionsConfirmation);
        if ($filterRelation != 'all' && $filterConfirmation != 'all') {
            $query_code = "SELECT * FROM `guest_list` WHERE `relation` LIKE '$filterRelation' AND `confirmation` LIKE '$filterConfirmation'";
        } else if ($filterRelation != 'all') {
            $query_code = "SELECT * FROM `guest_list` WHERE `relation` LIKE '$filterRelation'";
        } else if ($filterConfirmation != 'all') {
            $query_code = "SELECT * FROM `guest_list` WHERE `confirmation` LIKE '$filterConfirmation'";
        }
    }

    if (isset($_GET['search'])) {
        $search = $mysqli->real_escape_string($_GET['search']);

        if (strlen($search) > 0) {
            $query_code = "SELECT * FROM `guest_list` WHERE `name` LIKE '%$search%'";
        }
    }


    $query = $mysqli->query($query_code) or die($mysqli->error);
    $num_guests = $query->num_rows;
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
        <title>Guests Organizer | Guests</title>
    </head>

    <body>
        <main style="background-color: red;" class="w-full flex flex-col justify-center items-center min-h-screen p-2 bg-gradient-to-r from-violet-600 to-indigo-600">
            <div class="container-lg bg-[#eee] rounded-xl mx-auto p-5 shadow-lg max-w-[480px] w-full mb-5">

                <h1 class="text-[2rem] text-center font-bold ">Check out your list</h1>
                <form class="w-full p-5 rounded-xl relative" action="" method="get">
                    <input value="<?php if (isset($search)) echo $search ?>" class="rounded-full py-2 px-5 w-full focus:outline-none" type="text" placeholder="Search for a guest" name="search">
                    <button type="submit" class="rounded-full p-2 bg-green-500 hover:bg-green-400 transition duration-300 text-white absolute right-5 bottom-5" type="submit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>
                <form class="flex gap-4 items-center w-full bg-[#e0e0e0] p-5 rounded-xl mb-5" action="" method="get">

                    <div class="flex flex-col flex-1">
                        <label class="font-bold" for="filterRelation">Relation</label>
                        <select class="outline-none rounded-xl px-2" name="filterRelation" id="filterRelation">
                            <?php foreach ($optionsRelation as $item) { ?>
                                <option value="<?php echo $item ?>"><?php echo ucfirst($item) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="flex flex-col flex-1">
                        <label class="font-bold" for="filterConfirmation">Confirmation</label>
                        <select class="outline-none rounded-xl px-2" name="filterConfirmation" id="filterConfirmation">
                            <<?php foreach ($optionsConfirmation as $item) { ?> <option value="<?php echo $item ?>"><?php echo ucfirst($item) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <button class=" rounded-full py-2 px-5 bg-green-500 hover:bg-green-400 transition duration-300 text-white" type="submit">Apply</button>
                </form>
                <a class="underline text-center block mx-5 text-black py-2 px-5 mb-3 rounded-full hover:bg-green-400 transition duration-300" href="add.php">Add a new guest</a>

                <?php if ($num_guests == 0) { ?>
                    <p class="text-center text-indigo-500 py-2 mx-5 bg-white rounded-full">No guests added yet.</p>
                <?php } else { ?>
                    <div class="bg-transparent px-5 py-2 w-full flex flex-col gap-1 items-start justify-center">
                        <div class="text-white text-left flex gap-1 w-full font-bold">
                            <p class="bg-indigo-500 py-2 pl-4 w-12 rounded-l-full">ID</p>
                            <p class="bg-indigo-500 flex-1 p-2">Name</p>
                            <p class="bg-indigo-500 flex-1  p-2 rounded-r-full">Relation</p>
                        </div>
                        <?php
                        while ($guest = $query->fetch_assoc()) {
                            $bgColor = 'bg-[#ddd]';
                            if ($guest['confirmation'] == 'confirmed') $bgColor = 'bg-green-200';
                            else if ($guest['confirmation'] == 'unconfirmed') $bgColor = 'bg-red-200';
                        ?>
                            <div class="text-left flex gap-1 w-full">
                                <p class="<?php echo $bgColor; ?> py-2 pl-4 w-12 rounded-l-full"><?php echo $guest['id'] ?></p>
                                <p class="<?php echo $bgColor; ?> flex-1 p-2"><?php echo $guest['name'] ?></p>
                                <div class="<?php echo $bgColor; ?> flex-1 p-2 rounded-r-full flex items-center relative capitalize">
                                    <p><?php echo $guest['relation'] ?></p>

                                    <a class="text-indigo-400 hover:bg-indigo-200 transition duration-300 p-2 rounded-l-full pointer absolute right-9" href="edit.php/?id=<?php echo $guest['id'] ?>"><svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg></a>
                                    <a class="text-red-500 hover:bg-red-300 transition duration-300 p-2 rounded-r-full pointer absolute right-0" href="delete.php/?id=<?php echo $guest['id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        <?php } ?>
                    </div>
                <?php
                } ?>
            </div>

        </main>




    </body>

    </html>