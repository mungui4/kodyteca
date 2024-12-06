<?php
require('./Author.php'); //Clase para instancias los libros, define la estructura de las caracteristicas del mismo
class Book
{

    private $id; //Permite identificar de manera unica cada libro
    private $title; //Estable un titulo
    private $author; //En ella se determinan el autor del libro
    private $category; //Permite la creacion de una cattegoria
    private $status; //Se define inicialmente como verdadero lo que significa que el libro está disponible y falso para no disponible o prestado


    function __construct($id, $title, Author $author, $category, $status = true)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->category = $category;
        $this->status = $status;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus()
    {
        $this->status = !$this->status;

        return $this;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
}
