<?php
/* @var Post[] */

class PostLoader
{
    private array $posts = [];

    public function __construct()
    {
        $data = file_get_contents('posts.json');
        $dataArray = json_decode($data, true);
        for ($i = 0; $i < count($dataArray); $i++){
            $post = new Post($dataArray[$i]['title'], $dataArray[$i]['content'], $dataArray[$i]['author']);
            array_push($this->posts, $post);
        }
        //$this->posts = $dataArray;
        //$this->posts = $dataArray;
    }

    public function newPost(string $title, string $content, string $author)
    {
        array_push($this->posts, new Post($title, $content, $author));
        if (count($this->posts) > 20) {
            array_shift($this->posts);
        }
        $data = file_get_contents('posts.json');
        $dataArray = json_decode($data, true);
        foreach ($dataArray as $key => $value) {
            $arr_index[] = $key;

        }
        foreach ($arr_index as $i) {
            unset($dataArray[$i]);
        }
        $newArray = [];
        for ($i = 0; $i < count($this->posts); $i++) {
            array_push($newArray, $this->posts[$i]->jsonSerialize());
        }
        $json = json_encode($newArray);
        file_put_contents('posts.json', $json);
    }

    public function printPosts()
    {
        $posts = $this->getPosts();
        for (end($posts); key($posts) !== null; prev($posts)) {
            $currentElement = current($posts);
            //$this->posts = array($this->posts, $currentElement);
            $date = new DateTime($currentElement['date']['date']);
            echo '<h2>' . $currentElement['title'] . '</h2><br>
            <span>' . $currentElement['author'] . ' ' . $date->format('Y-m-d') . '</span>
            <div class="content">' . $currentElement['content'] . '</div><br>';
        }
    }

    public function getPosts() :array
    {
        $data = file_get_contents('posts.json');
        $dataArray = json_decode($data, JSON_PRETTY_PRINT);
        return $dataArray;
    }
}