<?php
require('./Library.php');

$library = new Library(); //Crea una instancia de Library la cual controla creacion, edicion, eliminación etc.
$getForm = isset($_POST['getForm']);
$addBook = isset($_POST['addBook']);

//Crean un libro si los parámetros están presentes deacuerdo al form
if (isset($_POST['createBook'])) {
  if (!empty($_POST['bookTitle']) && !empty($_POST['bookAuthor']) && !empty($_POST['bookCategory'])) {
    $title = $_POST['bookTitle'];
    $author = $_POST['bookAuthor'];
    $category = $_POST['bookCategory'];

    $library->addBook($title, $author, $category);
  }
}

$books = $library->getBooks(); //Obtiene los libros

//Llamada a la función que Elimina un libro deacuerdo a su Id
if (isset($_GET['delete'])) {
  $library->deleteBook($_GET['delete'], $books);
}

//Llamada a la función que Cambia el valor de verdadero a falso para comprobar si el libro está o no disponible
if (isset($_GET['borrow'])) {
  $library->borrowBook($_GET['borrow'], $books);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="styles/index.css">
  <title>Koditeca</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Koditeca</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <form method="POST" action="">
              <button type="submit" name="getForm" class="btn btn-secondary bg-success bg-gradient">Agregar Libro</button>
            </form>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <main class="container mt-5 mb-5">






    <div class="row g-3 align-items-center">
      <div class="col-auto ms-5">
        <form method="GET" action="">
          <input type="text" name="search" class="form-control" placeholder="Buscar libro, autor o categoría" required>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
      </div>
    </div>
    <!--  Form para ingresar los par[ametros abuscar -->

    <?php

    //Muestra los resultados de la busqueda
    if (isset($_GET['search'])) {
      $query = $_GET['search'];
      $results = $library->searchBook($query);

      echo "<h3>Resultados de búsqueda para: " . htmlspecialchars($query) . "</h3>"; ?>
      <div class="container mt-4 ">
        <div class="d-flex flex-wrap gap-3 justify-content-center ">
          <?php foreach ($results as $book) { ?>
            <div class="card" style="width: 18rem;">
              <h5 class="card-header"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                </svg> <?php echo $book->getCategory() ?></h5>
              <div class="card-body">
                <h5 class="card-title">

                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                  </svg> <?php echo $book->getTitle() ?>
                </h5>
                <h6 class="card-subtitle mb-2 text-body-secondary mt-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                  </svg> <?php echo $book->getAuthor() ?>
                </h6>
              </div>
              <div class="container"><a href='?delete=<?php echo $book->getId() ?>' class="card-link">Eliminar</a>
                <a href='?edit=<?php echo $book->getId() ?>' class="card-link">Editar Información</a>
              </div>
              <div class="card-header text-center"> <?php if ($book->getStatus() === true) { ?>
                  <a type="submit" href='?borrow=<?php echo $book->getId() ?>' name="getForm" class="btn btn-success mb-1 mt-2">Libro disponible (Prestar)</a>
                <?php } else { ?>
                  <a type="submit" href='?borrow=<?php echo $book->getId() ?>' name="getForm" class="btn btn-secondary mb-1 mt-2">Posees el libro <span>(Regresar este libro)</span></a> <?php } ?>
              </div>
            </div>
          <?php } ?>

        </div>
      </div>

    <?php
    }
    ?>

    <!-- Formulario Creación de Libro -->
    <?php
    if ($getForm) {
    ?>
      <form action="" method="POST" class="my-3">
        <input type="hidden" name="createBook" ;>
        <div class="mb-3 row">
          <label for="bookTitle" class="col-sm-2 col-form-label">Titulo del libro</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bookTitle">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="bookAuthor" class="col-sm-2 col-form-label">Autor</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bookAuthor">
          </div>
        </div>
        <div class="mb-3 row">


          <label for="bookCategory" class="col-sm-2 col-form-label">Categoria</label>
          <div class="col-sm-10">
            <select class="form-select" name="bookCategory">
              <option selected disabled>Selecciona una categoria</option>
              <option value="Ficción">Ficción</option>
              <option value="Clasico">Clasico</option>
              <option value="Ciencia">Ciencia</option>
              <option value="Biografia">Biografía</option>
              <option value="Fantasia">Fantasía</option>
              <option value="Misterio">Misterio</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
      </form>
    <?php }
    ?>


    <!--Edición de Libro -->
    <?php
    if (isset($_POST['updateBook'])) {
      $library->editBook($_POST['id'], $books, $_POST['bookTitle'], $_POST['bookAuthor'], $_POST['bookCategory']);
    }
    ?>

    <?php
    if (isset($_GET['edit'])) {
      $editBook = $library->getBookById($_GET['edit'], $books);

    ?>



      <!-- Form para la edici[on del libro -->
      <form action="" method="POST" class="my-3">
        <input type="hidden" name="updateBook">
        <input type="hidden" name="id" value='<?php echo $editBook->getId() ?>'>
        <div class="mb-3 row">
          <label for="bookTitle" class="col-sm-2 col-form-label">Libro</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bookTitle" value='<?php echo $editBook->getTitle() ?>'>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="bookAuthor" class="col-sm-2 col-form-label">Autor</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="bookAuthor" value='<?php echo $editBook->getAuthor() ?>'>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="bookCategory" class="col-sm-2 col-form-label">Categoria</label>
          <div class="col-sm-10">

            <select class="form-select" name="bookCategory">
              <option selected disabled><?php echo $editBook->getCategory() ?></option>
              <option value="Ficción">Ficción</option>
              <option value="Clásico">Clásico</option>
              <option value="Ciencia">Ciencia</option>
              <option value="Biografia">Biografía</option>
              <option value="Fantasia">Fantasía</option>
              <option value="Misterio">Misterio</option>
            </select>
          </div>
        </div>
        <button type="submit" name="addBook" class="btn btn-primary">Actualizar</button>
      </form>
    <?php }
    ?>


    <!-- Muestra los libros en el caso que no se esté realizando una búsqueda -->
    <div class="container mt-4 ">
      <div class="d-flex flex-wrap gap-3 justify-content-center ">
        <?php if (!isset($_GET['search'])) {
          foreach ($books as $book) { ?>
            <div class="card" style="width: 18rem">
              <h5 class="card-header"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                </svg> <?php echo $book->getCategory() ?></h5>
              <div class="card-body">
                <h5 class="card-title">

                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                  </svg> <?php echo $book->getTitle() ?>
                </h5>
                <h6 class="card-subtitle mb-2 text-body-secondary mt-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                  </svg> <?php echo $book->getAuthor() ?>

                </h6>

              </div>
              <div class="container"><a href='?delete=<?php echo $book->getId() ?>' class="card-link">Eliminar</a>
                <a href='?edit=<?php echo $book->getId() ?>' class="card-link">Editar Información</a>
              </div>
              <div class="card-header text-center"> <?php if ($book->getStatus() === true) { ?>
                  <a type="submit" href='?borrow=<?php echo $book->getId() ?>' name="getForm" class="btn btn-success mb-1 mt-2">Libro disponible (Prestar)</a>
                <?php } else { ?>
                  <a type="submit" href='?borrow=<?php echo $book->getId() ?>' name="getForm" class="btn btn-secondary mb-1 mt-2">Posees el libro <span>(Regresar este libro)</span></a> <?php } ?>
              </div>
            </div>
        <?php }
        } ?> <?php  ?>
      </div>
    </div>
  </main>


  <footer class="bg-dark text-white text-center py-1 mt-auto">
    <div class="container">
      <p>&copy; <?= date('Y'); ?> Kodyteca. Todos los derechos reservados.</p>
    </div>
  </footer>
</body>

</html>