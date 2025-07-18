<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit contact</title>
</head>
<body>
    <h1>Edit contact</h1>

    <form action="/contacts/<?=$contact["id"]?>" method="POST">
        <div>
            <label for="name">Name</label>
            <input value="<?= $contact["name"] ?>" type="text" name="name" id="name">
        </div>
        <div>
            <label for="email">Email</label>
            <input value="<?= $contact["email"] ?>" type="email" name="email" id="email">
        </div>
        <div>
            <label for="phone">Phone</label>
            <input value="<?= $contact["phone"] ?>" type="text" name="phone" id="phone">
        </div>
        
        <button type="submit"> Save </button>
    </form>
    
</body>
</html>