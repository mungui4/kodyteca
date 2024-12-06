<?php
require_once('Book.php');
require_once('Session.php');


class Library extends Session
{ //Hereda de session para manejar el almacenamiento en la session
    private $books = [];

    public function __construct()
    {
        parent::__construct();
        $this->books = $this->loadSession('books');

        if (empty($this->books)) {
            $this->initializeDefaultBooks();
        }
    }
    //Agrega un libro nuevo, esta funcion en su parametro author recibe un objeto de tipo class Author
    public function addBook($title, $author, $category)
    {
        $id = count($this->books) + 1;
        $author = new Author($author);
        $book = new Book($id, $title, $author, $category);
        $this->books[] = $book;
        $this->updateBooks();
        header('Location: /kodyteca2/');
    }

    //Busca un libro por su id
    public function getBookById($id, $books)
    {
        foreach ($books as $book) {
            if ($book->getId() == $id) {
                return $book;
            }
        }
    }
    //Borra un libro por id
    public function deleteBook($id, $books)
    {
        foreach ($books as $key => $book) {
            if ($book->getId() == $id) {
                unset($this->books[$key]);
                $this->updateBooks();
                header('Location: /kodyteca2/');
            }
        }
    }
    //Actualiza un libro deacuerdo a su id
    public function editBook($id, $books, $postTitle, $postAuthor, $postCategory)
    {
        foreach ($books as $book) {
            if ($book->getId() == $id) {
                $book->setTitle($postTitle);
                $book->setAuthor($postAuthor);
                $book->setCategory($postCategory);
                header('Location: /kodyteca2/');
            }
        }
    }
    //Establece el estado de un libro para mostrar si está disponible o prestado
    public function borrowBook($id, $books)
    {
        foreach ($books as $book) {
            if ($book->getId() == $id) {
                $book->setStatus();
                $this->updateBooks();
                header('Location: /kodyteca2/');
            }
        }
    }

    //Relaiza la busqueda ya sea por Autor, categoria o titulo
    public function searchBook($query)
    {
        $results = [];

        foreach ($this->books as $book) {
            $author = (string)$book->getAuthor();
            if (stripos($book->getTitle(), $query) !== false || stripos($author, $query) !== false || stripos($book->getCategory(), $query) !== false) {
                $results[] = $book;
            }
        }

        return $results;
    }

    //Obtiene todos los libros de la biblioteca
    public function getBooks()
    {
        return  $this->books;
    }

    //Actualiza los datos en la session
    private function updateBooks()
    {
        $this->saveSession('books', $this->books);
    }

    //Función para establecer un prellenado
    private function initializeDefaultBooks()
    {
        $this->books = [
            new Book(1, '1984', new Author('George Orwell'), 'Ficción', true),
            new Book(2, 'Matar a un ruiseñor', new Author('Harper Lee'), 'Clásico', true),
            new Book(3, 'El gran Gatsby', new Author('F. Scott Fitzgerald'), 'Clásico', false),
            new Book(4, 'Moby Dick', new Author('Herman Melville'), 'Ficción', true),
            new Book(5, 'Orgullo y prejuicio', new Author('Jane Austen'), 'Clásico', false),
            new Book(6, 'Guerra y paz', new Author('León Tolstói'), 'Ficción', true),
            new Book(7, 'Ulises', new Author('James Joyce'), 'Clásico', false),
            new Book(8, 'La Odisea', new Author('Homero'), 'Ficción', true),
            new Book(9, 'Crimen y castigo', new Author('Fiódor Dostoyevski'), 'Clásico', false),
            new Book(10, 'Un mundo feliz', new Author('Aldous Huxley'), 'Ciencia', true),
            new Book(11, 'Jane Eyre', new Author('Charlotte Brontë'), 'Clásico', true),
            new Book(12, 'Cumbres borrascosas', new Author('Emily Brontë'), 'Clásico', false),
            new Book(13, 'El guardián entre el centeno', new Author('J.D. Salinger'), 'Clásico', true),
            new Book(14, 'El señor de los anillos', new Author('J.R.R. Tolkien'), 'Fantasía', true),
            new Book(15, 'El hobbit', new Author('J.R.R. Tolkien'), 'Fantasía', false),
            new Book(16, 'Harry Potter y la piedra filosofal', new Author('J.K. Rowling'), 'Fantasía', true),
            new Book(17, 'Harry Potter y la cámara secreta', new Author('J.K. Rowling'), 'Fantasía', false),
            new Book(18, 'Rebelión en la granja', new Author('George Orwell'), 'Ficción', true),
            new Book(19, 'El alquimista', new Author('Paulo Coelho'), 'Ficción', true),
            new Book(20, 'Don Quijote de la Mancha', new Author('Miguel de Cervantes'), 'Clásico', false),
            new Book(21, 'La Divina Comedia', new Author('Dante Alighieri'), 'Clásico', true),
            new Book(22, 'Frankenstein', new Author('Mary Shelley'), 'Misterio', false),
            new Book(23, 'Drácula', new Author('Bram Stoker'), 'Misterio', true),
            new Book(24, 'Los miserables', new Author('Víctor Hugo'), 'Clásico', true),
            new Book(25, 'Los tres mosqueteros', new Author('Alejandro Dumas'), 'Ficción', false),
            new Book(26, 'Historia de dos ciudades', new Author('Charles Dickens'), 'Clásico', true),
            new Book(27, 'Grandes esperanzas', new Author('Charles Dickens'), 'Clásico', true),
            new Book(28, 'Oliver Twist', new Author('Charles Dickens'), 'Clásico', false),
            new Book(29, 'El principito', new Author('Antoine de Saint-Exupéry'), 'Ficción', true),
            new Book(30, 'Fahrenheit 451', new Author('Ray Bradbury'), 'Ciencia', false),
            new Book(31, 'Las uvas de la ira', new Author('John Steinbeck'), 'Clásico', true),
            new Book(32, 'De ratones y hombres', new Author('John Steinbeck'), 'Clásico', true),
            new Book(33, 'Al este del Edén', new Author('John Steinbeck'), 'Clásico', false),
            new Book(34, 'Cien años de soledad', new Author('Gabriel García Márquez'), 'Ficción', true),
            new Book(35, 'El amor en los tiempos del cólera', new Author('Gabriel García Márquez'), 'Ficción', false),
            new Book(36, 'La carretera', new Author('Cormac McCarthy'), 'Misterio', true),
            new Book(37, 'El viejo y el mar', new Author('Ernest Hemingway'), 'Clásico', false),
            new Book(38, 'Adiós a las armas', new Author('Ernest Hemingway'), 'Clásico', true),
            new Book(39, 'Por quién doblan las campanas', new Author('Ernest Hemingway'), 'Clásico', true),
            new Book(40, 'Fiesta', new Author('Ernest Hemingway'), 'Clásico', false),
            new Book(41, 'La metamorfosis', new Author('Franz Kafka'), 'Ficción', true),
            new Book(42, 'El proceso', new Author('Franz Kafka'), 'Misterio', false),
            new Book(43, 'El castillo', new Author('Franz Kafka'), 'Misterio', true),
            new Book(44, 'El extranjero', new Author('Albert Camus'), 'Ficción', false),
            new Book(45, 'La peste', new Author('Albert Camus'), 'Ciencia', true),
            new Book(46, 'El mito de Sísifo', new Author('Albert Camus'), 'Ficción', true),
            new Book(47, 'Meditaciones', new Author('Marco Aurelio'), 'Biografía', false),
            new Book(48, 'El arte de la guerra', new Author('Sun Tzu'), 'Ciencia', true),
            new Book(49, 'El príncipe', new Author('Nicolás Maquiavelo'), 'Biografía', true),
            new Book(50, 'La riqueza de las naciones', new Author('Adam Smith'), 'Biografía', false),
        ];
    }
}
