<?php
include './init.php';
$book = null;
// Create
function addBook($data)
{
    global $database;
    $title = trim($data["title"]) ?? null;
    $author = trim($data["author"]) ?? null;
    $publishedYear = trim($data["published_year"]) ?? null;

    if (empty($title) || $title === null)
        return "Title is Empty";
    if (empty($author) || $author === null)
        return "Author is Empty";
    $currentYear = date("Y");
    if (!is_numeric($publishedYear) || $publishedYear < 1500 || $publishedYear > $currentYear)
        return "Published Year is Invalid";

    if ($database->count("books", ["title" => $title]))
        return "This Book Added To Library";

    $result = $database->insert("books", ["title" => $title, "author" => $author, "published_year" => $publishedYear]);
    if ($result) {
        redirect();
        exit;
    }
    return "Failed to add book";
}

// Read
function showBooks()
{
    global $database;
    $books = $database->select("books", "*", [
        "ORDER" => [
            "id" => "DESC"
        ]
    ]);
    if (!isset($books) || empty($books) || $books === null)
        return "There Is not Any Book Please Add First";
    return $books;
}

// Update
function selectBook($id)
{
    global $database;
    if ($id === null || !is_numeric($id)) {
        return "Invalid ID";
    }
    $data = $database->get("books", "*", ["id" => $id]);
    if (!$data || empty($data)) {
        return "Book Not Found | Invalid ID";
    }
    return $data;
}


function updateBook($data)
{
    global $database;

    $id = $data["id"] ?? null;
    $title = trim($data["title"]) ?? null;
    $author = trim($data["author"]) ?? null;
    $publishedYear = trim($data["published_year"]) ?? null;

    if ($id === null || !is_numeric($id))
        return "Invalid Book ID";

    if (empty($title))
        return "Title is Empty";
    if (empty($author))
        return "Author is Empty";
    $currentYear = date("Y");
    if (!is_numeric($publishedYear) || $publishedYear < 1500 || $publishedYear > $currentYear)
        return "Published Year is Invalid";

    if (
        $database->has("books", [
            "title" => $title,
            "id[!]" => $id
        ])
    )
        return "This Book Added To Library";

    $result = $database->update("books", [
        "title" => $title,
        "author" => $author,
        "published_year" => $publishedYear
    ], ["id" => $id]);

    if ($result) {
        redirect();
        exit;
    }
    return "Failed to add book";

}


// Delete
function deleteBook($id)
{
    global $database;
    if ($id === null || empty($id) || !is_numeric($id) || $database->count("books", ["id" => $id]) === 0)
        return "Invalid ID";
    $result = $database->delete("books", ["id" => $id]);
    if (!$result) {
        return "Failed To Delete Book";
    }
    redirect();
}

$allBooks = showBooks();
if (isset($_POST["add"]) && $_SERVER["REQUEST_METHOD"] === "POST")
    addBook($_POST);
if (isset($_GET["delete"]) && is_numeric($_GET["delete"]))
    deleteBook($_GET["delete"]);
if (isset($_GET["edit"]) && is_numeric($_GET["edit"]))
    $book = selectBook($_GET["edit"]);
if (isset($_POST["update"]) && $_SERVER["REQUEST_METHOD"] === "POST")
    updateBook($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Library Management System TEST</title>
    <link rel="stylesheet" href="<?= siteUri("assets/css/style.css") ?>">
</head>

<body>

    <h1>Library Management System</h1>

    <h2>Add New Book</h2>
    <form action="index.php" method="POST">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <input type="number" name="published_year" placeholder="Published Year" required>
        <button type="submit" name="add">Add Book</button>
    </form>
    <?php if (isset($book) && $book !== null): ?>
        <h2>Edit Book</h2>
        <form action="index.php" method="POST">
            <input type="hidden" name="id" value="<?= $book["id"] ?>">
            <input type="text" name="title" value="<?= $book["title"] ?>" required>
            <input type="text" name="author" value="<?= $book["author"] ?>" required>
            <input type="number" name="published_year" value="<?= $book["published_year"] ?>" required>
            <button type="submit" name="update">Update Book</button>
        </form>
    <?php endif ?>
    <h2>Book List</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($allBooks as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book["title"]) ?></td>
                <td><?= htmlspecialchars($book["author"]) ?></td>
                <td><?= htmlspecialchars($book["published_year"]) ?></td>
                <td>
                    <a href="index.php?edit=<?= $book["id"] ?>">Edit</a>
                    <a onclick="return confirm('Are You Sure Wanna Delete This Book ??')"
                        href="index.php?delete=<?= $book["id"] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</body>

</html>