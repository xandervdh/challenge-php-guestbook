<?php
/* @var Post[] */

class PostLoader
{
    private array $posts = [];

    public function newPost(string $title, string $content, string $author)
    {
        array_push($this->posts, new Post($title, $content, $author));
        if (count($this->posts) > 20){
            array_shift($this->posts);
        }
        $data = file_get_contents('posts.json');
        $dataArray = json_decode($data, true);
        var_dump($dataArray);
        foreach ($dataArray as $key => $value)
        {
            if ($value['key'] == "0")
            {
                $arr_index[] = $key;
            }
        }

        foreach ($arr_index as $i)
        {
            unset($dataArray[$i]);
        }
        /*for ($i = 0; $i < 1000; $i++){
            unset($dataArray[$i]);
        }*/
        //if (isset($dataArray['posts'])){
        //unset($dataArray['posts']);
        //}

        for ($i = 0; $i < count($this->posts); $i++){
            array_push($dataArray ,['key' => 0, 'posts' => $this->posts[$i]->jsonSerialize()]);
        }
        $json = json_encode($dataArray);
        file_put_contents('posts.json', $json);
    }

    public function printPosts()
    {

        for ($i = count($this->posts)-1; $i >= 0 ; $i--){
            echo '<h2>' . $this->posts[$i]->getTitle() . '</h2><br>
            <span>' . $this->posts[$i]->getAuthor() . ' ' . $this->posts[$i]->getDate() . '</span>
            <div class="content">' . $this->posts[$i]->getContent() . '</div><br>';
        }
    }

    public function getPosts(){
        return $this->posts;
    }
}