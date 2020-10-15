<?php
/* @var Post */

class PostLoader
{
    private array $posts = [];

    public function __construct()
    {

    }

    public function newPost(string $title, string $content, string $author)
    {
        array_push($this->posts, new Post($title, $content, $author));
    }

    public function printPosts()
    {
        for ($i = 0; $i < count($this->posts); $i++){
            echo $this->posts[$i]->getAuthor();
            echo $this->posts[$i]->getTitle();
            echo $this->posts[$i]->getContent();
            echo $this->posts[$i]->getDate();
        }
    }
}