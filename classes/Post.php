<?php


class Post
{
    private string $title;
    private DateTime $date;
    private string $content;
    private string $author;

    public function __construct(string $title, string $content, string $author)
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->date = new DateTime();
        $this->date->setTimezone(new DateTimeZone('Europe/Brussels'));
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}