<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 26.01.2018
 * Time: 11:15
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $postedAt;

    /**
     * @var string
     * @ORM\Column(type="string", length=250, options={"default" : ""})
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $text;


    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->postedAt = new \DateTime();
        $this->name = '';
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Post
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPostedAt(): \DateTime
    {
        return $this->postedAt;
    }

    /**
     * @param \DateTime $postedAt
     * @return Post
     */
    public function setPostedAt(\DateTime $postedAt): Post
    {
        $this->postedAt = $postedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Post
     */
    public function setName(string $name): Post
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): ? string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Post
     */
    public function setText(?string $text): Post
    {
        $this->text = $text;
        return $this;
    }

  
    /**
     * @return null|string
     */
    public function getbeginOfText(): ?string
    {
        $beginOfText = '';
        $indexLastSymbol = 200;
        $str = $this->getText();

        if ( $indexLastSymbol >= (mb_strlen($str)-1)){
            $indexLastSymbol = mb_strlen($str) + 1;
        } else {
            while ( mb_substr($str, $indexLastSymbol, 1) != ' ' && $indexLastSymbol <= (mb_strlen($str)-1)){
                $indexLastSymbol += 1;
            }
        }

        $beginOfText = mb_substr($this->getText(), 0, ($indexLastSymbol+1));

        return $beginOfText;

    }






}