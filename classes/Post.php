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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDate(): string
    {
        return $this->date->format('Y-m-d');
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

}