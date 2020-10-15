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
        if (count($this->posts) > 20){
            array_shift($this->posts);
        }
    }

    public function printPosts()
    {
        for ($i = count($this->posts)-1; $i >= 0 ; $i--){
            echo '<h2>' . $this->posts[$i]->getTitle() . '</h2><br>
            <span>' . $this->posts[$i]->getAuthor() . ' ' . $this->posts[$i]->getDate() . '</span>
            <div class="content">' . $this->posts[$i]->getContent() . '</div><br>';
        }
    }
}