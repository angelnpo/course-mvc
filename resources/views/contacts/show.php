<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact detail</title>
</head>

<body>
    <h1>Contact detail</h1>
    <a href="/contacts">Back</a>
    <a href="/contacts/<?= $contact["id"]?>/edit">Edit</a>

    <p>Name: <?= $contact["name"] ?></p>
    <p>Email: <?= $contact["email"] ?></p>
    <p>Phone: <?= $contact["phone"] ?></p>

    <form action="/contacts/<?= $contact["id"]?>/delete" method="POST">
        <button>Delete</button>
    </form>
</body>

</html>