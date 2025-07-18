<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
</head>

<body>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-2">List of contacts</h1>

        <form action="/contacts" class="flex" method="GET">
            <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write contact" required />
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ml-4">Search</button>
        </form>

        <a href="/contacts/create">Create contact</a>

        <ul class="list-disc list-inside">
            <?php foreach ($contacts["data"] as $contact): ?>            
                <li>
                    <a href="/contacts/<?= $contact["id"] ?>"> <?= $contact["name"] ?> </a>
                </li>

            <?php endforeach ?>
        </ul>

        <!-- pagination -->        
        <?php 
            $paginate = "contacts";
            require_once("../resources/views/assets/pagination.php");
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>

</html>