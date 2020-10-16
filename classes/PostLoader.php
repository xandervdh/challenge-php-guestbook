<?php
/* @var Post[] */

class PostLoader
{
    private array $posts = [];

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
        var_dump($this->posts);
        for ($i = 0; $i < count($this->posts); $i++) {
            array_push($dataArray, ['id' => $i, 'posts' => $this->posts[$i]->jsonSerialize()]);
        }
        $json = json_encode($dataArray);
        file_put_contents('posts.json', $json);
    }

    public function printPosts()
    {
        $posts = $this->getPosts();
        //get start index
        //var_dump($posts[0]);
        for (end($posts); key($posts) !== null; prev($posts)) {
            $currentElement = current($posts);
            $date = new DateTime($currentElement['posts']['date']['date']);
            echo '<h2>' . $currentElement["posts"]['title'] . '</h2><br>
            <span>' . $currentElement["posts"]['author'] . ' ' . $date->format('Y-m-d') . '</span>
            <div class="content">' . $currentElement["posts"]['content'] . '</div><br>';
        }
    }

    public function getPosts()
    {
        $data = file_get_contents('posts.json');
        $dataArray = json_decode($data, JSON_PRETTY_PRINT);
        var_dump($dataArray);
        //$this->posts = $dataArray;
        return $dataArray;
    }
}