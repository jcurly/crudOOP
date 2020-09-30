<?php
require_once 'config.php';
require_once 'contact.php';
try {
    if (isset($_POST['save'])) {

        $contact = new Contact($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['note']);

        if (isset($_POST['id'])) {
            $contact->setId($_POST['id']);
        }

        $contact->saveUpdate($PDO);
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $contact = Contact::getRecord($PDO, $id);
        $contact->delete($PDO);
    }

    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>


    <form method="post" action="index.php">

        <?php

        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $contact = Contact::getRecord($PDO, $id);
            $contact->saveUpdate($PDO);

            echo '<h2>Update Contact</h2>';
            echo '<label for="name">Name:</label>';
            echo '<input id="name" type="text" name="name" value="' . $contact->getName() . '">';
            echo '<label for="phone">Phone:</label>';
            echo '<input id="phone" type="text" name="phone" value="' . $contact->getPhone() . '">';
            echo '<label for="email">Email:</label>';
            echo '<input id="email" type="text" name="email" value="' . $contact->getEmail() . '">';
            echo '<label for="note">Note:</label>';
            echo '<input id="note" type="text" name="note" value="' . $contact->getNote() . '">';
            echo '<input id="id" type="hidden" name="id", value="' . $contact->getId() . '">';
            echo '<input type="submit" name="save" value="Update">';

        } else {

            echo '<h2>Create Contact</h2>';
            echo '<label for="name"> Name: </label>';
            echo '<input id="name" type="text" name="name">';
            echo '<label for="phone"> Phone: </label>';
            echo '<input id="phone" type="text" name="phone">';
            echo '<label for="email"> Email: </label>';
            echo '<input id="email" type="text" name="email">';
            echo '<label for="note"> Note: </label>';
            echo '<input id="note" type="text" name="note">';
            echo '<input type="submit" name="save" value="Save">';

        }


        ?>

    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Note</th>
            <th colspan="2">Action</th>
        </tr>

        <?php
        $contacts = Contact::loadAll($PDO);

        foreach ($contacts as $contact) {
            echo "<tr>";
            echo "<td>" . $contact->getName() . "</td>";
            echo "<td>" . $contact->getPhone() . "</td>";
            echo "<td>" . $contact->getEmail() . "</td>";
            echo "<td>" . $contact->getNote() . "</td>";
            echo "<td><a href='?edit=" . $contact->getId() . "'>Edit</a></td>";
            echo "<td><a href='?delete=" . $contact->getId() . "'>Delete</a></td>";
            echo "</tr>";
        }

        ?>


    </body>
    </html>

    <?php

} catch (Exception $exception) {
    echo $exception;
}
?>