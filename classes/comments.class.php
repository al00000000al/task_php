<?php
/**
 * Class Comments
 */
class Comments{
    /**
     * @var $db - Database
     */
    private $db;

    /**
     * Comments constructor.
     * @param $db
     */
    public function __construct($db){
        $this->db = $db;
    }

    /**
     * @param $author string
     * @param $text string
     */
    public function saveComment($author, $text){
        if(mb_strlen($author) > 255){
            $author = substr($author, 0, 255);
        }

        if(mb_strlen($text) > 4096){
            $text = substr($text, 0, 4096);
        }

        $this->db->insert('comments',[
            "author" => $author,
            "text" => $text
        ]);
    }

    /**
     * @return array
     */
    private function getCommentsDB(){
        return  $this->db->select("comments",'*', ["ORDER" => [
            'created_at' => 'DESC'
        ]]);
    }

    /**
     *
     */
    public function getComments(){
        $res = '';
        $data = $this->getCommentsDB();
        foreach ($data as $item){
            $date = strtotime( $item['created_at'] );
            $res .= $this->sComment(
                htmlspecialchars($item['author'], ENT_QUOTES, 'UTF-8'),
                date("H:i", $date),
                date("d.m.Y", $date),
                htmlspecialchars($item['text'], ENT_QUOTES, 'UTF-8'));
        }
        echo $res;
    }

    /**
     * @param $name string
     * @param $time string
     * @param $date string
     * @param $comment string
     * @return string
     */
    private function sComment($name, $time, $date, $comment){
        return <<<HTML
<div class="comment">
            <div class="comment_header">
                <h3 class="comment_author">{$name}</h3>
                <div class="comment_time">{$time}</div>
                <div class="comment_date">{$date}</div>
            </div>
            <div class="comment_body">
                {$comment}
            </div>
        </div>
HTML;
    }
}